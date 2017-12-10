<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 12/5/17
 * Time: 6:46 PM
 */
require_once '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

$userSubscribedTo = mysqli_query($mysqli, "SELECT
  profile_id,
  real_name,
  isVerifiedAccount,
  has_submitted_photo
FROM buboard_profiles
  JOIN profile_follows follow ON buboard_profiles.profile_id = follow.followee_id
WHERE follower_id = '".$userinfo['profile_id']."'");
$output = array();
while($user = mysqli_fetch_assoc($userSubscribedTo)){
    $output[$user['profile_id']] = $user;
}
echo json_encode($output);