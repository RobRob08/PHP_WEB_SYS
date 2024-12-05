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

if(isset($_POST['remove'])){
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
?>