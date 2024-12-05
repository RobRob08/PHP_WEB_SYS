<?php
include_once 'config.php';

function pdo_connect_mysql(){
    try{
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8',DB_USERNAME,DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOexception $exception){
      echo 'failed to connect to Database';  
    }
    return $pdo;
}

?>