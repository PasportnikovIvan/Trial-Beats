<?php 
    require dirname(__FILE__) . "/../utils/data.php"; 
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("Location: /~paspoiva/Semestralni-prace/main/");
        exit;
    }

    $email = $password = "";
    $email_err = $password_err = $login_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // check if username is empty
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter email.";
        } else{
            $email = trim($_POST["email"]);
        }
        
        // Check if password is empty
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else{
            $password = trim($_POST["password"]);
        }
        if(empty($email_err) && empty($password_err)){
            $isOk = user($email, $password);
            if($isOk) {
                $_SESSION["loggedin"] = true;
                header("Location: /~paspoiva/Semestralni-prace/main/");
            } else {
                $login_err = "No such user found";
            }
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="public/img/favicon.png">
    <title>TRIAL BEATS - Login</title>

    <link rel="stylesheet" href="public/css/REGstyle.css">

    <script src="public/js/validation.js"></script>

</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="/~paspoiva/Semestralni-prace/main/" id="home">Home</a>
    </div>
    <form action="login" method="post" class = "user-form">

        <fieldset class="container">
            <legend>LOGIN</legend>

            <div class="row">
              <label for="email">Email</label>
              <input type="email" name="email" placeholder="Enter Email" id="email" required value="<?php
                echo $email;
              ?>">
              <?php 
                    if(strlen($email_err) > 0){
                        echo <<<"EOT"
                        <div class="row">
                            <p class="error">$email_err</p>
                        </div>
                        EOT;
                    } else if(strlen($login_err) > 0) {
                        echo <<<"EOT"
                        <div class="row">
                            <p class="error">$login_err</p>
                        </div>
                        EOT;
                    }
                ?>
            </div>

            <div class="row">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password"  required>
                <?php 
                    if(strlen($password_err) > 0){
                        echo <<<"EOT"
                        <div class="row">
                            <p class="error">$password_err</p>
                        </div>
                        EOT;
                    }
                ?>
            </div>
            
            <div class="row">
                <p>Not registered yet? <a href="/~paspoiva/Semestralni-prace/main/register" class="linkLogin">Register</a></p>
            </div>

            <button type="submit" class="registerbtn">Login</button>

        </fieldset>

        <script type="text/javascript">
            init();
        </script>
    </form>
</body>
</html>
