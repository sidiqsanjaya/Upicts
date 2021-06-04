<?php
if(!$logintrue){
    header("location:/");
    exit;
}

$Fprofile=mysqli_query($conn,"SELECT
`user`.`username`,
`profile`.`fullname`,
`profile`.`phone`,
`profile`.`country`,
`profile`.`imgprofile`
FROM
`user`
LEFT JOIN `profile`
  ON `profile`.`id_user` = `user`.`id_user`
WHERE `user`.`username` = '$Susername';");
?>

<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Galery - Profile</title>
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
                            <a href="/"><i class="fa fa-long-arrow-left mr-1 mb-1"></i>
                                <!-- 
                                <h6>Back</h6> -->
                            </a>
                        </div>
                        <h6 class="text-right">Edit Profile</h6>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12"><input type="text" class="form-control" placeholder="Full Name"
                                value="<?php echo $profile['fullname']; ?>"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><input type="text" class="form-control" placeholder="Email"
                                value="<?php echo $profile['username']; ?>"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><input type="text" class="form-control" placeholder="Phone Number"
                                value="<?php echo $profile['phone']; ?>"></div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-12"><input type="text" class="form-control" placeholder="Country"
                                value="<?php echo $profile['country']; ?>"></div>
                    </div>
                    <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="button">Save
                            Profile</button></div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php } ?>
</html>