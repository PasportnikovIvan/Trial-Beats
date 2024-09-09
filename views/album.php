<?php 
    require dirname(__FILE__) . "/../utils/data.php";
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
        header("Location: /~paspoiva/Semestralni-prace/main/");
        exit;
    }
    $albumId = $_GET["id"] - 1;
    $username = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="public/img/favicon.png">
        <link rel="stylesheet" href="public/css/AlbStyle.css">
        <title>TRIAL BEATS - Album</title>

    </head>
    <body><div class="layer layers__base"></div>
        <div id="mySidenav" class="sidenav">
            <a href="/~paspoiva/Semestralni-prace/main/" id="home">Home</a>
        </div>

            <header class="main-header">
               <div class="column">
                 <div class="layers">
                    <?php
                        data($albumId);
                    ?>
                    <form method = "post" action = "like">
                        <input value="<?php echo $albumId?>" hidden name = "album_id"/>
                        <input value="<?php
                            echo $_SERVER['REQUEST_URI'];
                            ?>" 
                        hidden name = "back_url"/>
                        <button type="submit" class = "svg-button">
                            <!-- <img src="public/img/heart.svg" class="like-button active"/> -->
                            <svg class = "like-button" width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class = "<?php 
                                    if(is_liked($username, $albumId)){
                                        echo "active";
                                    } else {
                                        echo "";
                                    }
                                ?>" d="M16.44 3.10156C14.63 3.10156 13.01 3.98156 12 5.33156C10.99 3.98156 9.37 3.10156 7.56 3.10156C4.49 3.10156 2 5.60156 2 8.69156C2 9.88156 2.19 10.9816 2.52 12.0016C4.1 17.0016 8.97 19.9916 11.38 20.8116C11.72 20.9316 12.28 20.9316 12.62 20.8116C15.03 19.9916 19.9 17.0016 21.48 12.0016C21.81 10.9816 22 9.88156 22 8.69156C22 5.60156 19.51 3.10156 16.44 3.10156Z" fill="#292D32"/>
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="copy">© paspoiva FEL CVUT</div></div>

            </header>
    </body>
</html>
