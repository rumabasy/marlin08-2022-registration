<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=marlin", "root", "");

if(!is_dir('uploads')) mkdir('uploads');

function add_user($email,$password){
    global $pdo;
    $sql = "INSERT INTO users (email, password) VALUE (:email, :password)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'email' => $email, 
        'password' => $password,
    ]);
    // создать пустые записи в common_infa, media, status, socials
    $id=get_id_by_email($email);
    save_into_common_infa($_POST);
    save_avatar_into_media($id);
    save_socials($_POST);
    save_status($id);
}

function delete_old_avatar_from_uploads($old_name){
    if($old_name !='no'){
        if(is_link("uploads/".$old_name))  unlink("uploads/".$old_name);
    }
}

function delete_user_by_id($id){
    global $pdo;
    $sql="DELETE FROM media WHERE id_user = $id";
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $sql="DELETE FROM socials WHERE id_user = $id";
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $sql="DELETE FROM status WHERE id_user = $id";
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $sql="DELETE FROM common_infa WHERE id_user = $id";
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $sql="DELETE FROM users WHERE id = $id";
    $statement=$pdo->prepare($sql);
    $statement->execute();
}

function display_sess_mess($name){
    if (isset($_SESSION[$name])){
        echo "<div class=\"alert alert-{$name} text-dark\" role=\"alert\">{$_SESSION[$name]}</div>";
        unset($_SESSION[$name]);
    }
}

function dump($data, $stop=1){
    echo '<pre>';
    print_r($data);
    echo "</pre>";
    if($stop==1) die;
}

function edit_avatar_into_media($files, $id){
    $old_img=get_avatar_by_id_user2($id);
    // dump($res);
    if(!$files["image"]['name']){
        $name=$old_img;
    } else {
        //запись медиа-данных, статуса и нового имени картинки аватара в таблицу media
        $extension = pathinfo($files["image"]['name'], PATHINFO_EXTENSION);
        $name = uniqid().'.'.$extension;
        //создание нового имени со старым расширением
        move_uploaded_file($files["image"]['tmp_name'], "uploads/".$name);
        //запись файла с новым именем в uploads
        delete_old_avatar_from_uploads($old_img);
    }
    $id_user=$id; //exit;
    global $pdo;
    $sql = "UPDATE `media` SET `img` = :image WHERE `id_user` = :id_user";
    $statement = $pdo->prepare($sql);
    $statement->bindparam(":image", $new_name);
    $statement->bindparam(":id_user", $id_user);
    $statement->execute([
        "image" => $name,
        'id_user' => $id_user,
    ]);
}

function edit_common_infa_by_id($post, $id){
    global $pdo;
    //получить данные из таблицы с етим id
    $res=get_common_infa_by_id($id);
    $id_user = $id;
    //сравнить и присвоить значения тем которые неравны ''
    if($post['username']=='') $name=$res['name']; else $name=$post['username']; 
    if($post['work_space']=='') $work_space=$res['work_space']; else $work_space=$post['work_space']; 
    if($post['phone']=='') $phone=$res['phone']; else $phone=$post['phone']; 
    if($post['address']=='') $address=$res['address']; else $address=$post['address']; 
    $sql = "UPDATE `common_infa` SET `name` = :name, `work_space` = :work_space, `phone` = :phone, `address` = :address WHERE `id_user`= :id_user";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'name' => $name,
        'work_space' => $work_space,
        'phone' => $phone,
        'address' => $address,
        'id_user' => $id_user,
    ]);
}

function edit_socials_by_id($post, $id){
global $pdo;
// получаем массив наших socials
$res=get_socials_by_id($id);
// dump($res);
$id_user = $id;
if($post['vk']=='') $vk=$res['vk']; else $vk=$post['vk'];
if($post['t_g']=='') $tg=$res['tg']; else $tg=$post['t_g'];
if($post['inst_g']=='') $inst=$res['inst']; else $inst=$post['inst_g'];
$sql = "UPDATE `socials` SET `vk` = :vk, `tg` = :tg, `inst` = :inst WHERE `id_user`= :id_user";
$statement = $pdo->prepare($sql);
$statement->execute([
    'vk' => $vk,
    'tg' => $tg,
    'inst' => $inst,
    'id_user' => $id_user,
]);
}

