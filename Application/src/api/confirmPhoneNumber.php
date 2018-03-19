<?php
/**
 *  verifies a confirmation secret over text
 * FileName: confirmPhoneNumber.php
 * User: Michael Clark-Cuadrado
 * Date: 3/15/18
 * Time: 10:00 PM
 */
require_once '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);
$userID = $userinfo['profile_id'];

if(isset($_GET['confirmCode'])){
    $confirmCode = $_GET['confirmCode'];
    $code = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT phone_confirmation_secret FROM buboard_profiles WHERE profile_id = $userID"))['phone_confirmation_secret'];
    if($confirmCode == $code){
        mysqli_query($mysqli, "
            UPDATE buboard_profiles SET phone_number_is_confirmed = 1,
            unread_texts_enabled = 1,
            follower_texts_enabled = 1 WHERE profile_id = $userID 
        ");

        echo json_encode(array('isConfirmed' => true));
    } else {
        echo json_encode(array('isConfirmed' => false));
    }
} else {
    APIFail("Required params not set.");
}