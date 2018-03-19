<?php
/**
 * stores a phone number and sends confirmation text
 * FileName: registerPhoneNumber.php
 * User: Michael Clark-Cuadrado
 * Date: 3/15/18
 * Time: 9:57 PM
 */
require_once '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);
$userID = $userinfo['profile_id'];
if(isset($_GET['unregister'])){
    mysqli_query($mysqli, "
        UPDATE buboard_profiles SET phone_number = 0, phone_confirmation_text_sent = 0, phone_number_is_confirmed = 0 WHERE profile_id = '$userID'
    ");
    die('success');
}
if(isset($_GET['areacode']) && isset($_GET['phonenum'])){
    $areacode = (int) $_GET['areacode'];
    $phonenum = (int) $_GET['phonenum'];
    if(strlen((string)$areacode) == 3 && strlen((string)$phonenum) == 7){
        $phonenum = $areacode . $phonenum;
        $confirmation_code = str_pad(rand(0, 999999), 6, 0, STR_PAD_LEFT);
        mysqli_query($mysqli, "UPDATE buboard_profiles SET phone_number = '$phonenum', phone_confirmation_secret = '$confirmation_code', phone_confirmation_text_sent = 1 WHERE profile_id = '$userID'");
        sendTextMessage($mysqli, $userID, true,"Your BuBoard confirmation code is: " . $confirmation_code);
        echo $phonenum;
    } else {
        APIFail("That phone number's length is not correct.");
    }
} else {
    APIFail("Did not specify required params.");
}