<?php
    session_start();
    $redirect = NULL;
    if($_POST['location'] != '')
    {
        $redirect = htmlspecialchars($_POST['location']);
    }

    if(isset($_POST['email'],$_POST['password']))
    {
        $database_host = 'localhost';
        $database_user = 'root';
        $database_pass = '';
        $database_name = 'accounts';

        $con = new mysqli($database_host,$database_user,$database_pass,$database_name);
        if($con->connect_error)
        {
            exit('<h2>failed to connect to database</h2><br><h3>please contact your systems administrator</h3>');
        }

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
?>