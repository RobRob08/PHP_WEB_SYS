<?php

if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];  // Initialize as an empty array if it's not set
}

$cart_length = 0;
if(isset($_SESSION['cart'])){
    $cart_length = array_sum(array_column($_SESSION['cart'],'quantity'));
}
$pdo = pdo_connect_mysql();
$req = [];
$error = '';

if(isset($_POST['login'])){
    $error = login($pdo);

}

if(isset($_POST['register'])) {
    $error = register($pdo);
}

function login($pdo){
    if(isset($_POST['email'], $_POST['password'])){

        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Incorrect Email or Password';
        }

        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE email = ?');
        $stmt-> execute([ $email ]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$account || !password_verify( $_POST['password'], $account['password'])){
            return 'Incorrect Email or Password';
        } else {
           $_SESSION['account_id'] = $account['id'];
           $_SESSION['account_email'] = $account['email'];
           $_SESSION['accoutn_role'] = $account['role'];
           header('location: index.php');

        }
    }

    }
function register($pdo){
    if(isset($_POST['email'], $_POST['password'], $_POST['cpassword'])){
        $email = $_POST['email'];
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Incorrect Email or Password';
        }

        if($_POST['password'] !== $_POST['cpassword']) {
            return 'Passwords does not match!';

        }

        if(strlen($_POST['password']) < 7){
            return 'Password must have a minimum of 7 characters';
        }

        $stmt = $pdo->prepare('SELECT * FROM accounts WHERE email = ?');
        $stmt-> execute([ $email ]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if($account){
            return 'Account already exists';
        }
        $role = 'Member';
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('INSERT INTO accounts (email, password, role) VALUES (?,?,?)');
        $stmt->execute([$_POST['email'],$password,$role]);
        $account_id = $pdo->lastInsertId();
        session_regenerate_id();
        $_SESSION['account_id'] = $account_id;
        $_SESSION['account_role'] = $role;
        header('location: index.php');

    }
}
?>

<nav class="border-bottom">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10 col-xxl-9 d-flex flex-wrap">
                <ul class="nav me-auto">
                    <li class="nav-item">
                        <a href="../index.php" class="nav-link link-dark px-2 active" aria-current="page">
                        <i class="bi bi-shop-window"></i> Return to Shop
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="../admin/products.php" class="nav-link link-dark px-2">
                            <i class="bi bi-box-fill"></i> Products
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="../admin/orders.php" class="nav-link link-dark px-2">
                            <i class="bi bi-cart-fill"></i> Orders
                        </a>
                    </li>
                </ul>

                <ul class="nav">
                    <?php if(isset($_SESSION['account_email'])): ?>
                        <li class="nav-item">
                            <a href="../logout.php" class="nav-link link-dark px-2">
                                <i class="bi bi-person-fill"></i> Logout
                            </a>
                        </li>
                    <?php else:?>
                        <li class="nav-item">
                            <a href="#myModal" data-bs-toggle="modal" class="nav-link link-dark mx-2 py-2">
                                <i class="bi bi-person-fill"></i> My Account
                            </a>
                        </li>
                        <?php endif?>
                </ul>
            </div>
        </div>
    </div>
</nav>

<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-login">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Log In</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          <div class="row">
                
                    <h2 class="fw-bold text-center fs-3">Login</h2>
                    <form action="" method="POST">
                        <div class="row gy-3 overflow-hidden">

                            <div class="col-12">
                               <div class="form-floating mb-3">
                                <input type="email" class="form-control border-0 border-bottom rounded-pill" name="email" id="email" placeholder="name@example.com" required>
                                <label for="email" class="form-label">Email</label>
                               </div> 
                            </div>

                            <div class="col-12">
                               <div class="form-floating mb-3">
                                <input type="password" class="form-control border-0 border-bottom rounded-pill" name="password" id="password"  value="" placeholder="Password" required>
                                <label for="password" class="form-label">Password</label>
                               </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid">
                                   <button class="btn btn-secondary btn-lg rounded-pill" type="submit" name="login">Log In</button> 
                                </div>
                        
                        </div>
                    </form>
                        </div>
                    </div>
          </div>
          <div class="modal-footer">Don't have an account? <a href="#myModal2" class="trigger-btn" data-bs-toggle="modal">Sign Up</a></div>
        </div>
      </div>
    </div>
    <div class="modal fade" id="myModal2" aria-hidden="true">

            <div class="modal-dialog modal-login">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Sign Up</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                        <form action="" method="POST">

                            <div class="col-12">
                               <div class="form-floating mb-3">
                                <input type="email" class="form-control border-0 border-bottom rounded-pill" name="email" id="email" placeholder="name@example.com" required>
                                <label for="email" class="form-label">Email</label>
                               </div> 
                            </div>

                                <div class="col-12">
                               <div class="form-floating mb-3">
                                <input type="password" class="form-control border-0 border-bottom rounded-pill" name="password" id="password"  value="" placeholder="Password" required>
                                <label for="password" class="form-label">Password</label>
                               </div>
                            </div>

                            <div class="col-12">
                               <div class="form-floating mb-3">
                                <input type="password" class="form-control border-0 border-bottom rounded-pill" name="cpassword" id="cpassword"  value="" placeholder="Confirm Password" required>
                                <label for="cpassword" class="form-label">Confirm Password</label>
                               </div>
                            </div>

                            <div class="col-12">
                                <div class="d-grid">
                                   <button class="btn btn-secondary btn-lg rounded-pill" type="submit" name="register">Register</button> 
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if($error) include 'theme_components/alert.php';?>

                    <div class="modal-footer">Already have an account? <a href="#myModal" class="trigger-btn" data-bs-toggle="modal">Log In</a></div>
                </div>
              </div>
            </div>
          </div>
