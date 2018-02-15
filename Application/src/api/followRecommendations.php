<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 2/12/18
 * Time: 3:15 AM
 */
require_once '../config.php';
$userdata = buboard_authenticate($mysqli, $authenticationKey);
$id = $userdata['profile_id'];
$recommendations = array();
$recs_result = mysqli_query($mysqli, "
SELECT
  profile_id,
  real_name,
  profile_desc,
  isVerifiedAccount,
  has_submitted_photo,
  photo_filename_extension,
  COUNT(follower_id) AS followers,
  0 as isSubscribed
FROM
  buboard_profiles
  LEFT JOIN profile_follows follow ON buboard_profiles.profile_id = follow.followee_id
WHERE (follower_id IS NULL) AND profile_id != $id AND email_is_confirmed >= 1
GROUP BY profile_id
ORDER BY followers DESC, RAND()
LIMIT 6
");
$recommendations = mysqli_fetch_all($recs_result, MYSQLI_ASSOC);

echo json_encode($recommendations);