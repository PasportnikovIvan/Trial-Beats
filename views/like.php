<?php
    ob_start();
    require dirname(__FILE__) . "/../utils/data.php";
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
        header("Location: /~paspoiva/Semestralni-prace/main/");
        exit;
    }
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(is_null($_POST["back_url"])) {
            header("Location: /~paspoiva/Semestralni-prace/main/");
            // echo "NO BACK URL";
            exit;
        }
        // echo $_POST["back_url"]."<br/>";
        // echo $_POST["album_id"]."<br/>";
        // echo trim($_POST["album_id"])."<br/>";
        // echo empty(trim($_POST["album_id"]))."<br/>";
        if(is_null($_POST["album_id"])) {
            header("Location: /~paspoiva/Semestralni-prace/main/");
            // echo "NO ALBUM ID";
            exit;
        }
        if(toggle_like($_SESSION["username"], $_POST["album_id"])){
            header("Location: " . $_POST["back_url"]);
            // echo "toggled A LIKE YOU DIPSHIT";
            exit;
        } else {
            header("Location: /~paspoiva/Semestralni-prace/main/");
            // echo "LIKE FAILED YOU DIPSHIT";
            exit;
        }
    }
    // echo "ITS NOT A POST REQUEST YOU DIPSHIT";
    header("Location: /~paspoiva/Semestralni-prace/main/");
    exit;
?>