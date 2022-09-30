<?php
session_start();
require 'my_function.php';
unset($_SESSION['role']);
unset($_SESSION['id']);
// dump($_POST);
header("Location: page_login.php");