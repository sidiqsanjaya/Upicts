<?php
if(!$logintrue){
    header("location:/");
    exit;
}
if(empty($_GET['id'])){
  header("location: ../index.php");
  exit;
}
$sqllist = mysqli_query($conn, "SELECT `user`.`username`,`profile`.`fullname`,`profile`.`country`,`profile`.`imgprofile` FROM `user`
LEFT JOIN `profile`
  ON `profile`.`id_user` = `user`.`id_user`
WHERE `user`.`id_user` = '$iduser'");

$sqldata = mysqli_query($conn, "SELECT `image`.*, `link_image`.*, `user`.* FROM `image` JOIN `link_image` ON `link_image`.`id_image` = `image`.`id_image` JOIN `user` ON `image`.`id_user` = `user`.`id_user` WHERE `user`.`id_user` = '$iduser'");
$sqlsuka = mysqli_query($conn, "SELECT `image`.*, `like_image`.*, `link_image`.* FROM `image` LEFT JOIN `like_image` ON `like_image`.`id_image` = `image`.`id_image` LEFT JOIN `link_image` ON `link_image`.`id_image` = `image`.`id_image` WHERE like_image.`id_user` = '$iduser'");

?>
<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Galerry - Profile</title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="./profile/style.css">
    <link rel="stylesheet" href="./css/style.css?v=5">
</head>

<body class='snippet-body'>
    <div class="container rounded bg-white mt-5">
        <div class="col-lg-12">
            <div class="p-3 py-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex flex-row align-items-center">
                        <a href="<?php echo $domain;?>"><<<<<i class="fa fa-long-arrow-left mr-1 back"></i>
                        </a>
                    </div>
                    <a href="<?php echo $domain."?id=edit-profile";?>" class="fa fa-cog text-right"></a>
                </div>
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <?php while($profile=mysqli_fetch_array($sqllist)){?>
                    <img class="rounded-circle mt-5" src="<?php echo $profile['imgprofile'];?>" width="90">
                    <span class="font-weight-bold nama"><?php echo $profile['fullname'];?></span><span class="text-black-50"><?php echo $profile['username'];?></span><span>Indonesia</span>
                    <?php } ?>
                </div>
            </div>
        </div>
        <hr>
        <div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h5 class="mb-0">
        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Foto yang kamu upload
        </button>
      </h5>
    </div>

    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
      <section class="gallery" id="ab">
            <?php while($foto=mysqli_fetch_array($sqldata)){ ?>
            <div class="box">
                <img src="<?php echo $foto['temp_img'];?>" alt="img1" title="img1"></img>
                <div class="info">
                    <div class="links">
                        <a id="<?php echo $foto['id_image'];?>" onclick="proses(this.id)" class="far fa-trash-alt"></a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </section>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Foto yang kamu sukai
        </button>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
      <section class="gallery" id="ab">
            <?php while($foto2=mysqli_fetch_array($sqlsuka)){ ?>
            <div class="box">
                <img src="<?php echo $foto2['temp_img'];?>" alt="img1" title="img1"></img>
                <div class="info">
                    <div class="links">
                        <a id="<?php echo $foto2['id_image'];?>" onclick="unsuka(this.id)" class="fas fa-heart"></a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </section>
      </div>
    </div>
  </div>
  </div>
</div>


    <script>
        function proses(clicked_id){
            var b = clicked_id;
            $.post("addlove.php",
        {
            b
        },
        function(data,status){
            window.location.href = "?id=user";
        });
        }
        function unsuka(clicked_id){
            var c = clicked_id;
            $.post("addlove.php",
        {
            c
        },
        function(data,status){
            window.location.href = "?id=user";
        });
        }
    </script>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'>
    </script>
    <script type='text/javascript'></script>
</body>

</html>