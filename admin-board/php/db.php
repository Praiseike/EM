<?php 
  $database_host = 'localhost';
  $database_user = 'root';
  $database_pass = '';
  $database_name = 'courses';

  $con = new mysqli($database_host,$database_user,$database_pass,$database_name);
  
  if($con->connect_error)
  {
    die('<h2>failed to connect to database</h2><br><h3>please contact your systems administrator</h3>');
  }

?>