<?php 
    require dirname(__FILE__) . "/../utils/data.php";
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("Location: /~paspoiva/Semestralni-prace/main/");
        exit;
    }
    
    $email = $username = $email_err = $password_err = $register_err = $password_confirm_err= "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(empty(trim($_POST["email"]))){
            $email_err = "Please enter email.";
        } else if(!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
            $email_err = "Please provide a valid email.";
        } else if(empty(trim($_POST["password"]))){
            $password_err = "Please enter your password.";
        } else {
            $email = trim($_POST["email"]);
            $username = trim($_POST["username"]);
            $isOk = password_validation($_POST);
            if($isOk) {
                // echo "dick";
                $isAdded = add_user(trim($_POST["email"]), trim($_POST["password"]), trim($_POST["username"]));
                if($isAdded) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $username;
                    header("Location: /~paspoiva/Semestralni-prace/main/");
                    exit;
                } else {
                    $register_err = "User already exists.";
                }
            } else {
                $password_err = "Invalid password";
            }
        }
    }

    /**
	 * Validates password.
	 * 
	 * @param mixed $post
	 */
    function password_validation($post) {
        if ((strlen($post['password']) < 8)) {
            global $password_err;
            $password_err = "Password must be at least 8 characters long";
            return false;
        } else if ($post['password'] != $post['passwordConfirm']) {
            global $password_confirm_err;
            $password_confirm_err = "Passwords do not match";
            return false;
        } else {
            return true;
        }
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TRIAL BEATS - Registration</title>
    <link rel="icon" type="image/x-icon" href="public/img/favicon.png">
    <link rel="stylesheet" href="public/css/REGstyle.css">

    <script src="public/js/validation.js"></script>
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="/~paspoiva/Semestralni-prace/main/" id="home">Home</a>
    </div>
    <form action="register" method="post" class = "user-form">

        <fieldset class="container">
            <legend>REGISTRATION</legend>
            <div class="row">
              <label for="name">Username</label>
              <input type="text"  name="username" placeholder="Enter Your Username" id="username" required value = "<?php 
                echo $username;
              ?>">
            </div>
            <div class="row">
              <label for="email">Email</label>
              <input type="email"  name="email" placeholder="Enter Email" id="email" required value = "<?php 
                echo $email;
              ?>">
              <?php 
                if(strlen($email_err) > 0){
                    echo <<<"EOT"
                    <div class="row">
                        <p class="error">$email_err</label>
                    </div>
                    EOT;
                } else if(strlen($register_err) > 0) {
                    echo <<<"EOT"
                    <div class="row">
                        <p class="error">$register_err</p>
                    </div>
                    EOT;
                }
            ?>
            </div>
            
            <div class="row">
                <label for="password">Password (8 characters minimum):</label>
                <input type="password" id="password" name="password" required>
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
                <label for="passwordConfirm">Password confirm:</label>
                <input type="password" id="passwordConfirm" name="passwordConfirm" required>
                <?php 
                    if(strlen($password_confirm_err) > 0){
                        echo <<<"EOT"
                        <div class="row">
                            <p class="error">$password_confirm_err</p>
                        </div>
                        EOT;
                    }
                ?>
            </div>
            <div class="row">
                <p>Already registered? <a href="/~paspoiva/Semestralni-prace/main/login" class="linkLogin">Login</a></p>
            </div>

            <button type="submit" class="registerbtn">Register</button>

        </fieldset>


        <script type="text/javascript">
            init();
        </script>
    </form>
</body>
</html>
