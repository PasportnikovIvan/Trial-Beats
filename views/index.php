<?php 
  session_start();
  require dirname(__FILE__) . "/../utils/data.php";
  if (!isset($_GET['page']) ){  
    $page_number = 1;  
  } else {
    if(is_numeric($_GET['page']) && in_array($_GET['page'], range(1,3))) {
      $page_number = $_GET['page'];  
    } else {
      header("Location: /~paspoiva/Semestralni-prace/main/404");
      exit;
    }
  }
  function is_page(int $page, int $expected){
    if($page == $expected)
        return true;
    else 
        return false;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="public/img/favicon.png">
    <link rel="stylesheet" href="public/css/style.css">

    <title>TRIAL BEATS</title>

    <script src="public/js/libs/gsap/gsap.min.js" defer></script>
    <script src="public/js/libs/gsap/ScrollTrigger.min.js" defer></script>
    <script src="public/js/libs/gsap/ScrollSmoother.min.js" defer></script>

    <script src="public/js/scroll.js" defer></script>
    <script src="public/js/popup.js"></script>

</head>
<body>
    <div class="menu">
      <?php
        if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) {
          echo <<<"EOT"
            <menu>
              <a href="register"><li>REGISTRATION</li></a>
            </menu>
            EOT;
        } else {
          echo <<<"EOT"
            <menu>
              <a href="logout"><li>LOGOUT</li></a>
            </menu>
            EOT;
        }
      ?>
    </div>
    <div class="wrapper">
      <div class="content">

        <header class="main-header">
            <div class="layers">
                <div class="layer__header">
                    <div class="layers__caption">Welcome to Beat Studio</div>
                    <div class="layers__title">TRIAL BEATS</div>
                </div>
                <div class="layer layers__base"></div>
                <div class="layer layers__middle"></div>
            </div>
        </header>
        
        <a href="#" id="tracks" style="visibility: hidden">tracks</a>
        <article class="main-article">
          <div class="main-article__content">
                <!-- <div class="main-article__album"><a href="album?id=1"><img src="public/img/capAlbum.jpg" alt="album"></a></div>
                <div class="main-article__album"><a href="album?id=2"><img src="public/img/travisAlbum.png" alt="album"></a></div>
                <div class="main-article__album"><a href="album?id=3"><img src="public/img/phonk.jfif" alt="album"></a></div>
                <div class="main-article__album"><a href="album?id=4"><img src="public/img/SpaceSoldier.jpg" alt="album"></a></div>
                <div class="main-article__album"><a href="album?id=5"><img src="public/img/hyperpop.jfif" alt="album"></a></div>
                <div class="main-article__album"><a href="album?id=6"><img src="public/img/aloneAlbum.png" alt="album"></a></div> -->
              <?php 
                $albums = retrieve_data($page_number);
                $offset = ($page_number - 1) * 6;
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
                  foreach($albums as $id=>$album){
                    $correctId = $offset + $id + 1; 
                    echo <<<"EOT"
                      <div class="main-article__album"><a href="album?id=$correctId"><img src="$album[imgSrc]" alt="album"></a></div>
                      EOT;
                  }
                } else {
                  foreach($albums as $id=>$album){
                    echo <<<"EOT"
                      <div class="main-article__album"><img src="$album[imgSrc]" alt="album"></div>
                      EOT;
                  }
                  echo <<<"EOT"
                    <div id="snackbar">You have to Log in!</div>
                  EOT;
                }
              ?>
            </div>
            <div class="bottom">
                <div class = "pagination">
                    <a class = "pagination:number <?php if(is_page($page_number, 1)) echo "pagination:active" ?>" href = "/~paspoiva/Semestralni-prace/main/?page=1">1</a>
                    <a class = "pagination:number <?php if(is_page($page_number, 2)) echo "pagination:active" ?>" href = "/~paspoiva/Semestralni-prace/main/?page=2">2</a>
                    <a class = "pagination:number <?php if(is_page($page_number, 3)) echo "pagination:active" ?>" href = "/~paspoiva/Semestralni-prace/main/?page=3">3</a>
                </div>
                <span>© paspoiva FEL CVUT</span>
            </div>
        </article>

      </div>
    </div>
    <script type="text/javascript">
        assign_events();
    </script>
</body>
</html>
