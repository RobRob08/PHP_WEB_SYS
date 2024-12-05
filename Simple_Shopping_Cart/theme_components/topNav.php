<?php

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
           $_SESSION['account_role'] = $account['role'];
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
<div class="container-promo py-1">
  <h6 class="d-flex justify-content-center text-align-center my-1">Free Shipping in Selected Areas</h6>
</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
  <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
      <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand mx-2" href="index.php">
      <img class="img-fluid" src="assets/images/Logoo.png" alt="Logo" width="50" height="50">
    </a>
   
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <div class="dropdown">
            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              All products
            </a>
            <ul class="dropdown-menu border-0" style="width: 100vh;">
              <div class="col pt-3 pt-sm-4 px-2 px-lg-3">
                <div class="container-item">
                  <ul>
                    <a class="dropdown-item" href="product.php">
                      <img src="assets/Icons/eye-outline-with-lashes.png" alt="EyesIcon" width="70" height="70">
                      <h5>EYES</h5>
                    </a>
                  </ul>
                  <ul>
                    <li><a class="dropdown-item px-1" href="product.php">Eye Liner</a></li>
                    <li><a class="dropdown-item px-1" href="product.php">Eyebrow Pencil</a></li>
                    <li><a class="dropdown-item px-1" href="product.php">Eye Shadow</a></li>
                  </ul>
                </div>
              </div>
              <div class="col pt-3 pt-sm-4 px-2 px-lg-3">
                <div class="container-item">
                  <ul>
                    <a class="dropdown-item" href="product.php">
                      <img src="assets/Icons/lips.png" alt="LipsIcon" width="70" height="70">
                      <h5>LIPS</h5>
                    </a>
                  </ul>
                  <ul>
                    <li><a class="dropdown-item px-1" href="product.php">Lipsticks</a></li>
                    <li><a class="dropdown-item px-1" href="product.php">Lip Tint</a></li>
                  </ul>
                </div>
              </div>
              <div class="col pt-3 pt-sm-4 px-2 px-lg-3">
                <div class="container-item">
                  <ul>
                    <a class="dropdown-item" href="product.php">
                      <img src="assets/Icons/face.png" alt="FaceIcon" width="70" height="70">
                      <h5>FACE</h5>
                    </a>
                  </ul>
                  <ul>
                    <li><a class="dropdown-item px-1" href="product.php">Foundation</a></li>
                    <li><a class="dropdown-item px-1" href="product.php">Blush</a></li>
                  </ul>
                </div>
              </div>
            </ul>
          </div>
        </li>
      </ul>

     
    </div>
     <ul class="navbar-nav">
        <?php if(isset($_SESSION['account_role']) && $_SESSION['account_role'] === 'Admin'){ ?>
          <li class="nav-item">
            <a href="admin/products.php" class="nav-link link-dark my-3 py-2">
              <i class="bi bi-speedometer"></i> Admin
            </a>
          </li>
        <?php } ?>

        <?php if(isset($_SESSION['account_email'])) { ?>
          <li class="nav-item">
            <a href="logout.php" class="nav-link link-dark my-3 py-2">
            <img src="assets/Icons/Male User.png" alt="Profile" width="30" height="30">  Logout
            </a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link trigger-btn" href="#myModal" data-bs-toggle="modal">
              <img src="assets/Icons/Male User.png" alt="Profile" width="30" height="30"> Login
            </a>
          </li>
        <?php } ?>

        <?php if(isset($_SESSION['account_email'])) { ?>
          <li class="nav-item">
            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" class="nav-link link-dark my-3 py-2">
            <img src="assets/Icons/Shopaholic.png" alt="Cart" width="30" height="30">
            </a>
          </li>
        <?php } ?>
      </ul>
  </div>
</nav>

</div>

