<?php
session_start();
require "my_function.php";

// dump($_POST,5);
// dump($_FILES,4);

if($login=login_bool($_POST['email'],$_POST['password'])==1){
    //если пароль и логин совпадают то редактируем
    $id=get_id_by_email($_POST['email']);    
    edit_common_infa_by_id($_POST, $id);
    edit_avatar_into_media($_FILES, $id);
    edit_status($id, $_POST);
    edit_socials_by_id($_POST, $id);
    edit_tags($_POST, $id);
    set_sess_mess('success',"Данные отредактированы");
    redirect_to('users.php');
    exit;
} else {
    //если пары логин-пароль нет проверяем есть ли такой же логин
    if (get_id_by_email($_POST['email'])){
        set_sess_mess('danger',"такой email уже занят, <br>Данные изменить можно если знаешь пароль<br>");
        redirect_to('create_user.php');
        exit;
    } else { 
        // если такого логина нет то создаём нового пользователя
        add_user($_POST['email'],$_POST['password']);
        $id = get_id_by_email($_POST['email']);
        edit_common_infa_by_id($_POST, $id);
        edit_avatar_into_media($_FILES, $id);
        edit_socials_by_id($_POST,$id);
        edit_status($_POST,$id);
        edit_tags($_POST, $id);
        set_sess_mess('success',"данные нового пользователя успешно записаны");
        redirect_to('users.php');
        exit;
    }
}




?>