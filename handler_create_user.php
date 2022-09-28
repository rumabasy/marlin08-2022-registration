<?php
session_start();
require "my_function.php";

// dump($_POST,5);
// dump($_FILES,4);

if(login($_POST['email'],$_POST['password'])){
    //change user
    $id=get_id_by_email($_POST['email'];
    if($_POST[])
    edit_common_infa_by_id($_POST, $id);
    edit_avatar_into_media($_FILES, $id);
    edit_status($id, $_POST);
    edit_socials_by_id($_POST, $id);
} else{
    if (get_id_by_email($_POST['email'])){
        set_sess_mess('danger',"такой email уже занят, <br>Данные изменить можно если знаешь пароль<br>");
        redirect_to('create_user.php');
        exit;
    } else { 
    add_user($_POST['email'],$_POST['password']);
    $_SESSION['id'] = get_id_by_email($_POST['email']);
    save_into_common_infa($_POST);
    save_avatar_into_media($_FILES, $_SESSION['id']);
    save_socials($_POST);
    save_status($_POST);
    $_SESSION['success']="данные успешно записаны ";
    redirect_to('users.php');
    exit;
}




?>