function edit_status($post,$id){
    global $pdo;
    $id_user= $id;
    $status=$post['status'];
    $sql = "UPDATE `status` SET `status` = :status WHERE `id_user`=:id_user";
    $statement=$pdo->prepare($sql);
    $statement->execute([
        'id_user'=> $id_user,
        'status' => $status,
    ]);    
}

function edit_status2($post, $id){
    global $pdo;
    $option=[
        'success' =>'Онлайн',
        'warning' =>'Отошел',
        'danger' =>'Не беспокоить',
        'primary' =>'Пох все',
    ];
    foreach ($option as $opt =>$ion){
        if ($ion == $post['status']){
            $id_user= $id;
            $status2=$opt;
            $sql = "UPDATE `status` SET `status2` = :status2 WHERE `id_user`=:id_user";
            $statement=$pdo->prepare($sql);
            $statement->execute([
                'id_user'=> $id_user,
                'status2' => $status2,
            ]);  
            break;
        }
    }

}
function edit_tags($post,$id){
    global $pdo;
    $id_user= $id;
    $tags=$post['tags'];
    $sql = "UPDATE `common_infa` SET `tags` = :tags WHERE `id_user`=:id_user";
    $statement=$pdo->prepare($sql);
    $statement->execute([
        'id_user'=> $id_user,
        'tags' => $tags,
    ]);    
    
}
function edit_user($id,$post){
    global $pdo;
    $id_user = $id;
    $email=$post['email'];
    $pass=$post['pass'];
    $sql = "UPDATE `users` SET `email` = :email, `password` = :pass WHERE `id`= :id_user";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'email' => $email,
        'pass' => password_hash($pass, PASSWORD_DEFAULT),
        'id_user' => $id_user,
    ]);    
}    


function get_avatar_by_id_user($comm){
    global $pdo;
    $id=$comm['id_user'];
    $sql="SELECT img FROM media WHERE id_user=$id";
    $statement = $pdo->query($sql);
    $result=$statement->fetch(PDO::FETCH_ASSOC);
    return $result['img'];
}

function get_avatar_by_id_user2($id){
    global $pdo;
    $sql="SELECT img FROM media WHERE id_user=$id";
    $statement = $pdo->query($sql);
    $result=$statement->fetch(PDO::FETCH_ASSOC);
    return $result['img'];
}

function get_common_infa_by_id($comm){
    global $pdo;
    $id=$comm;
    $sql="SELECT * FROM common_infa WHERE id_user=$id";
    $statement = $pdo->query($sql);
    return $result=$statement->fetch(PDO::FETCH_ASSOC);
}

