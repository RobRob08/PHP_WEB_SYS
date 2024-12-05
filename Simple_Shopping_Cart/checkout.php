<?php
include 'db_connect.php';
include 'country_iso.php';

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

// Check if user is logged in
if (!isset($_SESSION['account_email'])) {
    header('Location: login.php');  // Redirect to login if not logged in
    exit;
}

$pdo = pdo_connect_mysql();

// Fetch account details from database
$stmt = $pdo->prepare('SELECT * FROM accounts WHERE email = ?');
$stmt->execute([$_SESSION['account_email']]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle address update if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_address'])) {
    // Get the submitted address details from the form
    $first_name = $_POST['first_name'] ?? $account['first_name'];  // Default to current value if not set
    $last_name = $_POST['last_name'] ?? $account['last_name'];
    $email = $_POST['email'] ?? $account['email'];
    $country = $_POST['country'] ?? $account['country'];
    $street_address_1 = $_POST['street_address_1'] ?? $account['street_address_1'];
    $street_address_2 = $_POST['street_address_2'] ?? $account['street_address_2'];
    $city = $_POST['city'] ?? $account['city'];
    $state = $_POST['state'] ?? $account['state'];
    $zip = $_POST['zip'] ?? $account['zip'];

    // Insert the order into the database
    try {
        $stmt = $pdo->prepare('INSERT INTO orders (first_name, last_name, email, country, street_address_1, street_address_2, city, state, zip, created_at) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())');
        $stmt->execute([
            $first_name,
            $last_name,
            $email,
            $country,
            $street_address_1,
            $street_address_2,
            $city,
            $state,
            $zip
        ]);

        // Set a success message
        $error = 'Order placed successfully!';
    } catch (Exception $e) {
        $error = 'Error placing order: ' . $e->getMessage();
    }
}

// Fetch cart products from database for the logged-in user
$stmt = $pdo->prepare('SELECT c.quantity, p.name, p.price, p.image, p.sku FROM carts c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?');
$stmt->execute([$_SESSION['account_id']]);
$cart_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// If the cart is empty, redirect to the home page
if (empty($cart_products)) {
    header('location: index.php');
    exit;
}

// Fetch the total price of the cart
$price_total = 0;
foreach ($cart_products as $item) {
    $price_total += $item['price'] * $item['quantity'];
}

$msg = $_GET['msg'] ?? null;
ob_start();
?>

