<?php
session_start();
require 'my_function.php';
// echo $_SESSION['id'];
// dump($_POST);
if($_SESSION['id']){
    edit_status($_SESSION['id'], $_POST);
    set_sess_mess('success', 'Статус успешно изменен');
    redirect_to('users.php');
    exit;    
} else {
    set_sess_mess('danger', 'Статус можно поменять только под своим логином');
    redirect_to('users.php');
    exit;
}


