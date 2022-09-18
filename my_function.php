<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=marlin", "root", "");

function dump($data, $stop=1){
	echo '<pre>';
	print_r($data);
	echo "</pre>";
	if($stop==1) die;
}

function add_user($email,$password){
    global $pdo;
    $sql = "INSERT INTO users (email, password) VALUE (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'email' => $email, 
        'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
    ]);
}

function get_id_by_email($email){
    global $pdo;
    $sql = "SELECT id FROM users WHERE email=:email";
    $statement=$pdo->prepare($sql);
    $statement->execute(['email'=>$email]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['id'];
}

function get_pass_by_id($id){
    global $pdo;
    $sql = "SELECT password FROM users WHERE id=$id";
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $res = $statement->fetch(PDO::FETCH_ASSOC);
    return $res['password'];
}

function set_sess_mess($alert, $text){
    return $_SESSION[$alert] = $text;
}

function display_sess_mess($name){
    if (isset($_SESSION[$name])){
        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
        unset($_SESSION[$name]);
    }
}

function redirect_to($path){
    header("Location: ".$path);
}
 
function login($name,$pass){
    $id=get_id_by_email($name);
    if(!$id){
        set_sess_mess('danger','Такого логина в базе нет');
        redirect_to('page_login.php');
        exit;
    } else {
        $hash= get_pass_by_id($id);
        $check= password_verify($_POST['password'], $hash);
        if(!$check){
            set_sess_mess('danger','Логин и пароль не совпадают');
            redirect_to('page_login.php');
            exit;
        } 
        else {
            // redirect_to('users.php');
            return $check;
        }
    }
}