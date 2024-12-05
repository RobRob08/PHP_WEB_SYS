<?php
$pdo = pdo_connect_mysql();

// Check if the product exists in the cart, then update quantity, otherwise insert new entry
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['add_to_cart'];
    $user_id = $_SESSION['account_id'];  // Or use user-specific identification

    // Check if the product is already in the cart for this user
    $stmt = $pdo->prepare('SELECT * FROM carts WHERE user_id = ? AND product_id = ?');
    $stmt->execute([$user_id, $product_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_item) {
        // Product already in cart, update quantity
        $stmt = $pdo->prepare('UPDATE carts SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?');
        $stmt->execute([$user_id, $product_id]);
    } else {
        // Product not in cart, insert a new entry
        $stmt = $pdo->prepare('INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)');
        $stmt->execute([$user_id, $product_id, 1]);
    }
}
?>

<?php
$pdo = pdo_connect_mysql();

// Get all cart items for the logged-in user
$user_id = $_SESSION['account_id'];  // Or any method to retrieve the current user's ID
$stmt = $pdo->prepare('
    SELECT c.quantity, p.name, p.price, p.image, p.sku
    FROM carts c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = ?
');
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
if (isset($_POST['remove'])) {
    $sku = $_POST['remove'];
    $stmt = $pdo->prepare('DELETE FROM carts WHERE user_id = ? AND product_id = (SELECT id FROM products WHERE sku = ?)');
    $stmt->execute([$_SESSION['account_id'], $sku]);
}
?>


<?php
if (isset($_POST['update'], $_POST['quantity'])) {
    foreach ($_POST['quantity'] as $sku => $quantity) {
        $stmt = $pdo->prepare('
            UPDATE carts 
            SET quantity = ? 
            WHERE user_id = ? AND product_id = (SELECT id FROM products WHERE sku = ?)
        ');
        $stmt->execute([$quantity, $_SESSION['account_id'], $sku]);
    }
}
?>


<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasRightLabel">Cart</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col">
          <form action="" method="POST">
            <div class="panel panel-info panel-shadow mb-5">
              <div class="panel-body">
                <?php if($cart_items): ?>
                  <div class="table-responsive">
                    <table class="table table-borderless">
                      <tbody>
                        <?php $price_total = 0 ?>
                        <?php foreach ($cart_items as $item): ?>
                          <tr class="align-middle">
                            <td><img class="img-cart" src="assets/images/<?= $item['image']?>" alt="<?= $item['name']?>"> </td>
                            <td><?= $item['name'] ?></td>
                            <td>
                              <p>$<?= number_format($item['price'], 2) ?></p>
                              <input style="max-width: 50px;" type="number" name="quantity[<?= $item['sku'] ?>]" min="1" value="<?= $item['quantity'] ?>" class="form-control rounded-start" placeholder="e.g. 1" >
                            </td>
                            <td>
                              <?php $sub_total = $item['price'] * $item['quantity']; ?>
                              <button type="submit" name="remove" value="<?= $item['sku'] ?>" class="btn" title="Remove product"><i class="bi bi-trash-fill"></i></button>
                            </td>
                          </tr>
                          <?php $price_total += $sub_total ?>
                        <?php endforeach ?>
                      </tbody>
                    </table>
                  </div>
                  <button type="submit" name="delete_all" class="btn btn-link link-danger px-0" onclick="return confirm('Are you sure you want to delete all?');">Delete All</button>
                  <br>
                  <strong>Total</strong> $<?= number_format($price_total, 2) ?>
                <?php else: ?>
                  <p class="pb-5 text-center fs-5"> Cart is Empty</p>
                <?php endif ?>
              </div>
            </div>
            <button type="submit" name="update" class="btn add-to-cart-btn  rounded-pill me-4 mb-4">Update Cart</button>
            <a href="checkout.php" class="btn add-to-cart-btn me-4 mb-4 rounded-pill pull-right<?= $cart_items ? "" : "disabled" ?>">Checkout</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
