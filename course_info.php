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
    <link href="./css/course_info.css" rel="stylesheet">

</head>

<style>

    
</style>
<body>
    <!-- <img src="assets/images/grey-background.jpg" alt='background' class="background img-fluid"> -->
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

    <div class="main-container">
        <div class="head">
            <div class="title-text">
              <h1><?= $title ?></h1>
              <!-- <p><?= substr($description,0,45) ?>...</p> -->
              <!-- <p> some kind of important descriptive text for display some kind of important descriptive text for display</p> -->
            </div>
            <div class="price">
              <h4>One time payment</h4>
              <h3>$<?= $price ?></h3>
              <a href='payment.php?p=<?= $_GET['p'] ?>'><div class="btn buy-btn">buy now</div></a>
            </div>
        </div>
        <div class='img-section'>
          <img src="videos/<?= $code.'/'.$thumbnail?>" alt="stuff" class='img-fluid'>
        </div>


        <div class="course-description text-center p-5">
          <h2>Course Description</h2>
          <p style='text-align: left;font-size: 25px;'><?= $description[0].strtolower(substr($description,1,strlen($description))) ?>
          </p>
        </div>
        <div class="course-content text-center p-5">
          <h2>Course Content </h2>
        </div>
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">1. Introduction</button>
            </h2>
          <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingTwo">
            <button class="accordion-button collapsed show" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
              2. utilizing blockchain
            </button>
          </h2>
          <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="flush-headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
              3. The way forward
            </button>
          </h2>
          <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
            <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the third item's accordion body. Nothing more exciting happening here in terms of content, but just filling up the space to make it look, at least at first glance, a bit more representative of how this would look in a real-world application.</div>
          </div>
        </div>
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