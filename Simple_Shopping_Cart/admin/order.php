<?php

include '../db_connect.php';

session_start();

if(!isset($_SESSION['account_role'])|| $_SESSION['account_role']!= 'Admin'){
    header('location: index.php');
    exit;

}

$pdo = pdo_connect_mysql();
$order_id = null;
$item_order = [];
$pay_method ='';

if(isset($_GET['id'])){
    $order_id = $_GET['id'];
} else {
    echo 'ID parameter undefined';
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM transactions WHERE id = ?');
$stmt->execute([$order_id]);
$item_order = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = $pdo->prepare('SELECT ti.* p.* FROM transactions ti LEFT JOIN products p  ON p.sku = t.sku WHERE ti.txn_id = ? ');
$stmt->execute([$item_order['txn_id']]);
$order_products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$pay_method = $item_order['pay_method'] == 'cod' ? 'Cash On Delivery' : $item_order['pay_method'];
?>

<?php
$page_title = 'Admin Panel - Orders Details';
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

<div class="container_fluid">
    <div class="row justify-content-center">
        <div class="col-lg-11 col-xl-10 col-xxl-9">
        <h2 class="mt-3 mb-5">Admin Panel - Orders</h2>
        <div class="panel panel-info mb-5">
           <div class="panel-body">
            <div class="border table-responsive">
                <table class="table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Imagge</th>
                            <th>Name</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($order_products):?>
                        <?php foreach($order_products as $i => $item_order_product):?>
                            <tr class="align-middle">
                                <td><?= $i + 1?></td>
                                <td><img src="/assets.images/<?=$item_order_product['image']?>" alt="<?= $item_order_product['name']?>" class="img-cart"></td>
                                <td><?= $item_order_product['name']?></td>
                                <td><?= $item_order_product['quantity']?></td>
                            </tr>
                           <?php endforeach?> 
                           <?php else:?>
                            <?= "No order Products"?>
                            <?php endif?>
                    </tbody>
                </table>

                <table class="table">
                    <tbody>
                        <tr>
                            <td rowspan="2">
                               Addrress Shipping<br>
                                <?= $item_order['shipping_name']?><br>
                                <?= $item_order['shipping_address_line']?><br>
                                <?= $item_order['shipping_city']?><br>
                                <?= $item_order['shipping_state']?><br>
                                <?= $item_order['shipping_zip'].','. $item_order['shipping_country']?><br>
                            </td>
                            <td>
                               Payment Method<br>
                               <?= $pay_method ?>

                            </td>
                            <td>
                                Date Order<br>
                                <?= $item_order['created']?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Status<br>
                                <?= $item_order['payment_status']?>
                            </td>
                            <td>
                                Transaction ID
                                <?= $item_order['txn_id']?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email<br>
                                <?= $item_order['email']?>
                            </td>
                            <td>
                                Payment Amount<br>
                                <?= $item_order['paid_amount']?>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
           </div> 
        </div>
        <div>
            <a href="orders.php" class="btn btn-secondary" role="button">Return to Orders</a>
        </div>
        </div>
    </div>
</div>