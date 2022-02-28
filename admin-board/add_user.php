<?php
    session_start();
    if(!isset($_SESSION['admin-loggedin'])){
        header("Location: login");
    }
    if(isset($_POST['email'],$_POST['first-name'],$_POST['last-name'],$_POST['password']))
    {

        include 'database/db.php';

        $username = $_POST['first-name'].' '.$_POST['last-name'];
        $username = strip_tags($username);
        $username = stripslashes($username);
        // echo $username;

        $email = strtolower($_POST['email']);
    
        try{
            $stmt = $con->prepare("SELECT * FROM admins WHERE EMAIL = ?");

            $stmt->bind_param('s',$email);

            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows > 0)
            {
                $_SESSION['error-msg'] = 'user already exist';
                header('Location: register');
            }
                // sanitize the username
            $username = htmlspecialchars($username);
            $username = htmlentities($username);


            $password = $_POST['password'];
            if(strlen($password) < 8){
                $_SESSION['error-msg'] = "Password must be upto 8 characters";
                header("Location: register");
                exit();
            }else{
                $stmt = $con->prepare("INSERT INTO admins(USERNAME,PASSWORD,EMAIL) VALUES( ?, ?, ?)");
                $stmt->bind_param('sss',$username,password_hash($password,PASSWORD_DEFAULT),$email);
                $stmt->execute();
                header('Location: login');
                exit();    
            }
            
        }catch(Exception $e)
        {
            $con->rollback();
            throw $e;
        }
        
        $stmt->close();

    }
?>