<?php
error_reporting(0);
$host       =   "localhost";
$user       =   "root";
$password   =   "123";
$database   =   "upicts";
$conn = mysqli_connect($host, $user, $password, $database);
	if($conn === false){
		die("ERROR: tidak dapat terhubung. " . mysqli_connect_error());
	}
?>