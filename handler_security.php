<?php
session_start();
require 'my_function.php';
// if(get_id_by_email($_POST['email'])){
//     if(get_id_by_email($_POST['email'])==$_GET['id']))
// }
$id=get_id_by_email($_POST['email']);
// dump($id);


if(!$id or $id==$_GET['id']){
    if($_POST['pass']==$_POST['pass2']){
        edit_user($id,$_POST);
    } else {
        set_sess_mess('danger', 'пароли не совпадают');
        redirect_to('security.php?='.$_GET['id']);
        exit;
    }
} else {
    set_sess_mess('danger', 'email уже занят');
    redirect_to('security.php?='.$_GET['id']);
    exit;
}


