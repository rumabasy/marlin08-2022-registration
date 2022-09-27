<?php
session_start();
require "my_function.php";
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$result= get_id_by_email($email);

if($result){
    set_sess_mess('danger', 'Этот эл. адрес уже занят другим пользователем.' );
    redirect_to('page_register.php');
    exit;
}

add_user($email,$password);

$result= get_id_by_email($email);

save_into_common_infa($_POST);

set_sess_mess('success', 'Регистрация успешна4' );

redirect_to('page_login.php');

