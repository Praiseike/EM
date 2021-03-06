<?php session_start(); ?>
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
    <link href="./css/about.css" rel="stylesheet">

</head>

<body>

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
                <a class="nav-link" href="courses.php">Courses</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"href="blog.php">Blog</a>
              </li>
              <li class="nav-item">
                <a class="nav-link active" href="about.php" tabindex="-1" aria-disabled="true">About Us  </a>
              </li>

              <a href="<?php if(isset($_SESSION['loggedin'])) echo 'logout.php' ;else echo 'login.php?location='.urlencode($_SERVER['REQUEST_URI']); ?>">
                <button class="btn btn-primary navbar-btn login-btn"><?php if(isset($_SESSION['loggedin'])) echo "Sign out"; else echo "Login"; ?></button>
              </a>
            </ul>
          </div>
        </div>
      </nav>
  <section class="container">
    
    <div class="heading">
      <div class="img">
        <img src="assets/images/em_logo2.png" alt="" class="img-fluid" style="width:200px; height:200px;">
      </div>
      <div class="about-head">
        <div class="h1">Empowered</div>
        <div class="h1">Blockchain Hub</div>
      </div>
    </div>
    
    <div class='about-box'>
      <hr>
      <h2 class="text-center text-dark">OUR VISION</h2>
      <hr>
  
      <p class="text">
          We are geared towards raising talented blockchain developers as well as Blockchain/Cryptocurrency 
          enthusiast who will become relevant in the blockchain industry in providing solutions to every African
          and the world at large.
      </p>    
    </div>
    
  
    <div class='about-box'>
      <hr>  
      <h2 class="text-center text-dark">OUR MISSION</h2>
      <hr>
        <p class="text">
          Providing Blockchain solutions and bringing Blockchain/cryptocurrency education to all Africans and the world at large
        </p>    
    </div>
  <div class="row founders-note">
  <h2>    THE NEW NORMAL: BLOCKCHAIN AND CRYPTOCURRENCY</h2>
      <p>

      ???Cryptocurrency will do to bankers what E-mail did to post office workers???
      Unyime Akpan
      (Founder, Empowered Blockchain Hub)

      In the light of a decentralized way of carrying out transactions, the crypto and blockchain space has been gaining large grounds as well as its users. In fact, several companies have adopted the use of blockchain in carrying out their services. This is because blockchain gives its users a new paradigm of doing business and the opportunity for them to be in charge of their money. Millions stream to several websites daily and platforms in order to gain an education and understanding of the space for effective participation. 
      In order to meet this need, Empowered Blockchain Hub was founded in the midyear of 2021 by Unyime Akpan and a group of young tech enthusiasts. Empowered Blockchain Hub seeks to empower people through the acquisition of the knowledge of blockchain technology and cryptocurrency in every possible way. The hub offers services in blockchain and cryptocurrency education and consultancy, GameFi, NFTs, Metaverse, crypto analysis and trading, airdrops, as well as how to code and develop on blockchain both virtually and on site. This is why it is said about Empowered Blockchain that, ???We bring the knowledge of blockchain to your doorstep???. We also offer services like, Peer-to-Peer Trading.
      With a hand-on-deck team of young professionals, be ready to broaden your horizon on the several opportunities and possibilities of blockchain and cryptocurrency and in fact, surf the shores of this goldmine. At Empowered Blockchain Hub we say, ???The possibilities are endless???. So, let???s Moon Up!

      Connect with us on LinkedIn @linkedin.com/in/empowered-blockchain-cryptocurrency-hub-973080224, Facebook @ , Telegram
    </p>
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


<!-- 
<section class="section-0 something-area">

    </section>  
    
    <section class='section-1'>
      <div class="container-fluid p-5 g-5">
        <div class="row align-items-center">
          <div class="col col-sm-5 about-text">
            <h2 class="text-center text-dark">OUR MISSION</h2>
            <p class="text-dark">
            </p>    
          </div>
          <div class="col col-sm-7 about-svg">
            <img src="assets/illustrations/mission.svg">
          </div>
        </div>
      </div>
    </section> -->
