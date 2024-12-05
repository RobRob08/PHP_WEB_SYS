<?php
include 'db_connect.php';

session_start();

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

<?php
$page_title = "Shopping Cart - My Account";
include 'theme_components/head.php';
include 'theme_components/topNav.php';
include 'theme_components/header.php';    
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9 col-sm-8">
            <h2 class="heading mt-3 mb-5">My Account</h2>

            <div class="row mb-4">
                <div class="col-12 col-lg-5">
                    <h2 class="fw-bold text-center fs-3">Login</h2>
                    <hr class="mb-4">
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

                        </div>
                    </form>
</div>
                    </div>
                    <div class="col-12 col-lg-2 d-flex align-items-center justify-content-center gap-3 flex-lg-column my-5">
                        <div class="bg-dark h-100 d-none d-lg-block" style="width: 1px; --bs-bg-opacity; .1;"></div>
                        <div class="bg-dark w-100 d-lg-none " style="width: 1px; --bs-bg-opacity; .1;"></div>
                        <div>or</div>
                        <div class="bg-dark h-100 d-none d-lg-block" style="width: 1px; --bs-bg-opacity; .1;"></div>
                        <div class="bg-dark w-100 d-lg-none " style="width: 1px; --bs-bg-opacity; .1;"></div> 
                    </div>
                    <div class="col-12 col-lg-5">
                        <h2 class="fw-bold text-center fs-3">Register</h2>
                        <hr class="mb-4">
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

                            </div>
                        </form>
                    </div>
                    <?php if($error) include 'theme_components/alert.php';?>
                </div>
            </div>
        </div>
    </div>


<?php

include 'theme_components/footer.php';

?>
