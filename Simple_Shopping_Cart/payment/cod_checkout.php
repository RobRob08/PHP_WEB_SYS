<?php
include 'db_connect.php'; // Include your DB connection
include 'country_iso.php'; // Include your country ISO data if needed

session_start();

$error = '';
$account = [
    'email' => '',
    'first_name' => '',
    'last_name' => '',
    'country' => '',
    'street_address_1' => '',
    'street_address_2' => '',
    'city' => '',
    'state' => '',
    'zip' => ''
];

// Check if the user is logged in
if(!isset($_SESSION['account_email'])) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'You must be logged in to place an order.'
    ]);
    exit;
}

$user_id = $_SESSION['account_id'];  // Assuming you store user_id in session

$pdo = pdo_connect_mysql();

// Fetch account details from the database
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE email = ?');
$stmt->execute([$_SESSION['account_email']]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

// Fetch cart products from the database for the logged-in user
$stmt = $pdo->prepare('SELECT c.quantity, p.name, p.price, p.image, p.sku FROM carts c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?');
$stmt->execute([$user_id]);
$cart_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If the cart is empty, return an error
if (empty($cart_products)) {
    echo json_encode([
        'status' => 'error',
        'msg' => 'Your cart is empty.'
    ]);
    exit;
}

// Calculate total price
$price_total = 0;
foreach ($cart_products as $item) {
    $price_total += $item['price'] * $item['quantity'];
}

$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$country = $_POST['country'] ?? '';
$street_address_1 = $_POST['street_address_1'] ?? '';
$street_address_2 = $_POST['street_address_2'] ?? '';
$city = $_POST['city'] ?? '';
$state = $_POST['state'] ?? '';
$zip = $_POST['zip'] ?? '';
$pay_method = $_POST['pay_method'] ?? 'cod';

// Combine the address fields into one string
$shipping_address = "$street_address_1, $street_address_2, $city, $state, $zip, $country";

// Insert order into the database (corrected table name: `order`)
try {
    // Adjusted INSERT query based on your table columns (correct table name: `order`)
    $stmt = $pdo->prepare('INSERT INTO `order` (user_id, total_amount, shipping_address, payment_method, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())');
    $stmt->execute([
        $user_id,
        $price_total,
        $shipping_address,
        $pay_method,
        'pending'  // Status for the order (you can update it later if needed)
    ]);
    
    $order_id = $pdo->lastInsertId(); // Get the inserted order ID

    // Insert cart items into order_items table (if you want to keep track of products in the order)
    foreach ($cart_products as $item) {
        $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
        $stmt->execute([
            $order_id,
            $item['product_id'],
            $item['quantity'],
            $item['price']
        ]);
    }

    // Clear the cart after successful order placement (optional)
    $stmt = $pdo->prepare('DELETE FROM carts WHERE user_id = ?');
    $stmt->execute([$user_id]);

    // Return a success response with order details
    echo json_encode([
        'status' => 'success',
        'details' => [
            'order_id' => $order_id,
            'total' => number_format($price_total, 2),
            'payment_method' => $pay_method,
            'shipping_address' => $shipping_address,
            'items' => $cart_products
        ]
    ]);

} catch (Exception $e) {
    // If an error occurs, return an error response
    echo json_encode([
        'status' => 'error',
        'msg' => 'An error occurred while processing your order. Please try again later.'
    ]);
}
?>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const placeOrderButton = document.querySelector("button[name='order']");  // Select the "Place Order" button
    const codRadio = document.getElementById("cod-method");
    const modalEl = document.querySelector("#staticBackdrop");
    const modalBody = modalEl.querySelector(".modal-body");
    const form = document.querySelector("form");

    // Handle the button click to prevent form submission and call orderCod function
    placeOrderButton.addEventListener("click", function(event) {
        event.preventDefault();  // Prevent the form from being submitted

        orderCod();  // Call the orderCod function
    });

    // Function to handle 'Cash On Delivery' order submission
    function orderCod() {
        const formData = new FormData(form);

        fetch("payment/cod_checkout.php", {
            method: "POST",
            headers: { "Accept": "application/json" },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();  // Get the response as plain text
        })
        .then(responseText => {
            try {
                const result = JSON.parse(responseText);  // Try to parse the response as JSON
                if (result.status === "success") {
                    showModal(modalBody, result.details);  // Show modal with transaction details
                } else {
                    alertContent(result.msg);  // Show error message
                }
            } catch (error) {
                // Handle case when the response is not valid JSON
                console.error("Invalid JSON response:", error);
                alertContent("An error occurred while processing the order.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alertContent("An error occurred while processing the order.");
        });
    }

    // Function to display modal with transaction details
    function showModal(modalBody, details) {
        modalBody.innerHTML = ''; // Clear any previous content

        // Loop through the details and display each field
        Object.keys(details).forEach(key => {
            if (details[key] && typeof details[key] !== 'object') {
                let displayName = key.charAt(0).toUpperCase() + key.slice(1).replace(/_/g, ' ');
                modalBody.innerHTML += `<p><strong>${displayName}:</strong> ${details[key]}</p>`;
            }
        });

        // Initialize and show the modal
        const modal = new bootstrap.Modal(modalEl);  // Initialize modal
        modal.show();  // Show modal
    }

    // Function to show alert content if there's an error
    function alertContent(msg) {
        const alertContent = document.querySelector(".alert-danger");
        alertContent.classList.add("show");
        const text = alertContent.querySelector("span");
        text.textContent = msg;
        setTimeout(() => {
            alertContent.classList.remove("show");
            text.textContent = ""; 
        }, 7000);
    }
});
</script>
