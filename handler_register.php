<?php
session_start();
require "my_function.php";
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$pdo = new PDO("mysql:host=localhost;dbname=marlin","root" , "");

$result= get_id_by_email($email);

if($result){
    set_sess_mess('danger', 'Этот эл. адрес уже занят другим пользователем.' );
    redirect_to('page_register.php');
    exit;
}

add_user($email,$password);

set_sess_mess('success', 'Регистрация успешна' );

redirect_to('page_login.php');

