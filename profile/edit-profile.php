<?php
if(!$logintrue){
    header("location:/");
    exit;
}
if(empty($_GET['id'])){
    header("location: ../index.php");
    exit;
}
$Fprofile=mysqli_query($conn,"SELECT `user`.`username`, `profile`.`fullname`, `profile`.`phone`, `profile`.`country`, `profile`.`imgprofile` FROM `user` LEFT JOIN `profile` ON `profile`.`id_user` = `user`.`id_user` WHERE `user`.`id_user` = '$iduser'");

$file_err = $fullname_err = $email_err = $fullnumber_err = $country_err = $pass_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){ 

    if(empty($_FILES["pict"]["name"])){
        $file_err = "its oke no picture";
    }else{
        $extension_accept = array('jpeg','jpg','png','tiff','raw');
        $filename = $_FILES['pict']['name'];
        $ex = explode('.', $filename);
        $extension = strtolower(end($ex));
        if(in_array($extension, $extension_accept) === true){
            $sql = mysqli_query($conn, "SELECT imgprofile FROM `profile` WHERE id_user = '$iduser'");
            while($sql2 = mysqli_fetch_array($sql)){
                unlink($sql2['imgprofile']);
            }
            $filetmp  = $_FILES['pict']['tmp_name'];
            $fprofile = "img/profile/";
            $pimg    =   $iduser.".".$extension;
            $updateimg = mysqli_query($conn, "UPDATE `profile` SET `imgprofile` = '$fprofile$pimg' WHERE `profile`.`id_user` = '$iduser'");
            if($updateimg){
                move_uploaded_file($filetmp, $fprofile.$pimg);
            }else{
                $file_err = "error while uploader";
            }
        }else{
            $file_err = "what u input? only jpeg or png bro";
        }
    }
    

    $sqlcheck = mysqli_query($conn, "SELECT fullname, phone, country FROM `profile` WHERE id_user='$iduser'");
    while($sqlcheck2 = mysqli_fetch_array($sqlcheck)){
        if(empty(trim($_POST['fullname']))){
        }elseif($_POST['fullname'] == $sqlcheck2['fullname']){
            //donothink
        }elseif(strlen($_POST['fullname']) < 4){
            $fullname_err = "realy you name only 4 character? reinsert";
        }elseif(strlen($_POST['fullname']) > 24){
            $fullname_err = "fullname only accept 24 character";
        }elseif(!preg_match("/[a-zA-Z1-9 ]/", $_POST['fullname'])){
            $fullname_err = "full name can only be filled with numbers or letters";
        }else{
            $fullname = $_POST['fullname'];
            mysqli_query($conn, "UPDATE `profile` SET `fullname` = '$fullname' WHERE `profile`.`id_user` = '$iduser'");
        }

        if(empty(trim($_POST['fullnumber']))){
        }elseif($_POST['fullnumber'] == $sqlcheck2['phone']){
            //donothink
        }elseif(strlen($_POST['fullnumber']) < 10){
            $fullnumber_err = "realy no phone only 10 numbers? reinsert";
        }elseif(strlen($_POST['fullnumber']) > 14){
            $fullnumber_err = "fullnumber only accept max 14 number";
        }elseif(!preg_match("/[0-9]*$/", $_POST['fullname'])){
            $fullnumber_err = "fullnumber can only be filled with numbers";
        }else{
            $fullnumber = $_POST['fullnumber'];
            mysqli_query($conn, "UPDATE `profile` SET `phone` = '$fullnumber' WHERE `profile`.`id_user` = '$iduser'");
        }

        if(empty(trim($_POST['country']))){
        }elseif($_POST['country'] == $sqlcheck2['country']){
            //donothink
        }elseif(strlen($_POST['country']) < 4){
            $country_err = "realy no phone only 10 numbers? reinsert";
        }elseif(strlen($_POST['country']) > 24){
            $country_err = "country name max length 24";
        }elseif(!preg_match("/[a-zA-Z]/", $_POST['fullname'])){
            $countryr_err = "country can only be filled with letter";
        }else{
            $country = $_POST['country'];
           mysqli_query($conn, "UPDATE `profile` SET `country` = '$country' WHERE `profile`.`id_user` = '$iduser'");
        }
        $result = mysqli_fetch_array(mysqli_query($conn, "SELECT password FROM user where id_user = '$iduser'"));
        if(empty(trim($_POST['password']))){   
        }elseif(password_verify($_POST['password'],$result['password'])){
            $pass_err = "password yang dimasukan sama";
        }elseif(strlen($_POST['password'] < 6)){
            $pass_err = "password yang dimasukan kurang 6 huruf";    
        }else{
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE profile SET password = '$pass' WHERE id_user = '$iduser' ");
        }
    }

    header( "refresh:3;url=$domain?id=edit-profile" );
}


?>

<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Galery - Profile</title>
    <link rel="icon" type="image/png" href="img/logo/upicts.png">
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <style>
        body {
            background: #ff0552;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #ff0552;
        }

        .profile-button {
            background: #ff0552;
            box-shadow: none;
            border: none;
        }

        .profile-button:hover {
            background: #af0035;
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none;
        }
        .back i,
        .back h6 {
            text-decoration: none;
            color: black;
        }

        .back:hover {
            color: #682773;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'>
    </script>
    <script type='text/javascript'></script>
</head>
<?php 
while($profile=mysqli_fetch_array($Fprofile)){
?>
<body oncontextmenu='return false' class='snippet-body'>
    <div class="container rounded bg-white mt-5">
        <div class="row">
            <div class="col-md-4 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                        src="<?php echo $profile['imgprofile']; ?> " width="90"><span class="font-weight-bold"><?php echo $profile['fullname']; ?></span><span
                        class="text-black-50"><?php echo $profile['username']; ?></span><span><?php echo $profile['country']; ?></span></div>
            </div>
            <div class="col-md-8">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-row align-items-center back">
                            <a href="<?php echo $domain."?id=user";?>"><i class="fa fa-long-arrow-left mr-1 mb-1"></i>
                            </a>
                        </div>
                        <h6 class="text-right">Edit Profile</h6>
                    </div>
                    <form method="POST" href="<?php echo $domain."?id=edit-profile";?>" enctype="multipart/form-data">
                    <div class="row mt-2">
                        <div class="col-md-12"><input type="file" class="form-control" name="pict">
                        <span><?php echo $file_err;?></span>
                                </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12"><input type="text" class="form-control" placeholder="Full Name" name="fullname"
                                value="<?php echo $profile['fullname']; ?>"></div>
                        <span><?php echo $fullname_err; ?></span>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><input type="email" class="form-control" placeholder="Email"
                                value="<?php echo $profile['username'];?>" readonly></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><input type="number" class="form-control" placeholder="Phone Number" name="fullnumber"
                                value="<?php echo $profile['phone']; ?>"></div>
                        <span><?php echo $fullnumber_err;?></span>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><input type="text" class="form-control" placeholder="Country" name="country"
                                value="<?php echo $profile['country']; ?>"></div>
                        <span><?php echo $country_err;?></span>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><input type="password" class="form-control" placeholder="New Password" name="password"></div>
                        <span><?php echo $pass_err;?></span>
                    </div>
                    <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="submit">Save
                            Profile</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php } ?>
</html>