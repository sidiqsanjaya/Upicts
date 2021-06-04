<?php
session_start();//session start
include 'config.php'; 
$Susername = $_SESSION['username']; //get session user
$HH   = $_SERVER['HTTP_HOST'];
$RU = $_SERVER['REQUEST_URI'];
$RS  = $_SERVER['REQUEST_SCHEME'];
$RSHH = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'];

$ex = substr($RU, strrpos($RU, '/') + 1);
//echo "1. ".$ex;
//echo "<br>2. ".$RU;
//echo "<br>3. ".$RSHH;
//config php


//login
$logintrue = isset($_SESSION['username']) && !empty($_SESSION['username']);

//test
//echo "<br>".date('Y-m-d');

//page
$page = $_GET['id']; 
switch ($page){
    case 'sign-in':
        include "login/auth-signin.php";
    break;
    case 'sign-up':
        include "login/auth-signup.php";
    break;
    case 'logout':
        include "killsession.php";
    break;
    case 'user':
        include "profile/profile.php";
    break;
    case 'upload':
        include "upload/upload.php";
    break;
    case 'php':
        phpinfo();
    break;
    default:
        include "dashboard.php";
    break;
}

?>