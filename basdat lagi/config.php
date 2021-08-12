<?php
$host       =   "localhost";
$user       =   "root";
$password   =   "root";
$database   =   "shorter";
$site       = "http://localhost:8888/basdat/basdat%20lagi/";
$conn = mysqli_connect($host, $user, $password, $database);
	if($conn === false){
		die("ERROR: Could not connect. " . mysqli_connect_error());
	}

    function acak($panjang)
    {
        $karakter= 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $string = '';
        for ($i = 0; $i < $panjang; $i++) {
        $pos = rand(0, strlen($karakter)-1);
        $string .= $karakter{$pos};
        }
        return $string;
    }

    ?>