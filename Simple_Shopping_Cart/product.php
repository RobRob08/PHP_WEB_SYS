<?php

include 'db_connect.php';

session_start();
$pdo = pdo_connect_mysql();

$search = $_GET['search'] ?? '';
$search_sql = $search ? 'WHERE(name LIKE "%":search"%") ': '';
$stmt = $pdo->prepare('SELECT * FROM products '.$search_sql.'');
if($search) $stmt->bindParam(':search', $search, PDO::PARAM_STR);
$stmt->execute();
$products =$stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$page_title = "Shopping Cart";
include 'theme_components/head.php';
include 'theme_components/topNav.php';
include 'theme_components/header.php';
include 'theme_components/login-Reg-modal.php';
include 'theme_components/mobile-accordion.php';
?>

<div class="container my-5">
    <h2 class="text-center mt-3 mb-5">All Products</h2>
    <?php if($products) {?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
        <?php foreach($products as $item_products) {?>
        <div class="col product-container">
        <div class="border shadow-none rounded ">
        <a href="#" class="category-card text-decoration-none text-dark" data-bs-toggle="modal" data-bs-target="#productModal"
            data-product-id="<?= $item_products['id'] ?>"
            data-product-name="<?= $item_products['name'] ?>"
            data-product-price="<?= $item_products['price'] ?>"
            data-product-image="<?= $item_products['image'] ?>"
            data-product-desc="<?= $item_products['product_desc'] ?>" >
            <div class="text-center">
                <img src="assets/images/<?= $item_products['image']?>" class="img-fluid" alt="">
            </div>
          </a>
            <div class="text-center">
                <h6 class="text-center"><?= $item_products['name']?></h6>
                <h5 class="text-center fw-normal"><?= number_format($item_products['price'], 2)?></h5>
                <?php if(isset($_SESSION['account_email'])) {?>
                <form method="POST" action="cart.php">
                    <button type="submit" name="add_to_cart" class="btn add-to-cart-btn btn-block mt-2 mb-4 px-5 py-0 rounded-pill text-light" value="<?= $item_products['id']?>"
                    title="Add to Cart">Add to <i class="bi bi-cart-fill"></i>
                </button>
                </form>
                <?php }else{?>
                    <div class=""></div>
                    <?php }?>
            </div>
            </div>
        </div>
        <?php }?>
    </div>
    <?php }else{?>
        <div class="row mt-5">
            <span class="text-center h4">Product Not Found</span>
        </div>
        <?php }?>
</div>

<?php 
include 'Products-info/modal-product.php';
?>

<?php

include 'theme_components/footer.php';

?>