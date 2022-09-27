<?php
session_start();
require 'my_function.php';
if($_SESSION['role']=='admin' or $_SESSION['id']==$_GET['id']){
    
    // удалить данные пользователя в таблицах :
    // common_infa
    // media
    // socials 
    // status
    // users
    // avatar from uploads/
    // handler_exit

    $id=$_GET['id'];
    $deleted_name = get_avatar_by_id_user2($id);
    delete_old_avatar_from_uploads($deleted_name);

    
    delete_user_by_id($id);
    set_sess_mess('success','Пользователь удален');
    unset($_SESSION[$id]);
    redirect_to('users.php');
    exit;    
}