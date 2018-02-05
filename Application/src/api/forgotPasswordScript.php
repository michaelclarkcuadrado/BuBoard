<?php
/**
 * Created by PhpStorm.
 * User: Zachary Miller
 * Date: 11/24/2017
 * Time: 4:02 PM
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

require '../config.php';

$email = mysqli_real_escape_string($mysqli, $_POST['email']);
$password1 = mysqli_real_escape_string($mysqli, $_POST['password1']);
$password2 = mysqli_real_escape_string($mysqli, $_POST['password2']);


if ($password1 !== $password2) {
    header("location: ../forgotPassword.php");
}


$result = mysqli_query($mysqli, "
    SELECT email_confirmation_secret
    FROM buboard_profiles
    WHERE email_address = '$email';
    ");


$row = mysqli_fetch_assoc($result);

$confirmcode = $row['email_confirmation_secret'];

$confirmLink = "http://" . getenv('HOSTNAME') . "/api/changePassword.php?email=$email&confirmcode=$confirmcode&password=$password1";


$message =
    "   
    <html>
    Please click this link to verify the information in your password change
    
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
    $mail->Subject = "Buboard password reset";
    $mail->Body = $message;
    $mail->send();
} catch (Exception $e) {
    error_log('Message could not be sent.');
}


?>


<script>window.location = "/index.php?message=An email with password reset instructions has been sent"</script>
