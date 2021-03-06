<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

require '../config.php';

$firstname = mysqli_real_escape_string($mysqli, ucfirst($_POST['firstname']));
$lastname = mysqli_real_escape_string($mysqli, ucfirst($_POST['lastname']));
$email = mysqli_real_escape_string($mysqli, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
$description = mysqli_real_escape_string($mysqli, $_POST['description']);
$password1 = mysqli_real_escape_string($mysqli, $_POST['password1']);
$password2 = mysqli_real_escape_string($mysqli, $_POST['password2']);
$college = getenv('smtpCollege');

// checks for the kill method
$sql_check = false;
$pic_check = false;

// create a random confirm code string
$confirmcode = rand();

// Data check
$check = true;
$message = "";

if ($firstname == "" && $lastname == "") {
    $check = false;
    $message = "You must enter a first and last name";
} else if ($firstname == "") {
    $check = false;
    $message = "You must enter a first name";
} else if ($lastname == "") {
    $check = false;
    $message = "You must enter a last name";
} else if ($email == "") {
    $check = false;
    $message = "You must enter a valid email";
} else if (!strpos($email, $college)) {
    $check = false;
    $message = 'You must enter an ' . $college . ' email';
} else if ($password1 == "" || $password2 == "") {
    $check = false;
    $message = "You must have a password";
}

if ($password1 === $password2) {
    $hash = password_hash($password1, PASSWORD_DEFAULT);
} else {
    $check = false;
    $message = "Your passwords do not match";
}

if (!$check) {
    header("location: ../signup.php?message=$message");
} else { // Data is now validated
    $has_submitted_photo = 0;
    $image_extension = '.jpg';
    if (!empty($_FILES) && isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0) {
        $imagetype = exif_imagetype($_FILES['fileToUpload']['tmp_name']);
        if($imagetype !== false){
            $has_submitted_photo = 1;
            $image_extension = image_type_to_extension($imagetype);
        }
    }

    $posts_queryresult = mysqli_query($mysqli, "
      INSERT INTO `buboard_profiles` (`real_name`, `date_signup`, `password_hash`, `email_confirmation_secret`, `email_address`, `email_is_confirmed`, `profile_desc`, `has_submitted_photo`, `photo_filename_extension`)
      VALUES ('$firstname $lastname', NOW(), '$hash', '$confirmcode', '$email', 0, '$description', '$has_submitted_photo', '$image_extension');
    ");
    $profile_id = mysqli_insert_id($mysqli);

    if ($posts_queryresult) {
        $sql_check = true;
    } else {
        kill_signup($mysqli, $sql_check, $pic_check, $profile_id);
        header("location: ../signup.php?message=That account already exists.");
        die();
    }

    //auto-follow all verified accounts
    $list_verified_accts = mysqli_query($mysqli, "SELECT profile_id FROM buboard_profiles WHERE isVerifiedAccount > 0");
    $stmt = mysqli_prepare($mysqli, "INSERT INTO profile_follows (follower_id, followee_id) VALUES (?, ?)");
    while ($verified_acct = mysqli_fetch_assoc($list_verified_accts)) {
        mysqli_stmt_bind_param($stmt, 'ii', $profile_id, $verified_acct['profile_id']);
        mysqli_stmt_execute($stmt);
    }

    //this whole block needs a rewrite. Where do the errors even go?
    if ($has_submitted_photo) {
        if ($_FILES['fileToUpload']["error"] == UPLOAD_ERR_OK) {
            $target = "../usercontent/user_avatars/";
            $target = $target . $profile_id . $image_extension;

            $uploadOk = 1;

            if (file_exists('$target_file')) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                $isUploaded = move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);

                if ($isUploaded) {
                    $status = "The file " . basename($_FILES['fileToUpload']['name']) . " has been uploaded";
                    $pic_check = true;
                } else {
                    $status = "Sorry, there was a problem uploading your file.";
                    kill_signup($mysqli, $sql_check, $pic_check, $profile_id);
                    header("location: ../signup.php?message=$status");
                    die();
                }
            } else {
                kill_signup($mysqli, $sql_check, $pic_check, $profile_id);
                header("location: ../signup.php?message=$status");
                die();
            }
        } else {
            kill_signup($mysqli, $sql_check, $pic_check, $profile_id);
            die();
        }
    }


    $confirmLink = "https://" . getenv('HOSTNAME') . "/api/emailConfirm.php?email=$email&confirmcode=$confirmcode";
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
        kill_signup($mysqli, $sql_check, $pic_check, $profile_id);
        header("location: ../signup.php?message=An error was encountered when sending the email");
        die();
    }
}

function kill_signup($mysqli, $sql_check, $pic_check, $profile_id){
    $target = "/usercontent/user_avatars/";
    // if $sql_check = true: then the data was added to the database, but an error was encountered later
    // if $pic_check = true: then the picture was added to the database, but an error was encountered later
    // if both false: nothing need to be done, as no data was added before a failure

    // if $sql_check = true and $pic_check = false: we have to remove the addition to the profile list
        $posts_queryresult = mysqli_query($mysqli, "
            DELETE
            FROM buboard_profiles
            WHERE profile_id = '$profile_id';
        ");
        if($pic_check){
            unlink($target);
        }
}

?>


<script>window.location = "/index.php?message=Confirmation Email has been sent."</script>




