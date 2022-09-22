<?php
session_start();
require 'my_function.php';
// echo $_SESSION['id'];
// dump($_POST);

edit_common_infa_by_id($_POST, $_SESSION['id']);

set_sess_mess('success', 'Данные успешно изменены2');

redirect_to('users.php');
