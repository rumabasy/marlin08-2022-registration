<?php

function dump($data, $stop=1){
	echo '<pre>';
	print_r($data);
	echo "</pre>";
	if($stop==1) die;
}

function save_email_and_pass_to_db($email,$password){
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
    return $result = $statement->fetch(PDO::FETCH_ASSOC);
}

function get_pass_by_id($id){
    global $pdo;
    $sql = "SELECT password FROM users WHERE id=$id";
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $res = $statement->fetch(PDO::FETCH_ASSOC);
    return $res['password'];
}

