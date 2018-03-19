<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 12/5/17
 * Time: 6:46 PM
 */
require_once '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);
$output = array('subscribers' => array(), 'subscribees' => array());

$userIsSubscribedTo = mysqli_query($mysqli, "SELECT
  profile_id,
  real_name,
  isVerifiedAccount,
  photo_filename_extension,
  has_submitted_photo
FROM buboard_profiles
  JOIN profile_follows follow ON buboard_profiles.profile_id = follow.followee_id
WHERE follower_id = '".$userinfo['profile_id']."'");
while($user = mysqli_fetch_assoc($userIsSubscribedTo)){
    $output['subscribees'][$user['profile_id']] = $user;
}

$userIsFollowedBy = mysqli_query($mysqli, "
    SELECT
  profile_id,
  real_name,
  isVerifiedAccount,
  photo_filename_extension,
  has_submitted_photo
FROM buboard_profiles
  JOIN profile_follows follow ON buboard_profiles.profile_id = follow.follower_id
WHERE followee_id = '".$userinfo['profile_id']."' AND email_is_confirmed > 0");
while($user = mysqli_fetch_assoc($userIsFollowedBy)){
    $output['subscribers'][$user['profile_id']] = $user;
}

echo json_encode($output);