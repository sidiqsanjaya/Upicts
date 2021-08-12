<?php
require 'config.php'; 
session_start();
error_reporting(0);
$iduser     = $_SESSION['id_user'];
$level      = $_SESSION['level'];
$idimg      = $_POST['id']; //ini sukai
$idimg2     = $_POST['d']; //count download
$idimg3     = $_POST['b']; //hapus gambar data
$idimg4     = $_POST['c']; //delete disukai dari user
$idimg5     = $_POST['e']; //delete gambar user
if(!empty($_POST['id'])){
    $row = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM like_image WHERE id_user = '$iduser' AND id_image = '$idimg'"));
    if($row == 0){
        mysqli_query($conn, "INSERT INTO `like_image` (`id_user`, `id_image`, `like`) VALUES ('$iduser', '$idimg', '1')");
    }
}
if(!empty($_POST['d'])){
    $h = mysqli_fetch_array(mysqli_query($conn, "SELECT download FROM image WHERE id_image = '$idimg2'"));
    $hasil = 1 + $h['download'];
    mysqli_query($conn, "UPDATE `image` SET `download` = '$hasil' WHERE `image`.`id_image` = '$idimg2'");
}
if(!empty($_POST['b'])){
    $dhq = mysqli_query($conn, "SELECT `user`.*, `image`.*, `link_image`.*
    FROM `user` 
        LEFT JOIN `image` ON `image`.`id_user` = `user`.`id_user` 
        LEFT JOIN `link_image` ON `link_image`.`id_image` = `image`.`id_image` WHERE user.id_user = '$iduser' AND image.id_image = '$idimg3'");
        $row = mysqli_num_rows($dhq);
        if($row == 1){
            while($dh = mysqli_fetch_array($dhq)){
                $tmp = $dh['temp_img'];
                $raw = $dh['raw_img'];
                unlink($raw);
                unlink($tmp);
            }
            mysqli_query($conn, "DELETE FROM `image` WHERE `image`.`id_image` = '$idimg3'");
        }
}
if(!empty($_POST['c'])){
    mysqli_query($conn, "DELETE FROM like_image WHERE `like_image`.`id_user` = '$iduser' AND `like_image`.`id_image` = '$idimg4'");
}
if(!empty($_POST['e'])){
    if($level == 'master'){
        $dhq = mysqli_query($conn, "SELECT `user`.*, `image`.*, `link_image`.*
        FROM `user` 
            LEFT JOIN `image` ON `image`.`id_user` = `user`.`id_user` 
            LEFT JOIN `link_image` ON `link_image`.`id_image` = `image`.`id_image` WHERE image.id_image = '$idimg5'");
            $row = mysqli_num_rows($dhq);
            if($row == 1){
                while($dh = mysqli_fetch_array($dhq)){
                    $tmp = $dh['temp_img'];
                    $raw = $dh['raw_img'];
                    unlink($raw);
                    unlink($tmp);
                }
                mysqli_query($conn, "DELETE FROM `image` WHERE `image`.`id_image` = '$idimg5'");
            }
    }
}
?>