<?php
$page_title = "Shopping Cart - My Cart";
include 'theme_components/head.php';
include 'theme_components/topNav.php'; 
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11 col-xl-10 col-xxl-9">
            <h2 class="mt-3 mb-5">Checkout</h2> 
            <div class="row">
                <div class="col-md-4 order-md-4 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted"> Your Cart</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <?php foreach ($cart_products as $item): ?>
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <span class="fw-bolder"><?= $item['name'] ?> &nbsp;</span>
                                <span class="text-muted">(<?= $item['quantity'] ?>) &nbsp;</span>
                                <span class="text-muted">
                                    $<?= number_format($item['price'] * $item['quantity'], 2) ?>
                                </span>
                            </li>
                        <?php endforeach ?>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (USD)</span>
                            <strong>$<?= number_format($price_total, 2) ?></strong>
                        </li>
                    </ul>
                </div>

                <div class="col-md-8 order-md-1 mb-5">
                    <h4 class="mb-3">Billing address</h4>
                    <form action="" method="POST" class="mb-4" id="checkout-form">
                        <?php if ($error): ?>
                            <div class="alert alert-success"><?= $error ?></div>
                        <?php endif; ?>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="first_name">First Name</label>
                                <input type="text" value="<?= htmlspecialchars($first_name ?? $account['first_name'], ENT_QUOTES) ?>"
                                       name="first_name" class="form-control" id="first_name" placeholder="e.g John" required=""/>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="last_name">Last Name</label>
                                <input type="text" value="<?= htmlspecialchars($last_name ?? $account['last_name'], ENT_QUOTES) ?>"
                                       name="last_name" class="form-control" id="last_name" placeholder="e.g Smith" required=""/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="email">Email Address</label>
                                <input type="email" value="<?= htmlspecialchars($email ?? $account['email'], ENT_QUOTES) ?>"
                                       name="email" class="form-control" id="email" placeholder="e.g you@example.com" required=""/>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="country">Country</label>
                                <select name="country" id="country" class="form-select" aria-label="Default select example">
                                    <option class="text-muted">Select Country</option>
                                    <?php foreach ($countries as $country_name => $iso): ?>
                                        <option value="<?= $iso ?>" <?= $iso == ($country ?? $account['country']) ? 'selected' : '' ?>><?= $country_name ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="street_address_1">Street address 1</label>
                                <input type="text" value="<?= htmlspecialchars($street_address_1 ?? $account['street_address_1'], ENT_QUOTES) ?>"
                                       class="form-control" placeholder="e.g. 1234 Main St" name="street_address_1" id="street_address_1" required=""/>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="street_address_2">Street address 2 <span class="text-muted">(Optional)</span></label>
                                <input type="text" value="<?= htmlspecialchars($street_address_2 ?? $account['street_address_2'], ENT_QUOTES) ?>"
                                       class="form-control" placeholder="e.g. Apartment or Suite" name="street_address_2" id="street_address_2"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 mb-4">
                                <label for="city">City</label>
                                <input type="text" value="<?= htmlspecialchars($city ?? $account['city'], ENT_QUOTES) ?>"
                                       class="form-control" placeholder="e.g. Any Town" name="city" id="city" required=""/>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="state">State</label>
                                <input type="text" value="<?= htmlspecialchars($state ?? $account['state'], ENT_QUOTES) ?>"
                                       class="form-control" placeholder="e.g. Any State" name="state" id="state" required=""/>
                            </div>
                            <div class="col-md-3 mb-4">
                                <label for="zip">ZIP code</label>
                                <input type="text" value="<?= htmlspecialchars($zip ?? $account['zip'], ENT_QUOTES) ?>"
                                       class="form-control" placeholder="e.g. 12345" name="zip" id="zip" required=""/>
                            </div>
                        </div>

                        <hr class="mb-3">
                        <h4 class="mb-3">Payment method</h4>
                        <div class="d-block my-3">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" value="cod" name="pay_method" id="cod-method" checked/>
                                <label for="cod-method" class="form-check-label">
                                    Cash On Delivery
                                </label>
                            </div>
                        </div>
                        <hr class="mb-4">
                        <button type="submit" name="save_address" class="btn btn-secondary w-100 mt-3">
                            Save Address
                        </button>
                    </form>
                    
                    <!-- Place Order Button -->
                    <form action="" method="POST">
                        <button type="button" class="btn btn-primary w-100 mt-3" id="showOrderConfirmation">
                            Confirm Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Order Confirmation -->
<div class="modal fade" id="orderConfirmationModal" tabindex="-1" aria-labelledby="orderConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderConfirmationModalLabel">Confirm Your Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4>Review Your Order</h4>
        <ul class="list-group mb-3" id="orderSummaryList">
          <!-- Order items will be injected here using JavaScript -->
        </ul>
        <div class="d-flex justify-content-between">
          <strong>Total:</strong>
          <span id="orderTotal"></span>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmOrderButton">Confirm Order</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Listen for the "Confirm Order" button click (triggering the modal)
  document.getElementById('showOrderConfirmation').addEventListener('click', function() {
    const cartItems = <?php echo json_encode($cart_products); ?>;
    const orderTotal = <?php echo json_encode($price_total); ?>;

    // Populate the modal with cart items and total
    const orderSummaryList = document.getElementById('orderSummaryList');
    orderSummaryList.innerHTML = ''; // Clear existing items
    cartItems.forEach(item => {
      const li = document.createElement('li');
      li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'lh-condensed');
      li.innerHTML = `
        <span class="fw-bolder">${item.name} (x${item.quantity})</span>
        <span class="text-muted">$${(item.price * item.quantity).toFixed(2)}</span>
      `;
      orderSummaryList.appendChild(li);
    });

    // Show the total in the modal
    document.getElementById('orderTotal').textContent = `$${orderTotal.toFixed(2)}`;

    // Show the modal
    $('#orderConfirmationModal').modal('show');
  });

  // Handle the actual order confirmation when the user clicks "Confirm Order"
  document.getElementById('confirmOrderButton').addEventListener('click', function() {
    const form = document.getElementById('checkout-form');
    
    // Close the modal
    $('#orderConfirmationModal').modal('hide');

    // Submit the form to process the order
    form.submit();
  });
</script>

<?php
include 'theme_components/footer.php';
?>
