<?php
    session_start();
    if(isset($_POST['email'],$_POST['password']))
    {
        include 'php/db.php';

        try{

        
            $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
            $password = $_POST['password']; 


            $stmt = $con->prepare("SELECT ID, PASSWORD, USERNAME FROM admins WHERE EMAIL = ?");

            $stmt->bind_param('s',$email);

            $stmt->execute();
            $stmt->store_result();
            
            if($stmt->num_rows > 0)
            {
                $stmt->bind_result($id,$user_password,$username);
                $stmt->fetch();

                if(password_verify($password,$user_password)){
                    // user login was successful
                    session_regenerate_id();
                    $_SESSION['admin-loggedin'] = true;
                    $_SESSION['name'] = $username;
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