<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 2/15/18
 * Time: 12:13 AM
 */
require_once '../config.php';
$userdata = buboard_authenticate($mysqli, $authenticationKey);
$id = $userdata['profile_id'];
$queryString = "";
if(isset($_GET['q']) && $_GET['q'] !== ''){
    $queryString = mysqli_real_escape_string($mysqli, $_GET['q']);
} else {
    APIFail("Must send query string");
}
$query_result = mysqli_query($mysqli, "
SELECT
  profile_id,
  real_name,
  email_address,
  profile_desc,
  isVerifiedAccount,
  has_submitted_photo,
  photo_filename_extension,
  COUNT(follower_id) as followers,
  0 as isSubscribed
FROM
  buboard_profiles
  LEFT JOIN profile_follows ON buboard_profiles.profile_id = profile_follows.followee_id
WHERE (follower_id IS NULL) AND profile_id != $id AND email_is_confirmed >= 1 AND (real_name COLLATE UTF8_GENERAL_CI LIKE '%" . $queryString . "%' 
                                                          OR email_address LIKE '%" . $queryString . "%'
                                                          OR profile_desc COLLATE UTF8_GENERAL_CI LIKE '%" . $queryString . "%')
GROUP BY profile_id
ORDER BY RAND()
LIMIT 15
");
$search_results = mysqli_fetch_all($query_result, MYSQLI_ASSOC);

echo json_encode($search_results);