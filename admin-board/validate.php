<?php
    session_start();
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

        
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $password = $_POST['password']; 

            $stmt = $con->prepare("SELECT ID, PASSWORD FROM admins WHERE EMAIL = ?");

            $stmt->bind_param('s',$email);

            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows > 0)
            {
                $stmt->bind_result($id,$user_password);
                $stmt->fetch();

                if(password_verify($password,$user_password)){
                    // user logged in 
                    session_regenerate_id();
                    $_SESSION['admin-loggedin'] = TRUE;
                    $_SESSION['name'] = $_POST['username'];
                    $_SESSION['id'] = $id;
                    header('location: ./index');
                }
                else{
                    $_SESSION['error-msg'] = 'invalid login details';
                    $stmt->close();
                    $con->close();
                    header("Location: login");
                }

            }
            else{
                $stmt->close();
                $con->close();
                $_SESSION['error-msg'] = 'Account does not exist';
                header("Location: ./login");
        }
        }catch(Exception $e)
        {
            $con->rollback();
            throw $e;
        }
        
        $stmt->close();
        $con->close();
    }
?>