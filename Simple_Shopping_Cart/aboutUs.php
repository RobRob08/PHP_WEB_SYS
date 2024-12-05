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
?>
<div class="container-lg py-5 text-center">
        <h1 id="about-us" class="align-items-center text-align-center"> 
            About Us      
            <br>      
            <br>            
            <img src="assets/images/lipgloss_swatch.gif" class="img-fluid mx-auto d-block"  alt="lipgloss_swatch"> 
        </h1>
        <br>   
        <p id="about-us2"> 
             Beauty & Carts
        </p> 
        <div class="container-sm">            
          <p id="bout-us_3"> 
            Beauty & Carts is a local Filipino make-up brand that started in 2024. 
            B&C aspires to create products that are long-lasting, light-weight, and 
            catered to the natural beauty of Filipinos. 
        </p>
        <div class="container-md ">
          <img src="assets/images/orig1.png" class="img-fluid mx-auto d-block" alt="vision">  
        </div>
        <div class="container-md">
          <img src="assets/images/orig2.png" class="img-fluid mx-auto d-block" alt="vision">  
        </div>
        <div class="container-md">
          <img src="assets/images/orig3.png" class="img-fluid mx-auto d-block" alt="vision">  
        </div>                                  
      </div>
    </div>

    <?php

include 'theme_components/footer.php';

?>