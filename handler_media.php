<?php
session_start();
require 'my_function.php';
$id=$_GET['id_user'];
// dump($_FILES,3);
// dump($_GET);
$old_name = get_avatar_by_id_user2($id);
delete_old_avatar_from_uploads($old_name);
// exit;
edit_avatar_into_media($_FILES, $id);
set_sess_mess('success','АВАТАР изменен');
redirect_to('users.php');
exit;    