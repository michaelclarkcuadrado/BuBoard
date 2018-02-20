<?php
/**
 * Created by PhpStorm.
 * User: Zachary Miller
 * Date: 11/24/2017
 * Time: 5:31 PM
 */

require '../config.php';
$email = mysqli_real_escape_string($mysqli, $_GET['email']);
$confirm_code = mysqli_real_escape_string($mysqli, $_GET['confirmcode']);
$password = password_hash($_GET['password'], PASSWORD_DEFAULT);

$result = mysqli_query($mysqli, "
      SELECT email_confirmation_secret 
      FROM buboard_profiles 
      WHERE email_address = '$email';
       ");

$row = mysqli_fetch_assoc($result);
$secret = $row['email_confirmation_secret'];

if ($secret != $confirm_code){
    header("location: ../signup.php");
}

// Now we know the information is validated and we can proceed

$result = mysqli_query($mysqli, "
      UPDATE buboard_profiles
      SET password_hash = '$password',
      email_is_confirmed = 1
      WHERE email_address = '$email';
       ");

?>

<script>window.location = "/index.php?message=Password has been changed"</script>
