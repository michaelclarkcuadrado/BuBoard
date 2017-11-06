<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

require '../config.php';

$firstname = mysqli_real_escape_string($mysqli, $_POST['firstname']);
$lastname = mysqli_real_escape_string($mysqli, $_POST['lastname']);
$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$description = mysqli_real_escape_string($mysqli, $_POST['description']);
$password1 = mysqli_real_escape_string($mysqli, $_POST['password1']);
$password2 = mysqli_real_escape_string($mysqli, $_POST['password2']);




if ($password1 === $password2) {


    // create a random confirm code string
    $confirmcode = rand();


    $posts_queryresult = mysqli_query($mysqli, "
      INSERT INTO `buboard_profiles` (`real_name`, `date_signup`, `password_hash`, `email_confirmation_secret`, `email_address`, `email_is_confirmed`, `profile_desc`, `has_submitted_photo`)
      VALUES ('$firstname $lastname', NOW(), '$password1', '$confirmcode', '$email', 0, '$description', 0);
    ");







    //The massage below should only work for a local machines link, as we dont have an actual web address yet
    $message =
    "    
    Confirm Your Email
    Click the Link below to verify your account
    http://".getenv('HOSTNAME')."/api/emailConfirm.php?email=$email&confirmcode=$confirmcode
    ";



    $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = getenv('smtpHost');  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = getenv('smtpUser');                 // SMTP username
        $mail->Password = getenv('smtpPassword');                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = getenv('smtpPort');                                    // TCP port to connect to
        //Recipients
        $mail->setFrom('from@example.com', 'BuBoard');
        $mail->addAddress($email, 'Buboard User');     // Add a recipient
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Email Confirmation for Buboard';
        $mail->Body    = $message;

        echo "Hello";
        $mail->send();
        echo "World";
        echo 'Confirmation Email has been sent. Please confirm the email and then log onto Buboard';
    } catch (Exception $e) {
        error_log('Message could not be sent.');
        //echo 'Mailer Error: ' . $mail->ErrorInfo;
    }









} else {

}




?>

<html>
<script type="text/javascript">

    document.body.innerHTML = '';

</script>
<head>
    <title>Welcome To BuBoard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../static/css/material.min.css"/>
    <link rel="stylesheet" type="text/css" href="../static/css/signup.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>

    .mdl-grid.center-items {
        width: 100%;
        height: 100%;
        overflow: auto;
    }

    .main{
        padding-top: 20px;
    }

    .mainbody{
        text-align:center;
        background-color: #80d8ff;
        height: 50%;
        width: 60%;
        align-items: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .title{
        text-align:center;
    }
    body {
        background-image: url('../static/image/corktile.jpg');
        background-attachment: local;
        padding-top: 20px;
    }

    .text{
        border-color: gray;
        border-style: solid;
        border-radius: 20px;
    }

    .wide{
        border-color: gray;
        border-style: solid;
        border-radius: 20px;
    }



    @media (max-width: 700px) {
        .mdl-grid.center-items {
            background-color: white;
            width: 100%;
            height: 100%;
            overflow: auto;
        }

        .mainbody{
            background-color: #80d8ff;
            height: 90%;
            width: 92%;
            align-items: center;
            padding-top: 15px;
            padding-bottom: 15px;
        }
    }


</style>

<main class="mdl--layout main">
    <form name="mainform"  method="post" onsubmit="return validateForm()" action="api/newProfileSubmit.php" enctype="multipart/form-data">
        <div class="mdl-grid mainbody mdl-shadow--8dp">
            <div class="mdl-grid center-items mdl-shadow--8dp mdl-color--grey-100">

                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <img class="thumbtack" src="../static/image/thumbtack.png">
                </div>
                <h2 class="mdl-card__title-text mdl-color-text--blue-grey-600 title">A email verification has been sent to the provided email. Once you have verified your email, please sign in</h2>

                <form>
                    <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone"></div>
                    <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                        <button class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white submit" type="button" onclick="window.location.href='http://192.168.99.100/'">
                            Log In
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </form>
</main>


</html>







