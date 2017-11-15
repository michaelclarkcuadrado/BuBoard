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

// create a random confirm code string
$confirmcode = rand();

// Data check

$check = true;

if ($firstname == "" && $lastname==""){
    $check = false;
}

if ($firstname == ""){
    $check = false;
}

if ($lastname == ""){
    $check = false;
}

if ($email == ""){
    $check = false;
}

if($email.indexOf("@") == -1){
    $check = false;
}

if ($email.indexOf("@gettysburg.edu") == -1){
    $check = false;
}

if ($password1 == "" || $password2 == ""){
    $check = false;
}

if ($password1 != $password2){
    $check = false;
}


if (!$check){
    header("location: ../signup.php");
}

if($password1 === $password2){
    $hash = password_hash($password1, PASSWORD_DEFAULT);
} else die();

$posts_queryresult = mysqli_query($mysqli, "
      INSERT INTO `buboard_profiles` (`real_name`, `date_signup`, `password_hash`, `email_confirmation_secret`, `email_address`, `email_is_confirmed`, `profile_desc`, `has_submitted_photo`)
      VALUES ('$firstname $lastname', NOW(), '$hash', '$confirmcode', '$email', 0, '$description', 0);
    ");

$profile_id = mysqli_insert_id($mysqli);

if (!empty($_FILES) && isset($_FILES['fileToUpload'])) {
    switch ($_FILES['fileToUpload']["error"]) {
        case UPLOAD_ERR_OK:
            $target = "../usercontent/user_avatars/";
            $target = $target . basename($_FILES['fileToUpload']['name']);


            $uploadOk = 1;

            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            if (pathinfo($target, PATHINFO_EXTENSION) != "jpg") {
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                $isUploaded = move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);

                if ($isUploaded) {
                    $status = "The file " . basename($_FILES['fileToUpload']['name']) . " has been uploaded";

                } else {
                    $status = "Sorry, there was a problem uploading your file.";
                }

                rename("$target", "../usercontent/user_avatars/$profile_id.jpg");
            }
    }
}


//The massage below should only work for a local machines link, as we dont have an actual web address ye
$confirmLink = "http://" . getenv('HOSTNAME') . "/api/emailConfirm.php?email=$email&confirmcode=$confirmcode";
$message =
    "   
    <html>
    Follow the link to verify your new buboard account:
    
    <a href='$confirmLink'>$confirmLink</a>
    </html>
    ";


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = getenv('smtpHost');  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = getenv('smtpUser');                 // SMTP username
    $mail->Password = getenv('smtpPassword');                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = getenv('smtpPort');                                    // TCP port to connect to
    //Recipients
    $mail->setFrom(getenv('smtpUser'), 'BuBoard');
    $mail->addAddress($email, 'Buboard User');     // Add a recipient
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = ucfirst($firstname) . ", welcome to Buboard!";
    $mail->Body = $message;
    $mail->send();
} catch (Exception $e) {
    error_log('Message could not be sent.');
}

?>

<script>window.location = "/index.php?message=Confirmation Email has been sent."</script>




