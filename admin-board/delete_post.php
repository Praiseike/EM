<?php
    session_start();
    
    function rrmdir($dir)
    {
        if(is_dir($dir))
        {
            $objects = scandir($dir);
            foreach($objects as $object)
            {
                if($object != "." && $object != "..")
                {
                    if(is_dir($dir."/".$object) && is_link($dir."/".$object))
                    {
                        rrmdir($dir."/".$object);
                    }
                    else{
                        unlink($dir."/".$object);
                    }
                }
            }
            rmdir($dir);
        }
    }

    
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
            include 'php/db.php';

            $stmt = $con->prepare("DELETE FROM posts WHERE CODE = ?");
            $stmt->bind_param("s",$id);
            $stmt->execute();
            $stmt->close();
            $con->close();
            $path = '../posts/'.$id;
            if(file_exists($path)){
                rrmdir($path);
            }
            header("Location: view_posts");
        }    
        
    }

?>
