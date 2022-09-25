<?php
session_start();
require 'my_function.php';
// dump($_POST,9);
// dump($_SESSION);

if ($_SESSION['id']==$_GET['id'] or $_SESSION['role']=='admin'){

    if(!get_id_by_email($_POST['email']) or get_id_by_email($_POST['email'])==$_GET['id']){
        if($_POST['pass']==$_POST['pass2']){
            edit_user($_GET['id'],$_POST);
            set_sess_mess('success','Пароль изменен успешно');
            redirect_to('users.php?id='.$_GET['id']);
            exit;
        } else{
            set_sess_mess('danger','Пароли не совпадают');
            redirect_to('security.php?id='.$_GET['id']);
            exit;
        };

    } else{
        set_sess_mess('danger','Такой логин-email уже занят');
        redirect_to('security.php?id='.$_GET['id']);
        exit;
    }
};



