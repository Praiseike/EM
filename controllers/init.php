<?php
    if(isset($_POST["email"],$_POST["amount"]))
    {
        $curl = curl_init();
        $email = filter_var($_POST["email"],FILTER_VALIDATE_EMAIL);
        $amount = filter_var($_POST["amount"],FILTER_VALIDATE_INT);
        $callback_url = "localhost/paystack/callback.php";
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
    }
    else{
        die("please enter the complete details");
    }
    header('Location: ' . $tranx['data']['authorization_url']);
?>