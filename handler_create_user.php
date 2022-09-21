<?php
session_start();
require "my_function.php";

// dump($_POST,5);
// dump($_FILES,4);

$pdo = new PDO("mysql:host=localhost;dbname=marlin", "root", "");

if (get_id_by_email($_POST['email'])){
    $_SESSION['danger']="такой email уже занят ";
    redirect_to('create_user.php');
    exit;
} else{ 
    add_user($_POST['email'],$_POST['password']);
    $_SESSION['id'] = get_id_by_email($_POST['email']);
    save_into_common_infa($_POST);
    save_avatar_into_media($_FILES, $_SESSION['id']);
    save_socials($_POST);
}




?>