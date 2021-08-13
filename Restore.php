<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST['tipe'] == 'Restore'){
        if($_FILES['file']['type'] == 'application/octet-stream'){
            $filename = $_FILES['file']['tmp_name'];
            $handle = fopen($filename,"r+");
            $contents = fread($handle,filesize($filename));
            $sql = explode(';',$contents);
            foreach($sql as $query){
              $result = mysqli_query($conn,$query);
              if($result){
                  mysqli_error($conn);
              }
            }
            fclose($handle);
            //echo 'Successfully imported';  
            header("Location: ?id=dashboard");
        }else{
            echo "data yang dikirim bukan sql";
        }
    }
}
?>
<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
  	<link rel="icon" type="image/png" href="img/logo/upicts.png">
    <title>Galery - admin</title>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="./profile/style.css">
    <link rel="stylesheet" href="./css/style.css?v=5">
</head>

<section class="home">
        <h1>Table error, Required to restore table</h1>
        <form action="" class="aaa" method="POST" enctype="multipart/form-data">
                                <div class="input-group display-5">
                                    <div class=" input-group-prepend"></div>
                                    <div class="custom-file">
                                        <input type="file" name="file" class="form-control">
                                    </div>
                                    <br>
                                    <button type="submit" name="tipe" value="Restore" class="btn btn-primary btnmemulihkan ">Restore</button>
                                </div>
                        </form>
</section>


<script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'>
    </script>
    <script type='text/javascript'></script>
</body>

</html>