<?php
session_start();
require "my_function.php";
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$pdo = new PDO("mysql:host=localhost;dbname=marlin","root" , "");

$result= get_id_by_email($email);

if($result){
    $_SESSION['alert']='danger';
    header("Location: page_register.php");
    exit;
}

save_email_and_pass_to_db($email,$password);

$_SESSION['alert']='success';
header("Location: page_login.php");
