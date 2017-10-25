<?php
require '../config.php';

$email = mysqli_real_escape_string($_GET['email']);
$confirmcode = $_GET['confirmcode'];

$result = mysqli_query($mysqli, "
SELECT *
FROM buboard_profiles
WHERE email_address='$email';
");

$row = mysqli_fetch_assoc($result);
$db_code = $row['email_confirmation_secret'];



if ($confirmcode === $db_code){
    $result2 = mysqli_query($mysqli, "
    UPDATE buboard_profiles
    SET email_is_confirmed='1'
    WHERE email_address='$email';
    ");

    echo "Email Confirmed: Feel free to log on to BuBoard";


}
else{
    echo "Invalid email code";
}

?>