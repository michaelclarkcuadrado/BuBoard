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

/*
 * Takes a subscribeToID and no other arguments to subscribe to that account, or also takes an optional action=unsubscibe to unsubscribe from the first argument
 * */
if(isset($_GET['subscribeToID']) && $_GET['subscribeToID'] !== $ownID){
    $subscribeTo = intval(mysqli_real_escape_string($mysqli, $_GET['subscribeToID']));

    if(isset($_GET['action']) && $_GET['action'] === 'unsubscribe'){
        //unsubscribe account
        mysqli_query($mysqli, "
            DELETE FROM profile_follows WHERE follower_id = '$ownID' AND followee_id = '$subscribeTo'
        ");
    } else {
        //subscribe account
            mysqli_query($mysqli, "
              INSERT INTO profile_follows (follower_id, followee_id) VALUES ('$ownID', '$subscribeTo');  
            ");
            $shouldSendMessage = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT follower_texts_enabled FROM buboard_profiles WHERE profile_id = '$subscribeTo'"))['follower_texts_enabled'];
            if($shouldSendMessage > 0){
                sendTextMessage($mysqli, $subscribeTo, false,$userinfo['real_name'] . ' just subscribed to you on BuBoard!');
            }
    }
} else {APIFail();}