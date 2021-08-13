<?php
session_start();//session start

require 'config.php'; 

error_reporting(10);

$iduser     = $_SESSION['id_user']; //get session and user id

$level      = $_SESSION['level'];



if($table == 0 || $table < 7){

    include 'Restore.php';

}else{

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

        case 'edit-profile':

            include "profile/edit-profile.php";

        break;

        case 'admin':

            include "admin.php";

        break;

        case 'php':

            phpinfo();

        break;

        case 'dashboard':

            include "dashboard.php";

        break;

        default:

            include "dashboard.php";

        break;

    }

}

?>