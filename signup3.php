<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EM</title>
    <link href='./css/signup.css' rel='stylesheet'>
</head>
<body>
    <div class='container'>
        <div class='form-container'>
            <div class='login-title'>CREATE ACCOUNT</div>
            <form action='register.php' method='post'>
                <input id='username' type='username' name='username' placeholder='USERNAME' required>
                <input id='email' type='email' name='email' placeholder='EMAIL' required>
                <input id='password' type='password' name='password' placeholder='PASSWORD' required>
                <input id='confirm-password' type='password' name='confirm-password' placeholder='CONFIRM PASSWORD' required>      
                <button type='submit'>SIGNUP</button>
            </form>
        </div>
        <div class='signup-btn-container' style='margin-left: 0px;margin-right: 0px;'>
            <a href='login.php'><button class='signup-btn'>LOGIN</button></a>
        </div>
        <?php if(isset($_SESSION['error-msg'])): ?>
            <div style='color: red;' class='error-msg'>
                <?= $_SESSION['error-msg'] ?>
                <?php session_destroy()?>
            </div>
        <?php endif ?>
    </div>
</body>
</html>