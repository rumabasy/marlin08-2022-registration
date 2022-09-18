<?php
session_start();
require "my_function.php";

// dump($_POST,5);
// dump($_FILES,4);
//проверка нового пользователя
if (get_id_by_email($_POST['email'])){
    $_SESSION['danger']="такой email уже занят";
    redirect_to('create_user.php');
    exit;
} else{ add_user($_POST['email'],$_POST['password']);}

//запись ид в сессиию
$_SESSION['id'] = 11;
//запись общих данных
$pdo = new PDO("mysql:host=localhost;dbname=marlin", "root", "");
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



//запись медиа-данных
//создание нового имени со старым расширением
//запись имени в бд
//запись файла с новым именем в uploads

//запись соцсетей

//формирование успешного сообщения

//переход на users.php




