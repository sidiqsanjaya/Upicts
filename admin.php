<?php

if(empty($_GET['id'])){

    header("location: index.php");

    exit;

}

if(!$logintrue && $level =='master'){

    header("location:/");

    exit;

}



if($_SERVER["REQUEST_METHOD"] == "POST"){

    if($_POST['tipe'] == 'Restore'){

        if($_FILES['file']['type'] == 'application/octet-stream'){

            $filename = $_FILES['file']['tmp_name'];

            $handle = fopen($filename,"r+");

            $contents = fread($handle,filesize($filename));

            $sql = explode(';',$contents);

            foreach($sql as $query){

              $result = mysqli_query($conn,$query);

            }

            fclose($handle);

            echo 'Successfully imported';  

            header("Location: ?id=admin");

        }else{

            echo "data yang dikirim bukan sql";

        }

    }



    if($_POST['tipe'] == 'Backup'){

        $tables = array();

        $result = mysqli_query($conn,"SHOW TABLES");

        while($row = mysqli_fetch_row($result)){

        $tables[] = $row[0];

        }

        $return = '';

        $return = "SET FOREIGN_KEY_CHECKS = 0;\n";

        foreach($tables as $table){

        $result = mysqli_query($conn,"SELECT * FROM ".$table);

        $num_fields = mysqli_num_fields($result);

        

        $return .= 'DROP TABLE '.$table.';';

        $row2 = mysqli_fetch_row(mysqli_query($conn,"SHOW CREATE TABLE ".$table));

        $return .= "\n\n".$row2[1].";\n\n";

        

        for($i=0;$i<$num_fields;$i++){

            while($row = mysqli_fetch_row($result)){

            $return .= "INSERT INTO ".$table." VALUES(";

            for($j=0;$j<$num_fields;$j++){

                $row[$j] = addslashes($row[$j]);

                if(isset($row[$j])){ $return .= '"'.$row[$j].'"';}

                else{ $return .= '""';}

                if($j<$num_fields-1){ $return .= ',';}

            }

            $return .= ");\n";

            }

        }

        $return .= "\n\n\n";

        }

        $return .= "SET FOREIGN_KEY_CHECKS = 1;";

        if(!empty($return))

            {

                // Save the SQL script to a backup file

                $backup_file_name = $database_name . '_backup_' . time() . '.sql';

                $fileHandler = fopen('./sql/backup/'.$backup_file_name, 'w+');

                $number_of_lines = fwrite($fileHandler, $return);

                fclose($fileHandler); 



                // Download the SQL backup file to the browser

                header('Content-Description: File Transfer');

                header('Content-Type: application/octet-stream');

                header('Content-Disposition: attachment; filename=' . basename('./sql/backup/'.$backup_file_name));

                header('Content-Transfer-Encoding: binary');

                header('Expires: 0');

                header('Cache-Control: must-revalidate');

                header('Pragma: public');

                header('Content-Length: ' . filesize('./sql/backup/'.$backup_file_name));

                ob_clean();

                flush();

                readfile('./sql/backup/'.$backup_file_name);

                exec('rm ' . './sql/backup/'.$backup_file_name); 

            }

    }

}



$sqlsuka = mysqli_query($conn, "SELECT `image`.*, `like_image`.*, `link_image`.* FROM `image` LEFT JOIN `like_image` ON `like_image`.`id_image` = `image`.`id_image` LEFT JOIN `link_image` ON `link_image`.`id_image` = `image`.`id_image`");



?>

<!doctype html>

<html>



<head>

    <meta charset='utf-8'>

    <meta name='viewport' content='width=device-width, initial-scale=1'>
  	<link rel="icon" type="image/png" href="img/logo/upicts.png">

    <title>Galerry - admin</title>

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

                </div>

                <div class="d-flex flex-column align-items-center text-center p-3 py-5">

                            <h3>welcome Admin</h3>

                    </div>

            </div>

        </div>

        <div id="accordion">

  <div class="card">

    <div class="card-header" id="headingOne">

      <h5 class="mb-0">

        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

          Database restore atau backup

        </button>

      </h5>

    </div>



    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">

            <div class="container">

                <div class="row">

                    <div class="col">

                        <p>Backup Database</p>

                        <form action="?id=admin" method="POST" enctype="multipart/form-data">

                            <div class="col input-group mb">

                                <div class="input-group-prepend">

                                </div>

                                <button type="submit" name="tipe" value="Backup" class="btn btn-primary">Backup</button>

                            </div>

                        </form>

                    </div>

                    <div class="col">

                        <p>Restore Database</p>

                        <form action="?id=admin" method="POST" enctype="multipart/form-data">

                            <div class="col input-group mb">

                                <div class="input-group-prepend"></div>

                                <div class="custom-file">

                                    <input type="file" name="file">

                                </div>

                                <button type="submit" name="tipe" value="Restore" class="btn btn-primary">Restore</button>

                            </div>

                        </form>

                    </div>

                </div>

                <div class="row">

                    <div class="col">

                        

                    </div>

                    <div class="col">

                        

                        <br>

                        <br>

                    </div>

                </div>

                <div class="row">

                    <div class="col">

                        <table class="table">

                            <thead class="bg-dark text-white text-center">

                                <tr><td>table in Upicts</td><td>total data</td></tr>

                            </thead>

                            <tbody>

                                <?php 

                                $data = mysqli_query($conn, "SHOW TABLES");

                                while($a = mysqli_fetch_array($data)){
				    $b = $a['Tables_in_'.$database];
                                    $jml = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM $b"));
                                    echo "<tr><td>".$a['Tables_in_'.$database]."</td><td class='text-center'>".$jml."</td></tr>";                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="col">
                        <table class="table">
                                <thead class="bg-dark text-white text-center">
                                    <tr><td></td></tr>

                                </thead>

                                <tbody>

                                    <tr><td>a</td></tr>

                                    <tr><td>a</td></tr>

                                    <tr><td>a</td></tr>

                                    <tr><td>a</td></tr>

                                    <tr><td>a</td></tr>

                                </tbody>

                        </table>

                    </div> -->

                </div>

            </div>

    </div>

  </div>

  <div class="card">

    <div class="card-header" id="headingTwo">

      <h5 class="mb-0">

        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">

          Picture from user upload

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

                        <a id="<?php echo $foto2['id_image'];?>" onclick="proses(this.id)" class="far fa-trash-alt"></a>

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

            var e = clicked_id;

            $.post("addlove.php",

        {

            e

        },

        function(data,status){

            window.location.href = "?id=admin";

        });

        }

    </script>

    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js'>

    </script>

    <script type='text/javascript'></script>

</body>



</html>