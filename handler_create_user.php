<?php

require "my_function.php";
dump($_POST,5);
dump($_FILES);

if (get_id_by_email($_POST['email'])){
    $_SESSION['danger']="такой email уже занят";
    redirect_to('create_user.php');
    exit;
} else{ add_user($_POST['email'],$_POST['password']);}

