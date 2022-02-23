<?php
    session_start();
    
    include 'pcrypt.php';

    if(!isset($_SESSION['key']))
    {
      $_SESSION['key'] = $pcrypt->gen_random_key();
      header("Location: ./index.php");
    }

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = "courses";

    $con = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
    if($con->connect_error)
    {
        die('unable to connect to database '.$dbname);
    }

    if(isset($_GET['p']))
    {
      if($_GET['p'] == '')
      {
        $_SESSION['url'] = substr($_SERVER['REQUEST_URI'],0,strlen($_SERVER['REQUEST_URI']) - 4);
        echo $_SESSION['url'];
        header("Location: 404.php"); 
      }

      $id = $_GET['p'];
      $id = $pcrypt->decrypt($id,$_SESSION['key']);

      $id = strip_tags($id);
      $id = htmlspecialchars($id);
    
        $stmt = $con->prepare("SELECT TITLE,DESCRIPTION,THUMBNAIL,PRICE FROM courses WHERE CODE = ?");
        if($stmt)
        {
            $stmt->bind_param('s',$id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($title,$description,$thumbnail,$price);
            $code = $id;
            $stmt->fetch(); 

        }
        else{
          header("Location: ./courses.php");
        }
        $stmt->close(); 
    }

    $con->close();


    if(!isset($_SESSION['loggedin'])){
        include 'denied.php';
    }else{

        $curl = curl_init();
        $email = filter_var($_SESSION['email'],FILTER_VALIDATE_EMAIL);
        $amount = filter_var($price,FILTER_VALIDATE_INT);
        $callback_url = "localhost/em/callback.php";
        curl_setopt_array($curl,array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => json_encode([
                'email' => $email,
                'amount' => $amount * 100, // we are making transactions in kobo
                'callback_url'=> $callback_url
            ]),

            CURLOPT_HTTPHEADER => [
                "authorization: Bearer sk_test_14cfe2a1c50b5254963d409b9dd57db895cc4eb6",
                "content-type: application/json",
                "cache-control: no-cache"
            ],
        ));


        $response = curl_exec($curl);
        $err = curl_error($curl);

        if($err)
        {
            die("curl returned an error: ".$err);
        }

        $tranx = json_decode($response,true);
        if(!$tranx["status"]){
            print_r("API returned error: ".$tranx["message"]);
        }
        header('Location: ' . $tranx['data']['authorization_url']);

    }

?>

