<?php
    session_start();

    require_once 'sendEmails.php';


    $redirect = isset($_POST['location'])? htmlspecialchars($_POST['location']): NULL;

    
    $database_host = 'localhost';
    $database_user = 'root';
    $database_pass = '';
    $database_name = 'em-db';

    $con = new mysqli($database_host,$database_user,$database_pass,$database_name);

    if($con->connect_error)
    {
        exit('<h2>failed to connect to database</h2><br><h3>please contact your systems administrator</h3>');
    }

    if(isset($_POST['login-btn']))
    {

        try{
        
            $email = $_POST['email'];
            $stmt = $con->prepare("SELECT ID, USERNAME, PASSWORD FROM users WHERE EMAIL = ?");
            $stmt->bind_param('s',$email);
            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows > 0)
            {
                $stmt->bind_result($id,$username,$password);

                $stmt->fetch();

                if(password_verify($_POST['password'],$password)){
                    // user logged in 
                    session_regenerate_id();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['name'] = $username;
                    $_SESSION['email'] = $email;
                    $_SESSION['id'] = $id;
                    if($redirect != NULL)
                    {
                        header('location: '.$redirect);
                    }else{
                        header('location: index.php');  
                    }
                }
                else{
                    $_SESSION['error-msg'] = 'invalid login details';
                    header("Location: ./login.php?location=".$redirect);
                }

            }
            else{
                $_SESSION['error-msg'] = 'User does not exist';
                header("Location: ./login.php?location=".$redirect);            
            }
        }catch(Exception $e)
        {
            $con->rollback();
            throw $e;
        }
        
        $stmt->close();

    }



    if(isset($_POST['signup-btn']))
    {

        $username = $_POST['first-name'].' '.$_POST['last-name'];
        $username = strip_tags($username);
        $username = stripslashes($username);
        // echo $username;

        $email = strtolower($_POST['email']);

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


                $token = bin2hex(random_bytes(50));
                $username = htmlspecialchars($username);
                $username = htmlentities($username);
                $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                $stmt = $con->prepare("INSERT INTO users(USERNAME,EMAIL,PASSWORD,TOKEN) VALUES(?, ?, ?, ?)");
                $stmt->bind_param('ssss',$username,$email,$password,$token);
                $stmt->execute();

                sendVerificationEmail($email,$token);

                $_SESSION['loggedin'] = true;
                $_SESSION['name'] = $username;
                $_SESSION['email'] = $email;
                $_SESSION['id'] = $id;
                $_SESSION['verified'] = false;
                header('Location: index.php');

            }
        }catch(Exception $e)
        {
            $con->rollback();
            throw $e;
        }
        
        $stmt->close();
    }

    $con->close();

?>