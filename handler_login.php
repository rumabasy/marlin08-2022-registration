<?php
session_start();
require "my_function.php";
// dump($_POST);

// echo set_sess_mess('sussess', 'успно');
// exit;
$email = $_POST['email'];
$password = $_POST['password'];
$remember = $_POST['remember'];

if(login($email, $password)){
    $_SESSION['id']=get_id_by_email($email);
    $_SESSION['role']=get_role_by_email($email);
    set_sess_mess('success', 'вы вошли как<br>'.$email);
    redirect_to('users.php');
    exit;
} else {
    set_sess_mess('danger', 'пароль не ссответствует (handler_login)');
    redirect_to('page_login.php');
    exit;
}