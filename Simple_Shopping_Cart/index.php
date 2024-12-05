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
include 'theme_components/login-Reg-modal.php';
include 'theme_components/mobile-accordion.php';
include 'theme_components/carousel.php';
?>


<div class="container d-flex justify-content-center my-5">
<h1 class="justify-content-between text-align-center">Shop by Category</h1>
</div>

<div class="container justify-content-between border-0 shadow-none">  
<div class="row">
  <div class="col-md-4">
    <a href="product.php" class="category-card">
    <div class="card">
      <img src="assets/model/Eye_Model.png" class="card-img img-fluid" alt="...">
      <div class="card-img-overlay">
        <h5 class="card-title">eyes</h5>
      </div>
    </div>
    </a>
  </div>

  <div class="col-md-4">
    <a href="product.php" class="category-card">
    <div class="card">
      <img src="assets/model/Face_model.png" class="card-img img-fluid" alt="...">
      <div class="card-img-overlay">
        <h5 class="card-title">Face</h5>
      </div>
    </div>
</a>

  </div>
  <div class="col-md-4">
    <a href="product.php" class="category-card">
    <div class="card">
      <img src="assets/model/Lips_Model.png" class="card-img img-fluid" alt="...">
      <div class="card-img-overlay">
        <h5 class="card-title">lips</h5>
      </div>
    </div>
  </a>
  </div>
</div>
</div>


<div class="container my-5">
  <div class="container-fluid my-5">
    <div class="row my-3 d-flex justify-content-center">
      <div class="col-md-6">
        <img src="assets/new_arrival.png" class="img-fluid" alt="">
      </div>
      <div class="col-md-6 justify-content-center d-flex my-2">
        <div class="container-lg container-new">
          <h3 class="text-align-center">Discover What is New</h3>
          <p>Items are Beauty & Carts Newest Products</p>
        </div>
      </div>
    </div>
  </div>
  <?php if($products) { ?>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-3">
        <?php 
        $limit = 0;
        foreach($products as $item_products) {
            if ($limit >= 5) break;
        ?>
        <div class="col product-container border-none shadow-none">
    <div class="border shadow-none rounded">
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
                <h6 class="text-center"><?= $item_products['name'] ?></h6>
                <h5 class="text-center fw-normal"><?= number_format($item_products['price'], 2) ?></h5>
                <?php if (isset($_SESSION['account_email'])) { ?>
                    <form method="POST" action="">
                        <button type="submit" name="add_to_cart" class="btn add-to-cart-btn btn-block mt-2 mb-4 px-5 py-0 rounded-pill text-light" value="<?= $item_products['id']?>" title="Add to Cart">Add to <i class="bi bi-cart-fill"></i></button>
                    </form>
                <?php } ?>
            </div>
        
    </div>
</div>
        <?php 
            $limit++;
        } ?>
    </div>
<?php } else { ?>
    <div class="row mt-5">
        <span class="text-center h4">Product Not Found</span>
    </div>
<?php } ?>

</div>

<?php 
include 'Products-info/modal-product.php';
?>

<?php
include 'carts.php';
?>

<?php

include 'theme_components/footer.php';

?>
