<?php
//error_reporting(0);
$host       =   "localhost";
$user       =   "younimem_upicts";
$password   =   "ReaDcWGQr";
$database   =   "younimem_upicts";
$conn = mysqli_connect($host, $user, $password, $database);
	if($conn === false){
		die("ERROR: tidak dapat terhubung. " . mysqli_connect_error());
	}

$table = mysqli_num_rows(mysqli_query($conn, "SHOW TABLES"));


//setting
$domain = $RSHH = "https://upicts.younime.my.id/";
$logintrue = isset($_SESSION['id_user']) && !empty($_SESSION['id_user']);
?>