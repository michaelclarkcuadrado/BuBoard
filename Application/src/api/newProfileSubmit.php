<?php
require '../config.php';

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
$description = $_POST['description'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

if ($password1 === $password2) {
    $posts_queryresult = mysqli_query($mysqli, "
      INSERT INTO `buboard_profiles` (`real_name`, `date_signup`, `password_hash`, `email_confirmation_secret`, `email_address`, `email_is_confirmed`, `profile_desc`, `has_submitted_photo`)
      VALUES ('$firstname $lastname', NOW(), '$password1', 'fsadfasdf', '$email', 0, '$description', 0);
    ");
} else {
    die(); //todo
}


?>

<meta http-equiv="refresh" content="0;URL=../feed.php"/>
