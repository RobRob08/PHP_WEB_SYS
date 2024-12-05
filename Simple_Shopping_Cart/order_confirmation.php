<?php
include 'db_connect.php';

// Get the order ID from the URL
$orderId = $_GET['id'] ?? null;

if ($orderId) {
    // Fetch the order details from the database
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // If no order ID is provided, redirect to the homepage
    header('Location: index.php');
    exit;
}

?>

<?php include 'theme_components/head.php'; ?>
<?php include 'theme_components/topNav.php'; ?>

<div class="container">
    <h2>Order Confirmation</h2>
    <p>Thank you for your order! Your order ID is <strong><?= $order['id'] ?></strong>.</p>
    <p><strong>Order Details:</strong></p>
    <p>Name: <?= $order['first_name'] ?> <?= $order['last_name'] ?></p>
    <p>Email: <?= $order['email'] ?></p>
    <p>Address: <?= $order['street_address_1'] ?>, <?= $order['street_address_2'] ? $order['street_address_2'] . ',' : '' ?> <?= $order['city'] ?>, <?= $order['state'] ?> <?= $order['zip'] ?></p>
    <p>Total: $<?= number_format($price_total, 2) ?></p>
    <p>Order placed on: <?= $order['created_at'] ?></p>
</div>

<?php include 'theme_components/footer.php'; ?>
