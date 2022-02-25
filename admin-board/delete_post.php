<?php
    session_start();
    
    
    if(!isset($_SESSION['admin-loggedin']))
    {
        session_destroy();  
        header('Location: login');
    }
    else
    {
        if(isset($_GET['id']))
        {
            $id = $_GET['id'];
            // echo "Deleting course with id ".$id;
            
            $con = new mysqli("localhost","root","","posts");
            $stmt = $con->prepare("DELETE FROM posts WHERE CODE = ?");
            $stmt->bind_param("s",$id);
            $stmt->execute();
            $stmt->close();
            $con->close();
            header("Location: view_posts");
            
        }    
        
    }

?>
