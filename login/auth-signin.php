<?php
if($logintrue){
    header("location:/");
    exit;
}
if(empty($_GET['id'])){
    header("location: ../index.php");
    exit;
}
 
$username = $password = "";
$username_err = $password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your Email.";
    } else{
        $username = trim($_POST["username"]);
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }    
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id_user, username, password, level FROM user WHERE username = ?";        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);            
            $param_username = $username;            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $iduser, $username, $hashed_password, $level);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION['id_user'] = $iduser;
                            $_SESSION['id_user'] = $iduser;
                            $_SESSION['level'] = $level;
                            $_SESSION["cypherMethod"] = 'AES-256-CBC';
                            $_SESSION["key"] = random_bytes(32);
                            $_SESSION["iv"] = openssl_random_pseudo_bytes(openssl_cipher_iv_length($_SESSION["cypherMethod"]));
                            header("location: $domain?id=dashboard");
                        } else{
                            $password_err = "Password invalid.";
                        }
                    }
                } else{
                    $username_err = "username not found.";
                }
            } else{
                //echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>



<head>
    <title>Upicts | Signin Form</title>
    <link rel="icon" type="image/png" href="img/logo/upicts.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="login/css/style.css">
</head>

<body>
    <main class="main">
        <div class="wrapper">
            <div class="card">
                <div class="title">
                    <h1 class="title title-large">Sign In</h1>
                    <p class="title title-subs">New user? <span><a href="?id=sign-up" class="linktext">Create
                                an
                                account</a></span></p>
                </div>
                <form action="?id=sign-in" method="POST" class="form">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <input type="username" name="username" class="input-field" placeholder="Email address">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="password" class="input-field" placeholder="Password">
                        <span class="help-block form-group"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="input-submit"
                                value="Sign in">Sign in</button></a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
