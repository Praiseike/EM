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

    $con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
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


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <link rel="stylesheet" href="../../maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <script src='assets/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js'></script>
<script src="assets/fontawesome-free-6.0.0-beta3-web/js/all.js"></script>
<script src="assets/jquery.min.js"></script>


</head>
<body>

<div class="container">
  <h2>Filterable List</h2>
  <p>Type something in the input field to search the list for specific items:</p>  
  <input class="form-control" id="myInput" type="text" placeholder="Search..">
  <br>
  <ul class="list-group" id="myList">
    <li class="list-group-item">first item</li>
    <li class="list-group-item">Second item</li>
    <li class="list-group-item">Third item</li>
    <li class="list-group-item">Fourth</li>
  </ul>  
</div>

<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>

     

</body>

<!-- Mirrored from www.w3schools.com/bootstrap/tryit.asp?filename=trybs_filters_list&stacked=h by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 30 Jul 2018 01:53:25 GMT -->
</html>


      <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script> -->

</body>
</html>