function get_common_infa_by_id2($id){
    global $pdo;
    $sql = "SELECT * FROM common_infa WHERE id_user=$id";
    $statement=$pdo->prepare($sql);
    $statement->execute();
    $res = $statement->fetch(PDO::FETCH_ASSOC);
    return $res;
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

function get_role_by_email($email){

    global $pdo;
    $sql = "SELECT role FROM users WHERE email=:email";
    $statement=$pdo->prepare($sql);
    $statement->execute(['email'=>$email]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    return $result['role'];
}    
    

function get_status(){
    global $pdo;
    $sql="SELECT * FROM status ";
    $statement = $pdo->query($sql);
    return $result=$statement->fetchAll(PDO::FETCH_ASSOC);
}    

function get_status_by_id_user($comm){
    global $pdo;
    $id=$comm['id_user'];
    $sql="SELECT status FROM status WHERE id_user=$id";
    $statement = $pdo->query($sql);
    $result=$statement->fetch(PDO::FETCH_ASSOC);
    return $result['status'];
}    

function get_stat_by_id_user($id){
    global $pdo;
    $sql="SELECT status FROM status WHERE id_user=$id";
    $statement = $pdo->query($sql);
    $result=$statement->fetch(PDO::FETCH_ASSOC);
    return $result['status'];
}    

function get_socials_by_id($id){
    global $pdo;
    $sql="SELECT * FROM socials WHERE id_user=$id";
    $statement = $pdo->query($sql);
    return $result=$statement->fetch(PDO::FETCH_ASSOC);
}


function get_media(){
    global $pdo;
    $sql="SELECT * FROM media ";
    $statement = $pdo->query($sql);
    return $result=$statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_common_infa(){
    global $pdo;
    $sql="SELECT * FROM common_infa ";
    $statement = $pdo->query($sql);
    return $result=$statement->fetchAll(PDO::FETCH_ASSOC);
}

function get_email_by_id($id){
    global $pdo;
    $sql="SELECT email FROM users WHERE id=$id ";
    $statement = $pdo->query($sql);
    return $result=$statement->fetch(PDO::FETCH_ASSOC);
}

function get_id_user_by_email_in_common_infa($email){
    global $pdo;
    $sql="SELECT id_user FROM common_infa WHERE mailto =:email";
    $statement=$pdo->prepare($sql);
    $statement->execute(['email'=> $email]);
    $email=$statement->fetch(PDO::FETCH_ASSOC);
    return $email['id_user'];
}

function get_socials(){
    global $pdo;
    $sql="SELECT * FROM socials ";
    $statement = $pdo->query($sql);
    return $result=$statement->fetchAll(PDO::FETCH_ASSOC);
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
            set_sess_mess('danger','Логин и пароль!= f(login');
            redirect_to('page_login.php');
            exit;
        } 
        else {
            // redirect_to('users.php');
            return $check;
        }
    }
}

function login_bool($name,$pass){
    $id=get_id_by_email($name);
    if($id){
        $hash= get_pass_by_id($id);
        $check= password_verify($pass, $hash);
        return $check=1;
    } else {
        return $check=0;
        exit;
    }

}


function redirect_to($path){
    header("Location: ".$path);
}    
 

function save_avatar_into_media($id){
    // if(!$img["image"]['name']){
        $name='no';
    // } else {
    //     //запись медиа-данных, статуса и нового имени картинки аватара в таблицу media
    //     $extension = pathinfo($img["image"]['name'], PATHINFO_EXTENSION);
    //     $name = uniqid().'.'.$extension;
    //     //создание нового имени со старым расширением
    //     move_uploaded_file($img["image"]['tmp_name'], "uploads/".$name);
    //     //запись файла с новым именем в uploads
    // }
    $id_user=$id;
    global $pdo;
	$sql = "INSERT INTO media (img, id_user) VALUES (:img, :id_user)";
	$statement = $pdo->prepare($sql);
	$statement->bindparam(":img", $name);
	$statement->bindparam(":id_user", $id_user);
	$statement->execute([
        "img" => $name,
        'id_user' => $id_user,
    ]);
}

function save_into_common_infa($post){
    global $pdo;

    $id_user = get_id_by_email($post['email']);
    if($post['username']) $name=$post['username']; else $name="username";
    if($post['tags']) $tags=$post['tags']; else $tags="username";
    if($post['work_space']) $work_space=$post['work_space']; else $work_space="work_space";
    if($post['phone']) $phone=$post['phone']; else $phone="no phone";
    if($post['email']) $mailto=$post['email']; else $mailto="no";
    if($post['address']) $address=$post['address']; else $address="no address";

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

function save_socials($post){
    global $pdo;
    $id_user= get_id_by_email($post['email']);
    if($post['vk']) $vk=$post['vk']; else $vk="no";
    if($post['t_g']) $tg=$post['t_g']; else $tg="no";
    if($post['inst_g']) $inst=$post['inst_g']; else $inst="no";
    $sql = "INSERT INTO socials (id_user, vk, tg, inst) VALUES(:id_user, :vk, :tg, :inst)";
    $statement = $pdo->prepare($sql);
    $statement->execute([
        'id_user' => $id_user,
        'tg' => $tg,
        'vk' => $vk,
        'inst' => $inst,
    ]);
}

function save_status($id){

    global $pdo;
    $id_user=$id;
    $status='success';
    $sql = "INSERT INTO status (id_user, status) VALUES(:id_user, :status)";
    $statement=$pdo->prepare($sql);
    $statement->execute([
        'id_user'=> $id_user,
        'status' => $status,
    ]);
}

    function set_sess_mess($alert, $text){
        return $_SESSION[$alert] = $text;
    }    
