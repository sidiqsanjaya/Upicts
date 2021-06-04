<?php
$sqldashboard = mysqli_query($conn,"SELECT * FROM `upicts`.`link_image` INNER JOIN `upicts`.`image` ON ( `link_image`.`id_image` = `image`.`id_image` )");
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
            Upicts
        </a>
        <div id="menu" class="fas fa-bars"></div>
        <?php if($logintrue){ ?>
        <nav class="navbar">
            <ul>
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

        <form action="">
            <input type="search" id="home-search" placeholder="search images">
            <label for="home-search" class="fas fa-search"></label>
        </form>

        <ul class="suggestion">
            <li>suggestions : </li>
            <li><a href="#">nature</a></li>
            <li><a href="#">girl</a></li>
            <li><a href="#">man</a></li>
            <li><a href="#">corporate</a></li>
            <li><a href="#">city</a></li>
            <li><a href="#">more...</a></li>
        </ul>

    </section>

    <!-- home section ends -->

    <!-- gallery section start  -->

    <section class="gallery">
        <?php
            while($fdash=mysqli_fetch_array($sqldashboard)){
        ?>
        <div class="box">
            <img src="<?php echo $fdash['temp_img']; ?>" alt="img1" title="<?php echo $fdash['title']; ?>">
            <div class="info">
                <a href="<?php echo $fdash['raw_img']; ?>" title="<?php echo $fdash['title']; ?>" class="fas fa-download" download="<?php echo $fdash['raw_img']; ?>"> <?php echo $fdash['download']; ?></a>
                <div class="links">
                    <a href="#" class="far fa-heart"></a>
                </div>
            </div>
        </div>
        <?php } ?>


    </section>

    <!-- gallery section ends -->

    <a href="#" class="more">see more</a>

    <!-- footer section starts  -->

    <section class="footer">

        <div class="box-container">

            <div class="box">
                <h3>why choose us?</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, ducimus vitae enim cum vero fugiat
                    minima reprehenderit dolores eaque voluptate.</p>
            </div>

            <div class="box">
                <h3>quick links</h3>
                <a href="#">home</a>
                <a href="#">link1</a>
                <a href="#">link2</a>
                <a href="#">register</a>
            </div>

            <div class="box">
                <h3>newsletter</h3>
                <p>subscribe for latest updates</p>
                <form action="">
                    <input type="email" placeholder="enter your email">
                    <button class="fas fa-paper-plane"></button>
                </form>
            </div>

        </div>

        <h1 class="credit"> &#169; 2021 <a href="#">Upicts</a> all rights reserved.</h1>

    </section>

    <!-- footer section ends -->

    <!-- jquery cdn link  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- custom js file link  -->
    <script src="js/main.js"></script>


</body>

</html>
