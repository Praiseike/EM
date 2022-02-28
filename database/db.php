<?php
    
    
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = "em-db";

    $con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
    if($con->connect_error)
    {
        die('unable to connect to database '.$dbname);
    }


?>