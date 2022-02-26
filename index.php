<?php 
    session_start();
    include 'pcrypt.php';
    if(!isset($_SESSION['key']))
    {
      $_SESSION['key'] = $pcrypt->gen_random_key();
    }


    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = "courses";

    try{
      $con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
    }catch(Exception $e){
      die($e->getMessage());
    }

    if($con->connect_error)
    {
        die('unable to connect to database '.$dbname);
    }

    $result = $con->query("SELECT * FROM courses");
    $courses = Array();
    if($result->num_rows > 0)
    {
        $count = 0;
        while($row = $result->fetch_assoc())
        {
            array_push($courses,$row);     
            $count++;
        }
        // in order to view the latest
        $courses = array_reverse($courses);
    }
    else{
        $_SESSION['message'] = 'Create courses and view them here';
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
    <link href="assets/fontawesome-free-6.0.0-beta3-web/css/all.css" rel="stylesheet">
    <link href="./css/index.css" rel="stylesheet">

</head>

<style>
  @media screen and (max-width:576px){
    h1{
      font-size: 25px;
    }
    .btn-group-lg>.btn, .btn-lg{
      font-size: 12px;
    }
    img.bd-placeholder-img{
      height: 300px !important;
    }
  }
</style>
<body>
  <!-- <img src="assets/images/grey-background.jpg" alt='background' class="background img-fluid"> -->
    <div class="heading"></div>
    <nav class="navbar fixed-top navbar-expand-lg navbar-light">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="assets/images/em_logo2.png" alt="" class="img-fluid" style="width:40px; height:40px;">
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="courses.php">Courses</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link" href="blog.php">Blog</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="about.php" tabindex="-1" aria-disabled="true">About Us  </a>
              </li>

            </ul>
            <a href="<?php if(isset($_SESSION['loggedin'])) echo 'logout.php' ;else echo 'login.php?location='.urlencode($_SERVER['REQUEST_URI']); ?>">
              <button class="btn btn-primary navbar-btn login-btn"><?php if(isset($_SESSION['loggedin'])) echo "Sign out"; else echo "Login"; ?></button>
            </a>
          </div>
        </div>
      </nav>



<div class="container carousel-container">
  
  <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img class="bd-placeholder-img w-100 img-fluid" src="assets\images\fabio-oyXis2kALVg-unsplash.jpg" style="height:600px;"> 
      <div class="container">
        <div class="carousel-caption text-start w-50" style="font-size: 25px;">
          <h1 >Empowered Blockchain Hub.</h1>
          <p><a class="btn btn-lg btn-primary rounded" href="signup.php">Sign up</a></p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img class="bd-placeholder-img w-100 img-fluid" src="assets\images\tezos-Dd9Wkk5vj80-unsplash.jpg"  style="height:600px;"> 
      <div class="container">
        <div class="carousel-caption">
          <h1>Get access to wonderful courses.</h1>
          <p><a class="btn btn-lg btn-primary" href="#">Learn more</a></p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <img class="bd-placeholder-img w-100 img-fluid" src="assets\images\shubham-dhage-geJHvrH-CgA-unsplash.jpg" style="height:600px;"> 

      <div class="container">
        <div class="carousel-caption text-end">
          <h1>Learn about Blockchain and Cryptocurrency.</h1>
          <p><a class="btn btn-lg btn-primary" href="#">Browse gallery</a></p>
        </div>
      </div>
    </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</div>


      <section class='image-cards-area'>
        <h1 class="heading-0 text-center text-dark ">
          Featured courses
        </h1>
        <div class="container">
          <div class='row justify-content-center'>
          <?php for($i = 0; $i < 4; $i++): ?>
            
            <div class="card shadow">
                <a href="course_info.php?p=<?= $pcrypt->encrypt($courses[$i]['CODE'],$_SESSION['key']) ?>"><img src="videos/<?= $courses[$i]['CODE'].'/'.$courses[$i]['THUMBNAIL']?>" class="card-img" alt="..."></a>
                <div class="card-body">
                    <h5 class="card-title"><?= $courses[$i]['TITLE'] ?></h5>
                    <p class="card-text">
                        <?= substr($courses[$i]['DESCRIPTION'],0,42)?>
                        <span>...</span>
                    </p>
                    <div class="price btn">$<?= $courses[$i]['PRICE'] ?></div>
                    <a href="course_info.php?p=<?= $pcrypt->encrypt($courses[$i]['CODE'],$_SESSION['key']) ?>" class="btn btn-primary">info</a>
                </div>
            </div>
        <?php endfor ?>
        </div>

        </div> 
      </section>

      <section class="something-area">
      
      </section>
      <section class="contact-section">
        <div class="container">
          <div class="row">
            <h2>Contact Us</h2>
            <form>
              <div class="mb-3">
                <input type="text" Placeholder="Name" id='contact-name' name="contact-name" class="form-control">
              </div>
              <div class="mb-3">
                <input type="email" Placeholder="Email" id='contact-email' name="contact-email" class="form-control">
              </div>
              <div class="mb-3">
                <input type="subject" Placeholder="Subject" id='contact-subject' name="contact-subject" class="form-control">
              </div>

              <div class="mb-3">
                <textarea type="text" Placeholder="Message" id='contact-message' rows='7' name="contact-message" class="form-control"></textarea>
              </div>   
              <button type="submit" class="btn btn-primary">Send</button>

            </form>
          </div>
        </div>
      </section>
      <footer>
        <div class="footer-text">Empowered Blockchain Hub &copy; <?= date('Y') ?></div>
      </footer>
      <script src='assets/bootstrap-5.0.2-dist/js/bootstrap.min.js'></script>
      <script src="assets/fontawesome-free-6.0.0-beta3-web/js/all.js"></script>
      <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script> -->

</body>
</html>