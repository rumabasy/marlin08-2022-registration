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

$id = get_id_by_email($email);

$pass= get_pass_by_id($id);

$check= password_verify($password, $pass);

if ($check){
        set_sess_mess('id', $id );
    if ($remember=='on'){
        $_SESSION['remem']['id']=$remember;
        $_SESSION['remem']['email']=$email;
        $_SESSION['remem']['pass']=$password;
    }

    redirect_to('create_user.php');
    
    // header("Location: create_user.php");
    exit;
}

set_sess_mess('danger', 'Неправильная пара логин - пароль');
// $_SESSION['danger']='Неправильная пара логин - пароль';
redirect_to('page_login.php');
// header("Location: page_login.php");
