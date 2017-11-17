<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 11/17/17
 * Time: 2:14 PM
 */
require_once '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);
$ownID = $userinfo['profile_id'];

if(isset($_GET['subscribeToID'])){
    $subscribeTo = intval(mysqli_real_escape_string($mysqli, $_GET['subscribeToID']));
    mysqli_query($mysqli, "
    INSERT INTO profile_follows (follower_id, followee_id) VALUES ('$ownID', '$subscribeTo');  
    ");
}