<?php
session_start();
require 'my_function.php';
// echo $_SESSION['id'];
// dump($_POST);
if($_SESSION['role']=='admin' or $_SESSION['id']==$_GET['id']){
    $id=$_GET['id'];
    $status=get_stat_by_id_user($id);
    if($status==''){
        save_status($_POST,$id);
        set_sess_mess('success', 'Статус установлен');
        redirect_to('users.php');
        exit;    
        
    } else {
        // edit_status2($_POST,$id);
        edit_status($_POST, $id);
        set_sess_mess('success', 'Статус успешно изменен');
        redirect_to('users.php');
        exit;    

    }

} else {
    set_sess_mess('danger', 'Статус можно поменять только под своим логином');
    redirect_to('users.php');
    exit;
}


