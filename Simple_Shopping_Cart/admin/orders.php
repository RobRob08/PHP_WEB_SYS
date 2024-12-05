<?php

include '../db_connect.php';

session_start();


if (!isset($_SESSION['account_role']) || $_SESSION['account_role'] != 'Admin') {
    header('location: index.php');
    exit;
}

$pdo = pdo_connect_mysql();
$stmt = $pdo->query("SELECT * FROM orders"); // Fetching all orders
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$page_title = 'Admin Panel - Orders';
include '../theme_components/head.php';
include '../theme_components/admin-topNav.php'; 
?>
<style>
    .img-cart {
        display: block;
        max-width: 50px;
        height: auto;
    }

    <?php include '../CSS/styles.css'; ?>
</style>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-10 col-xxl-9">
            <h2 class="mt-3 mb-5">Admin Panel - Orders</h2>
            <div class="panel panel-info mb-5">
                <div class="panel-body">
                    <?php if ($orders): ?>
                        <div class="border table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Country</th>
                                        <th>Street Address 1</th>
                                        <th>Street Address 2</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Zip</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $i => $order): ?>
                                        <tr>
                                            <td><?= $i + 1 ?></td>
                                            <td><?= htmlspecialchars($order['first_name']) ?></td>
                                            <td><?= htmlspecialchars($order['last_name']) ?></td>
                                            <td><?= htmlspecialchars($order['email']) ?></td>
                                            <td><?= htmlspecialchars($order['country']) ?></td>
                                            <td><?= htmlspecialchars($order['street_address_1']) ?></td>
                                            <td><?= htmlspecialchars($order['street_address_2']) ?></td>
                                            <td><?= htmlspecialchars($order['city']) ?></td>
                                            <td><?= htmlspecialchars($order['state']) ?></td>
                                            <td><?= htmlspecialchars($order['zip']) ?></td>
                                            <td><?= htmlspecialchars($order['created_at']) ?></td>
                                          
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="py-3 text-center fs-5">No Orders</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>