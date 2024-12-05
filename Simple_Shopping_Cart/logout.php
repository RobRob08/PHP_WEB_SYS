<?php
session_start();

unset($_SESSION['account_email']);
unset($_SESSION['account_role']);

header('Location: index.php');

?>