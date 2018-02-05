<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 1/29/18
 * Time: 9:38 PM
 */
require_once('../config.php');
$userinfo = buboard_authenticate($mysqli, $authenticationKey);
if(!isset($_GET['id'])){
    APIFail("No ID set.");
}
$profile_id = mysqli_real_escape_string($mysqli, $_GET['id']);
$curProfileData = mysqli_fetch_assoc(mysqli_query($mysqli, "
  SELECT
  profile_id,
  email_is_confirmed,
  real_name,
  isAdmin,
  isVerifiedAccount,
  has_submitted_photo,
  photo_filename_extension AS photo_filename_extension,
  profile_desc,
  email_address,
  (follower_id IS NOT NULL) as isSubscribed
FROM buboard_profiles
  LEFT JOIN profile_follows follow ON buboard_profiles.profile_id =follow.follower_id AND followee_id = " . $userinfo['profile_id'] . "
WHERE profile_id = $profile_id
"));
$curProfileData['isVerifiedAccount'] = ($curProfileData['isVerifiedAccount'] > 0 ? true : false);
$curProfileData['isAdmin'] = ($curProfileData['isAdmin'] > 0 ? true : false);
$curProfileData['isOwnProfile'] = ($curProfileData['isOwnProfile'] > 0 ? true : false);
$curProfileData['isSubscribed'] = ($curProfileData['isSubscribed'] > 0 ? true : false);
$curProfileData['isOwnProfile'] = ($curProfileData['profile_id'] === $userinfo['profile_id'] ? 1 : 0);
if($curProfileData['email_is_confirmed'] > 0){
    echo json_encode($curProfileData);
} else {
    APIFail("No such account.");
}
