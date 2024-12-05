<?php
    include 'db_connect.php';

    session_start();
    $pdo = pdo_connect_mysql();

    if(isset($_POST['update'], $_POST['quantity'],$_SESSION['cart']) && is_array($_POST['quantity'])){
        foreach($_POST['quantity'] as $item => $item_quantity){
            if(isset($_SESSION['cart'][$item])) {
                $_SESSION['cart'][$item]['quantity'] = $item_quantity;
            }   
        }
    }

    if(isset($_POST['remove'],$_SESSION['cart'])){
        $item_remove = $_POST['remove'];
        array_splice($_SESSION['cart'], $item_remove, 1);
    }

    if(isset($_POST['delete_all'])){
       unset($_SESSION['cart']); 
    }

    if(isset($_POST['add_to_cart'])){
        $product_id = $_POST['add_to_cart'];
        $item_cart = &get_cart_product($product_id);

        if($item_cart){
           $item_cart['quantity']++; 
        } else {
          $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
          $stmt->execute([$product_id]);
          $product = $stmt->fetch(PDO::FETCH_ASSOC);
          
          $_SESSION['cart'][] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'image' => $product['image'],
            'sku' => $product['sku'],
            'quantity' => 1
          ];
        }
        header("Location: cart.php");
        exit;
    }

    function &get_cart_product($id){
        $null = null;
        if(isset($_SESSION['cart'])){
            $item = array_search($id, array_column($_SESSION['cart'],'id'));
            if($item !== false){
                return $_SESSION['cart'][$item];
            }
        }
        return $null;
    }

    $cart_products = $_SESSION['cart'] ?? [];
?>

<?php
$page_title = "Shopping Cart - My Cart";
include 'theme_components/head.php';
include 'theme_components/topNav.php';
include 'theme_components/header.php';    


?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11 col-xl-10 col-xxl-9">
            <h2 class="mt-3 mb-5">Cart</h2>
            <form action="" method="POST">
               <div class="panel panel-info panel-shadow mb-5">
                <div class="panel-body">
                  <?php if($cart_products): ?>
                    <div class="border table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">Product</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                </tr> 
                            </thead>
                            <tbody>
                                <?php $price_total = 0 ?>
                                <?php foreach ($cart_products as $item => $item_cart):?>
                                    <tr class="align-middle">
                                       <td><img class="img-cart" src="/assets/images/<?= $item_cart['image'];?>" alt="<?= $item_cart['name']?>"></td> 
                                       <td><strong><?=$item_cart['name'];?></strong></td>
                                       <td>$<?= number_format($item_cart['price'],2)?></td>
                                       <td class="col-2">
                                        <input style="max-width: 80px; ,min-width: 80px;"
                                        type="number" 
                                        name="quantity[<?= $item?>]" 
                                        min="1" 
                                        value="<?= $item_cart['quantity']?>"
                                        class="form-control rounded-start"
                                        placeholder="e.g. 1" >
                                       </td>$
                                       <?php $sub_total = $item_cart['price'] * $item_cart['quantity'];
                                       echo number_format($sub_total, 2);
                                       ?>
                                       <td>
                                        <button type="submit" name="remove" value="<?= $item?>" class="btn btn-outline-danger" title="Remove product"><i class="bi bi-trash-fill"></i></button>
                                       </td>
                                    </tr>

                                    <?php $price_total += $sub_total?>
                                    <?php endforeach ?>
                                    <tr>
                                        <td colspan="6"></td>
                                    </tr>

                                    <tr class="align-middle">
                                        <td colspan="3"></td>
                                         <td><strong>Total</strong></td>
                                         <td><?= number_format($price_total,2)?></td>
                                         <td>
                                            <button type="submit" name="delete_all" class="btn btn-link link-danger px-0" onclick="return confirm('are you sure you want to delte all');">Delete All</button>
                                         </td>

                                    </tr>
                            </tbody>
                        </table>
                    </div>

                    <?php else:?>
                        <p class="pb-5 text-center fs-5"> Cart is Empty</p>
                    <?php endif?>
                </div>
               </div>
                <a href="index.php" class="btn btn-outline-dark rounded-pill me-4 mb-4"><i class="bi-arrow-left"></i> Continue Shopping</a>
                <button type="submit" name="update" class="btn btn-outline-dark rounded-pill me-4 mb-4">Update Cart</button>
                <a href="checkout.php" class="btn btn-warning mb-4 rounded-pill pull-right<?= $cart_products ? "": "disabled"?>">Proceed to Checkout</a>
            </form>
        </div>
    </div>
</div>

<?php

include 'theme_components/footer.php';

?>
