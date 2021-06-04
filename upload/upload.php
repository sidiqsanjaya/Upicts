<?php
if(!$logintrue){
    header("location:/");
    exit;
}
//sql user
$user = mysqli_query($conn,"SELECT * FROM USER WHERE username = '$Susername';");
while($fuser=mysqli_fetch_array($user)){
    $id_user = $fuser['id_user'];
}
$category = mysqli_query($conn,"SELECT * FROM category");

//init
$title = $filename = $filetmp = "";
$title_err = $file_err = $category_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    //init start
    $extension_accept = array('jpeg','jpg','png','tiff','raw');
    $foldercomp =   'img/temp/';
    $folderraw  =   'img/raw/';
    $id_image   =   substr(crc32(date('jS F Y h:i:s')), 0, 8);
    $filetmp  = $_FILES['file']['tmp_name'];
    $filename = $_FILES['file']['name'];
    $filetype = $_FILES['file']['type'];


    

    //init check
    if(empty(trim($_POST["title"]))){
        $title_err = "must be fill";
    }else{
        $title = $_POST['title'];
    }
    if(empty(trim($_POST['category2']))){
        $category_err = 'must be selected category';
    }else{
        $category2 = $_POST['category2'];
    }  

    //split extension
    $ex = explode('.', $filename);
    $extension = strtolower(end($ex));
    //init start namefile
    $temp_img   =   $id_image."temp.".$extension;
    $raw_img    =   $id_image."raw.".$extension;
    
    //init sql check & upload
    if(empty($title_err) && empty($file_err) && empty($category_err)){
        if(in_array($extension, $extension_accept) === true){
            move_uploaded_file($filetmp, $folderraw.$raw_img);
            copy($folderraw.$raw_img, $foldercomp.$temp_img);
        }else{
            echo "Sorry, only JPG, JPEG, PNG, files are allowed to upload.";
        }
    }
    if(empty($title_err) && empty($file_err) && empty($category_err)){
        if(in_array($extension, $extension_accept) === true){
        $sqlimage = "INSERT INTO `image` (`id_image`, `id_user`, `title`, `download`, `upload_data`) VALUES (?, ?, ?, ?, ?)";
            if($stmt = mysqli_prepare($conn, $sqlimage)){
                mysqli_stmt_bind_param($stmt, "iisis", $param_id_image, $param_id_user, $param_title, $param_download, $param_upload_data);
                $param_id_image = $id_image;
                $param_id_user  = $id_user;
                $param_title    = $title;
                $param_download = 0;
                $param_upload_data = date('Y-m-d');
                if(mysqli_stmt_execute($stmt)){

                }else{
                    die('Error with execute: ' . htmlspecialchars($stmt->error));
                    echo "somenthing went wrong. please try again later.";
                }
                mysqli_stmt_close($stmt);
            }
        }
    }
    if(empty($title_err) && empty($file_err) && empty($category_err)){
        if(in_array($extension, $extension_accept) === true){
            $param_id_image = $id_image;
            $param_temp_img = $foldercomp . $temp_img;
            $param_raw_img  = $folderraw . $raw_img;
            $sqlilink = "INSERT INTO `link_image` (`id_image`, `temp_img`, `raw_img`) VALUES ($param_id_image, '$param_temp_img', '$param_raw_img')";
            $hasil=mysqli_query($conn, $sqlilink);
            if (!$hasil){
                $error_data = mysqli_error($conn);
            }
        }  
    }
    mysqli_close($conn);
    if(empty($title_err) && empty($file_err) && empty($category_err)){
        if(in_array($extension, $extension_accept) === true){
            $param_id_image = $id_image;
            $param_id_category = $category2;
            $sqlimgcategory = "INSERT INTO `image_category` (`id_image`, `id_category`) VALUES ($param_id_image, $param_id_category)";
            $hasil2=mysqli_query($conn, $sqlimgcategory);
            if (!$hasil){
                $error_data = mysqli_error($conn);
                
            }else{
                header("location:/");
            }
        }
    }
}
echo $error_data;

?>

<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Upicts | Upload</title>
    <link rel="icon" type="image/png" href="img/logo/upicts.png">
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'>
    </script>
    <script type='text/javascript'></script>
</head>
<style>
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
<body oncontextmenu='return false' class='snippet-body'>

    <div class="col-md-6 offset-md-3 mt-5">
        <a href="/"><i class="fa fa-long-arrow-left mr-1 mb-1"></i>
            <!-- 
            <h6>Back</h6> -->
        </a>
        <h1>Upload</h1>
        <form accept-charset="UTF-8" action="?id=upload" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="Title">Upload</label>
                <input type="text" name="title" class="form-control" id="Title" placeholder="Enter The Title"
                    required="required">
                    <span class="help-block control"><?php echo $title_err; ?></span>
            </div>
            <div class="form-group">
                <label for="category2" required="required">Category</label>
                <select class="form-select form-control" id="category2" name="category2">
                    <option selected>select category</option>
                    <?php 
                    while($fcategory=mysqli_fetch_array($category)){
                    ?>
                    <option value="<?php echo $fcategory['id_category'];?>"><?php echo $fcategory['name_category'];?></option>
                    <?php } ?>
                </select>
                <span class="help-block control"><?php echo $category_err; ?></span>
            </div>
            <div class="form-group mt-3">
                <label for="fileupload" require="required">Upload here you image</label>
                <input type="file" class="form-control" name="file" id="fileupload">
                <span class="help-block control"><?php echo $file_err; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>