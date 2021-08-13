<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location:$domain?id=dashboard");
    exit;
}
if(empty($_GET['id'])){
    header("location: ../index.php");
    exit;
}
$username = $password = $confirm_password = $name = "";
$username_err = $password_err = $confirm_password_err = $name_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){ 
    
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your Email.";
    } else{
        $sql = "SELECT * FROM user WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = trim($_POST["username"]);            
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This email is already use.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty(trim($_POST["name"]))){
        $name_err = "please enter your Username.";
    }else{ 
        $name = trim($_POST["name"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err)){
        $sql = "INSERT INTO user (id_user, username, password) VALUES (?, ?, ?)"; 
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "iss", $param_id_user, $param_username, $param_password);           
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_id_user =  substr(crc32(date('jS F Y h:i:s')), 0, 9);
            if(mysqli_stmt_execute($stmt)){

            } else{
                die('Error with execute: ' . htmlspecialchars($stmt->error));
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($name_err)){
        $sql2 = "INSERT INTO profile (id_user, fullname) VALUES (?, ?)"; 
        if($stmt2 = mysqli_prepare($conn, $sql2)){
            mysqli_stmt_bind_param($stmt2, "is", $param_id_user, $param_fullname);           
            $param_fullname = $name;
            $param_id_user =  substr(crc32(date('jS F Y h:i:s')), 0, 9);
            if(mysqli_stmt_execute($stmt2)){
                header("location:$domain?id=sign-in");    
            } else{
                die('Error with execute: ' . htmlspecialchars($stmt2->error));
                echo "Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt2);
        } 
    }
    mysqli_close($conn);
}

?>

<html>
<head>
    <title>Sign Up</title>
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
                    <h1 class="title title-large">Sign Up</h1>
                    <p class="title title-subs">Already have an account? <span><a href="<?php echo $domain."?id=sign-in";?>"
                                class="linktext">
                                Sign In</a></span></p>
                </div>
                <form action=<?php echo $RSHH."?id=sign-up";?> method="POST">
                    <div class="form-group">
                        <input type="text" name="name"  class="input-field" placeholder="Full name">
                        <span class="help-block"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group">
                        <input type="email" name="username"  class="input-field" placeholder="Email">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="password"  class="input-field" placeholder="Password">
                        <span class="help-block"><?php echo $password_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                        <input type="password" name="confirm_password"  class="input-field"
                            placeholder="Confirm Password">
                            <span class="help-block"><?php echo $confirm_password_err; ?></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="input-submit"
                                value="Sign Up">Sign up</button>
                            </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>