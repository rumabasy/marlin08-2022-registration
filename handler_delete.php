<?php
session_start();
require 'my_function.php';
if($_SESSION['role']=='admin' or $_SESSION['id']==$_GET['id']){
    
    // удалить данные пользователя в таблицах 
    // common_infa
    // media
    // socials 
    // status
    // users
// avatar from uploads
$id=$_GET['id']
$deleted_name = get_avatar_by_id_user2($id);
delete_old_avatar_from_uploads($deleted_name);

delete_user_by_id($id){
    global $pdo;
    $sql="DELETE * FROM media WHERE id_users = $id";
    $statement=$pdo->prepare($sql);
    $statement->execute();

}