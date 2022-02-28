<?php
    session_start();
    
    include 'controllers/pcrypt.php';

    if(!isset($_SESSION['key']))
    {
      $_SESSION['key'] = $pcrypt->gen_random_key();
    }

    include 'database/db.php';
    
    $result = $con->query("SELECT * FROM courses");
    $courses = Array();
    $count = 0;
    $r = Array();

    if(isset($_GET['q'])){

      $query = htmlspecialchars($_GET['q']);
      $query = filter_var($query,FILTER_SANITIZE_STRING);

      if($result->num_rows > 0)
      {
          while($row = $result->fetch_assoc())
          {
              array_push($r,$row);     
              $count++;
          }
          foreach($r as $c){
            if(stristr(strtolower($c['TITLE']),strtolower($query)) != null){
              array_push($courses,$c);
            }
          }
          // $courses = array_reverse($courses);
      }
    }else{
      if($result->num_rows > 0)
      {
          while($row = $result->fetch_assoc())
          {
              array_push($courses,$row);     
              $count++;
          }
          $courses = array_reverse($courses);
      }
      else{
          $count = 0;
          $_SESSION['message'] = 'Create courses and view them here';
      }
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
    <link href="./css/courses.css" rel="stylesheet">

</head>

<body>
    <!-- <img src="assets/images/grey-background.jpg" alt='background' class="background img-fluid"> -->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light">
        <div class="container-fluid">
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
                <a class="nav-link active" href="#">Courses</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"href="blog.php">Blog</a>
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

    <section class="section-0">

      <div class="container form-container">
        <div class='row w-75'>
          <form method='get' action='courses.php' class="d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input name='q'class="form-control" type="text" placeholder="Search courses..." aria-label="Search courses..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-primary w-25" id="btnNavbarSearch" type="submit"><i class="fas fa-search"></i></button>
            </div>
          </form>      
        </div>
      </div>
    
      <?php if(count($courses) > 0) :?>
        <div class="flex-container">
          <?php foreach($courses as $course): ?>
              <div class="card shadow">
                  <a href="course_info.php?p=<?= $pcrypt->encrypt($course['CODE'],$_SESSION['key']) ?>"><img src="videos/<?= $course['CODE'].'/'.$course['THUMBNAIL']?>" class="card-img" alt="..."></a>
                  <div class="card-body">
                      <h5 class="card-title"><?= $course['TITLE'] ?></h5>
                      <p class="card-text">
                          <?= substr($course['DESCRIPTION'],0,42)?>...
                      </p>
                      <div class="price btn">$<?= $course['PRICE'] ?></div>
                      <a href="course_info.php?p=<?= $pcrypt->encrypt($course['CODE'],$_SESSION['key']) ?>" class="btn btn-primary">info</a>
                  </div>
              </div>
          <?php endforeach ?>
        </div>

        <?php else : ?>
            <div class="container p-5">
                <div class="row align-items-center justify-content-center">
                    <img style='width: 20rem; height: 20rem;' src="assets/illustrations/no-data.svg" class="img-fluid">
                    <div style="text-align: center;"><h3>No Result Found</h3></div>
                    <div style="text-align: center;"><a href="blog.php"><i style="font-size: 3rem;" class="fas fa-arrow-left"></i></a></div>
                </div>
            </div>
        <?php endif ?>
    </section>  
    
    <footer>
        <div class="footer-text">Empowered Blockchain Hub &copy; <?= date('Y') ?></div>
    </footer>
      <script src='assets/bootstrap-5.0.2-dist/js/bootstrap.min.js'></script>
      <script src="assets/fontawesome-free-6.0.0-beta3-web/js/all.js"></script>
      <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script> -->

</body>
</html>