<?php
    session_start();
 
    include 'controllers/pcrypt.php';

    if(!isset($_SESSION['key']))
    {
      $_SESSION['key'] = $pcrypt->gen_random_key();
      header("Location: ./index.php");
    }

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = "em-db";

    $con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
    if($con->connect_error)
    {
        die('unable to connect to database '.$dbname);
    }

    if(isset($_GET['p']))
    {
      if($_GET['p'] == '')
      {
        $_SESSION['url'] = substr($_SERVER['REQUEST_URI'],0,strlen($_SERVER['REQUEST_URI']) - 4);
        echo $_SESSION['url'];
        header("Location: 404.php"); 
      }

      $id = $_GET['p'];
      $id = $pcrypt->decrypt($id,$_SESSION['key']);

      $id = strip_tags($id);
      $id = htmlspecialchars($id);
    
        $stmt = $con->prepare("SELECT TITLE,DESCRIPTION,THUMBNAIL,PRICE FROM courses WHERE CODE = ?");
        if($stmt)
        {
            $stmt->bind_param('s',$id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($title,$description,$thumbnail,$price);
            $code = $id;
            $stmt->fetch(); 

        }
        else{
          header("Location: ./courses.php");
        }
        $stmt->close(); 
    }

    $con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empowered Blockchain Hub</title>
    <link href="assets/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous"> -->
    <!-- <link href="assets/fontawesome-free-6.0.0-beta3-web/css/all.css" rel="stylesheet"> -->
    <link href="./css/posts.css" rel="stylesheet">

</head>

<style>

    
</style>
<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light">
        <div class="container-fluid mx-2">
            <a class="navbar-brand" href="#">
                <img src="assets/images/em_logo2.png" alt="" class="img-fluid" style="width:50px; height:50px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link active" href="courses.php">Courses</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link"href="#">Blog</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="about.php" tabindex="-1" aria-disabled="true">About Us  </a>
                    </li>
                </ul>
                <a href="<?php if(isset($_SESSION['loggedin'])) echo "logout.php";else echo "login.php?location=".urlencode($_SERVER['REQUEST_URI']); ?>">
                    <button class="btn btn-primary navbar-btn login-btn"><?php if(isset($_SESSION['loggedin'])) echo "Sign out"; else echo "Login"; ?></button>
                </a>
            </div>
        </div>
    </nav>

    <div class="container post-container">
        <div class="row post-img">
            <img style="height: 29rem;" src="posts\621a08c99fc41\post-image.jpg" alt="">
        </div>
        <div class="row post-text">
            fjajf akljaklej aekl;fjaekl faj;weklfj;
        </div>
    </div>

    <footer>
        <div class="footer-text">Empowered Blockchain Hub &copy; <?= date('Y') ?></div>
    </footer>
    <script src='assets/bootstrap-5.0.2-dist/js/bootstrap.min.js'></script>
    <script src="assets/fontawesome-free-6.0.0-beta3-web/js/all.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script> -->

</body>
</html>