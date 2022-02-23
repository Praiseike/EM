<?php
    session_start();

    if(isset($_POST['email'],$_POST['first-name'],$_POST['last-name'],$_POST['password']))
    {
        $database_host = 'localhost';
        $database_user = 'root';
        $database_pass = '';
        $database_name = 'accounts';

        $username = $_POST['first-name'].' '.$_POST['last-name'];
        $username = strip_tags($username);
        $username = stripslashes($username);
        // echo $username;

        $email = strtolower($_POST['email']);

        $con = new mysqli($database_host,$database_user,$database_pass,$database_name);
        if($con->connect_errnfo)
        {
            exit('<h2>failed to connect to database</h2><br><h3>please contact your systems administrator</h3>');
        }
        try{
            $stmt = $con->prepare("SELECT * FROM users WHERE EMAIL = ?");

            $stmt->bind_param('s',$email);

            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows > 0)
            {
                $_SESSION['error-msg'] = 'user already exist';
                header('Location: signup.php');
            }
            else{

                // sanitize the username
                $username = htmlspecialchars($username);
                $username = htmlentities($username);

                $stmt = $con->prepare("INSERT INTO users(USERNAME,EMAIL,PASSWORD) VALUES( ?, ?, ?)");
                $stmt->bind_param('sss',$username,$email,password_hash($_POST['password'],PASSWORD_DEFAULT));
                $stmt->execute();
                header('Location: login.php');
            }
        }catch(Exception $e)
        {
            $con->rollback();
            throw $e;
        }
        
        $stmt->close();

    }
?>