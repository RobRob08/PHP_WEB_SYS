<?php

include '../db_connect.php';

session_start();

if(!isset($_SESSION['account_role'])|| $_SESSION['account_role']!= 'Admin'){
    header('location: index.php');
    exit;

}

$pdo = pdo_connect_mysql();
$message = '';
$msg_code = [
    'pr_add' => 'Product add Successfully',
    'pr_update' => 'Product update Successfully',
    'pr_remove' => 'Product has been removed'

];

if (isset($_POST['update'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_FILES['product_image']['name'] ? $_FILES['product_image']['name'] : $_POST['old_image'];
    $productDesc = $_POST['product_desc']; 


    if ($_FILES['product_image']['name']) {
        move_uploaded_file($_FILES['product_image']['tmp_name'], "../assets/images/" . $productImage);
    }

    $stmt = $pdo->prepare('UPDATE products SET name = ?, price = ?, image = ?, product_desc = ? WHERE id = ?');
    $stmt->execute([$productName, $productPrice, $productImage, $productDesc, $productId]);

    header('Location: products.php?msg=pr_update');
    exit;
?>
<script type="text/javascript">
    window.location.href=window.location.href;
</script>
<?php
}

if(isset($_POST['add'])) {
    $productName = $_POST['product_name'];
    $productPrice = $_POST['product_price'];
    $productImage = $_POST['product_image'];
    $productDesc = $_POST['product_desc'];

    // Insert the new product into the database
    $stmt = $pdo->prepare('INSERT INTO products (name, price, image, product_desc) VALUES (?, ?, ?, ?)');
    $stmt->execute([$productName, $productPrice, $productImage, $productDesc]);

    header('Location: products.php?msg=pr_add');
    exit;
?>
<script type="text/javascript">
    window.location.href=window.location.href;
</script>
<?php
}
if (isset($_POST['remove'])) {
    $productId = $_POST['product_id'];

    $stmt = $pdo->prepare('DELETE FROM products WHERE id = ?');
    $stmt->execute([$productId]);

    header('Location: products.php?msg=pr_remove');
    exit;
?>
<script type="text/javascript">
    window.location.href=window.location.href;
</script>
<?php
}

if(isset($_GET['msg'])&& isset($msg_code[$_GET['msg']]) ){
    $message = $msg_code[$_GET['msg']];

}
$stmt = $pdo->query('SELECT * FROM products');
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
$page_title = 'Admin Page';
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
            <h2 class="mt-3 mb-5">Admin Panel</h2>
            <button class="btn btn-primary mb-2" type="button" data-bs-toggle="modal" data-bs-target="#addProductModal">Add New Product</button>

            <div class="panel panel-info mb-5">
                <div class="panel-body">
                    <?php if($products): ?>
                        <div class="border table-responsive">
                            
                            <table class="table">
                                <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach($products as $i => $item_product ):?>
                                    <tr>
                                        <td><?= $i+1 ?></td>
                                        <td><img class="img-cart" src="../assets/images/<?= $item_product['image']?>" alt="<?= $item_product['name']?>"></td>
                                        <td><strong><?= $item_product['name']?></strong></td>
                                        <td><?= number_format($item_product['price'],2)?></td>
                                        <td>
                                        <form action="products.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $item_product['id'] ?>" />
                                            
                                            <button type="submit" name="remove" class="btn btn-danger btn-sm" title="Remove">
                                            <i class="bi bi-trash-fill"></i>
                                            </button>
                                          
                                            <a href="#" 
                                                class="btn btn-primary" 
                                                role="button" 
                                                data-product-id="<?= $item_product['id'] ?>" 
                                                data-product-name="<?= $item_product['name'] ?>" 
                                                data-product-price="<?= $item_product['price'] ?>" 
                                                data-product-image="<?= $item_product['image'] ?>" 
                                                data-product-desc="<?= $item_product['product_desc'] ?>"  
                                            >
                                                Edit
                                            </a>
                                        </form>
                                    </td>
                                    </tr>
                                    <?php endforeach?>
                                </tbody>
                            </table>
                        </div>
                       <?php else:?>
                        <p class="py-3 text-center fs-5">No Product Added</p>
                       <?php endif ?> 
                </div>
            </div>
        </div>
        <?php if($message):?>
            <div class="toast-container">
                <div 
                class="toast bg-success text-white" 
                id="liveToast"
                 data-bs-delay="3000"
                 style="--bs-bg-tertiary: .8;"
                 roles="alert"
                 aria-live="assertive"
                 aria-atomic="true"
                 >
                <div class="d-flex">
                    <div class="toast-body">
                        <?= $msg_code[$_GET['msg']]?>
                    </div>
                    <button type="button" 
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast"
                    aria-label="Close"></button>
                </div>
                </div>
            </div>

            <script>
                const toastLive = document.getElementById('liveToast');
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive);
                toastBoostrap.show();

            </script>
            <?php endif ?>
    </div>

</div>

<script>
    document.querySelectorAll('.btn-primary[data-product-id]').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default anchor behavior
        
        // Get the product details
        const productId = this.getAttribute('data-product-id');
        const productName = this.getAttribute('data-product-name');
        const productPrice = this.getAttribute('data-product-price');
        const productImage = this.getAttribute('data-product-image');
        const productDesc = this.getAttribute('data-product-desc'); // Get the description

        // Populate the modal fields
        document.getElementById('modalProductId').value = productId;
        document.getElementById('modalProductName').value = productName;
        document.getElementById('modalProductPrice').value = productPrice;
        document.getElementById('modalProductImg').src = '../assets/images/' + productImage;
        document.getElementById('modalProductDesc').value = productDesc; // Set the description

        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('productModal'));
        modal.show();
    });
});


</script>

<?php
include 'add_product.php';
include 'edit_product.php';
?>


<?php


?>
