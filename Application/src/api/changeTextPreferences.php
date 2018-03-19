<?php
/**
 *
 * FileName: changeTextPreferences.php
 * User: Michael Clark-Cuadrado
 * Date: 3/19/18
 * Time: 6:18 AM
 */
require_once '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);
$userID = $userinfo['profile_id'];

if($_GET['setProperty'] == 'unread_texts_enabled'){
    $val = $_GET['val'] == 1 ? 1 : 0;
    mysqli_query($mysqli, "UPDATE buboard_profiles SET unread_texts_enabled = $val WHERE profile_id = $userID");
}
elseif($_GET['setProperty'] == 'follower_texts_enabled'){
    $val = $_GET['val'] == 1 ? 1 : 0;
    mysqli_query($mysqli, "UPDATE buboard_profiles SET follower_texts_enabled = $val WHERE profile_id = $userID");
}