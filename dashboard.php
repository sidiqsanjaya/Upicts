<?php
if(Empty(trim($_GET['cari']))){
    $sqldashboard = mysqli_query($conn, "SELECT `image`.*, `link_image`.* FROM `image` LEFT JOIN `link_image` ON `link_image`.`id_image` = `image`.`id_image` ORDER BY RAND() LIMIT 20");
}else{
     $cari = $_GET['cari'];
    $sqldashboard = mysqli_query($conn, "SELECT `link_image`.*, `image`.*, `image_category`.*, `category`.* FROM `link_image` LEFT JOIN `image` ON `link_image`.`id_image` = `image`.`id_image` LEFT JOIN `image_category` ON `image_category`.`id_image` = `image`.`id_image` LEFT JOIN `category` ON `image_category`.`id_category` = `category`.`id_category` WHERE category.`name_category` LIKE '%$cari%' OR image.`title` LIKE '%$cari%' ORDER BY RAND() LIMIT 20");
}
$rand  = mysqli_query($conn,"SELECT * FROM category ORDER BY RAND() LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upicts galerry</title>
    <link rel="icon" type="image/png" href="img/logo/upicts.png">
    <!-- font awesome cdn  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <!-- custom css  -->
    <link rel="stylesheet" href="css/style.css?v=5">

</head>

<body>

    <!-- header start  -->

    <header>
        <a href="/" class="logo">
            <img src="img/logo/logo.png" witdh="30px" height="30px" alt="img1" title="">
        </a>
        <div id="menu" class="fas fa-bars"></div>
        <?php if($logintrue){ ?>
        <nav class="navbar">
            <ul>
                <?php if($level == 'master'){
                    echo '<li><a href="?id=admin">admin</a></li>';

                }?>

                <li><a href="<?php echo "?id=upload"?>">Upload</a></li>

                <li><a href="<?php echo "?id=user"?>">Profile</a></li>

            </ul>

        </nav>

        <a href="<?php echo "?id=logout"?>" class="upload">Logout</a>

        <?php }else{ ?>

        <a href="<?php echo "?id=sign-in"?>" class="upload">login</a>

        <?php } ?>

        </header>



    <!-- header end  -->



    <!-- home start   -->

    <section class="home">

        <h1>Search Stock Photos & Images</h1>

        <form action="" method="GET">

            <input type="search" id="home-search" placeholder="search images" name="cari" value="<?php echo $cari;?>">

            <label for="home-search" class="fas fa-search"></label>

        </form>

        <ul class="suggestion">
            <li>suggestions : </li>
            <?php while($sugest = mysqli_fetch_array($rand)){ ?>
            <li><a href="?cari=<?php echo $sugest['name_category'];?>"><?php echo $sugest['name_category'];?></a></li>
            <?php } ?>
        </ul>
    </section>
    <section class="gallery">
        <?php
            while($fdash=mysqli_fetch_array($sqldashboard)){
        ?>
        <div class="box">
            <img src="<?php echo $fdash['temp_img']; ?>" alt="img1" title="<?php echo $fdash['title']; ?>">
            <div class="info">
                <a id="<?php echo $fdash['id_image'];?>" onclick="prosesd(this.id)" href="<?php echo $fdash['raw_img']; ?>" title="<?php echo $fdash['title']; ?>" class="fas fa-download" download="<?php echo $fdash['title']; ?>.jpg"> <?php echo $fdash['download']; ?></a>
                <div class="links">
                    <a id="<?php echo $fdash['id_image'];?>" onclick="proses(this.id)" class="far fa-heart"></a>
                </div>
            </div>
        </div>
        <?php } ?>

    </section>

    <section class="footer">

        <div class="box-container" id="aa">

        </div>

        <h1 class="credit"> &#169; 2021 <a href="#">Upicts</a> all rights reserved.</h1>
    </section>
    <!-- jquery cdn link  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- custom js file link  -->
    <script src="js/main.js"></script>
    <script>
        function proses(clicked_id){
            var id = clicked_id;
            $.post("addlove.php",
        {
            id
        },
        function(data,status){
        });
        }
        function prosesd(clicked_id){
            var d = clicked_id;
            $.post("addlove.php",
        {
            d
        },
        function(data,status){
        });
        }
    </script>
</body>

</html>

