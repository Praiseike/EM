<?php
include 'vendor/autoload.php';

define('SENDER_EMAIL','praiseike123@gmail.com');
define('SENDER_PASSWORD','pa33word');

// CREATING TRANSPORT
$transport = (new Swift_SmtpTransport('smtp.gmail.com',465,'ssl'))
    ->setUsername(SENDER_EMAIL)
    ->setPassword(SENDER_PASSWORD);

// CREATING MAILER USING TRANSPORT
$mailer = new Swift_Mailer($transport);

function sendVerificationEmail($userEmail,$token){
    global $mailer;
    $body = "<!DOCTYPE html>
        <html lang='en'>
        <head>

            <meta charset='UTF-8'>
            <title>Test mail</title>
            <style>
                .wraper{
                    padding: 20px;
                    color: #444;
                    font-size; 1.3em;
                }
                a {
                    background: #592f80;
                    text-decoration: none;
                    padding: 8px 15px;
                    border-radius: 5px;
                    color: #fff;
                }
            </style>
            </head>
            <body>
                <div class='wrapper'>
                    <p> Thank you for signing up on our site.</p>
                    <a href='https://localhost/cwa/verify-user/verify_email.php?token='".$token."'>Verify Email!</a>
                </div>
            </body>
            </html>";

    // creating message
    $message = (new Swift_Message('Verify your email'))
        ->setFrom(SENDER_EMAIL)
        ->setTo($userEmail)
        ->setBody($body,'text/html');

    // send the message
    try{
        $result = $mailer->send($message);
    
        // if($result > 0){
        //     return true;    
        // }
        // return false;
    }catch(Exception $e){
        echo "<div class='alert alert-danger'>".$e->getMessage()."</div>";
    }

}
?>