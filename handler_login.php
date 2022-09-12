<?php
session_start();
require "my_function.php";
// dump($_POST);

$email = $_POST['email'];
$password = $_POST['password'];
$remember = $_POST['remember'];

$pdo = new PDO("mysql:host=localhost;dbname=marlin","root" , "");

$id = get_id_by_email($email);
$id = $id['id'];

$pass= get_pass_by_id($id);

$check= password_verify($password, $pass);

if ($check){
    $_SESSION['id']=$id;
    if ($remember=='on'){
        $_SESSION['remem']['id']=$remember;
        $_SESSION['remem']['email']=$email;
        $_SESSION['remem']['pass']=$password;
    }
    
    header("Location: create_user.php");
    exit;
}

$_SESSION['alert']='danger';
header("Location: page_login.php");
