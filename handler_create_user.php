<?php
session_start();
require "my_function.php";

dump($_POST,5);
dump($_FILES,4);
//проверка нового пользователя и запись  его данных в БД
// if (get_id_by_email($_POST['email'])){
//     $_SESSION['danger']="такой email уже занят";
//     redirect_to('create_user.php');
//     exit;
// } else{ add_user($_POST['email'],$_POST['password']);}

//запись ид в сессиию

echo $_SESSION['id'] = get_id_by_email($_POST['email']); 
// exit;

$pdo = new PDO("mysql:host=localhost;dbname=marlin", "root", "");

//запись общих данных
function save_into_common_infa(){
    global $pdo;
    $id_user= $_SESSION['id'];
    $name=$_POST['username'];
    $tags='tags';
    $work_space=$_POST['work_space'];
    $phone=$_POST['phone'];
    $mailto=$_POST['email'];
    $address=$_POST['address'];
    $sql = "INSERT INTO common_infa (name, id_user, tags, work_space, phone, mailto, address) VALUES(:name, :id_user, :tags, :work_space, :phone, :mailto, :address)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'name' => $name,
        'id_user' => $id_user,
        'tags' => $tags,
        'work_space' => $work_space,
        'phone' => $phone,
        'mailto' => $mailto,
        'address' => $address,
    ]);
}




//запись медиа-данных
$extens= 
//создание нового имени со старым расширением
//запись имени в бд
//запись файла с новым именем в uploads

//запись соцсетей

//формирование успешного сообщения

//переход на users.php




