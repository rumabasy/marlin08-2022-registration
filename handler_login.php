<?php
session_start();
require "my_function.php";
// dump($_POST);

// echo set_sess_mess('sussess', 'успно');
// exit;
$email = $_POST['email'];
$password = $_POST['password'];
$remember = $_POST['remember'];

$pdo = new PDO("mysql:host=localhost;dbname=marlin","root" , "");

if(login($email, $password)) redirect_to('users.php');