<?php
session_start();
require "my_function.php";
// dump($_POST);

// echo set_sess_mess('sussess', 'успно');
// exit;
$email = $_POST['email'];
$password = $_POST['password'];
$remember = $_POST['remember'];

$pdo = new PDO("mysql:host=localhost;dbname=marlin","root" , "");

if(login($email, $password)){
    $_SESSION['id']=get_id_by_email($email);
    $_SESSION['role']=get_role_by_email($email);
    redirect_to('users.php');
} 