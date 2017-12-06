<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 10/3/17
 * Time: 3:34 PM
 */

require '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);
$userID = $userinfo['profile_id'];

if(isset($_GET['curViewIsCategory'])) {
    $curViewIsCategory = intval(mysqli_real_escape_string($mysqli, $_GET['curViewIsCategory']));
} else {
    $curViewIsCategory = 0;
}
if(isset($_GET['curView'])) {
    $curView = intval(mysqli_real_escape_string($mysqli, $_GET['curView']));
} else {
    $curView = 0;
}
if(isset($_GET['latestPostCurView'])) {
    $latestPostCurView = intval(mysqli_real_escape_string($mysqli, $_GET['latestPostCurView']));
} else {
    $latestPostCurView = -1;
}

/*Build query based on params*/
$query = /** @lang MySQL */
    "SELECT
  post_id,
  profile_id,
  belongs_to_category,
  post_contents,
  post_title,
  UNIX_TIMESTAMP(post_date) AS seconds_since,
  real_name,
  has_submitted_photo,
  category_id,
  category_name,
  category_color,
  isVerifiedAccount,
  GROUP_CONCAT(DISTINCT attachment_id SEPARATOR ',') as attachment_id,
  IF(ISNULL(followee_id), FALSE, TRUE) as isSubscribed,
  IF(profile_id = $userID, TRUE, FALSE) as isOwnPost
FROM buboard_posts
  JOIN buboard_profiles ON buboard_posts.post_by_user_id = buboard_profiles.profile_id
  JOIN post_categories ON buboard_posts.belongs_to_category = post_categories.category_id
  LEFT JOIN post_attachments ON buboard_posts.post_id = post_attachments.belongs_to_post_id
  LEFT JOIN (SELECT followee_id, follower_id FROM profile_follows WHERE follower_id = '$userID') t1 ON post_by_user_id=followee_id
  ";

//no where clause here: 'latest' feed
$hasWhereStatement = false;
if ($curViewIsCategory == 0 && $curView == 1){
    //'following' feed
    $query .= " WHERE IF(ISNULL(followee_id), FALSE, TRUE) = TRUE";
    $hasWhereStatement = true;
} elseif ($curViewIsCategory) {
    //category view
    $query .= " WHERE category_id = $curView";
    $hasWhereStatement = true;
}

if ($latestPostCurView != -1) {
    $query .= ($hasWhereStatement ? ' AND' : ' WHERE') . " post_ID < $latestPostCurView";;
}

//note: changes in the LIMIT here should be reflected in the getPosts JS function also
$query .= " GROUP BY post_id ORDER BY post_id DESC LIMIT 10";

/*End build query*/

$posts_queryresult = mysqli_query($mysqli, $query);

//update number of unread posts to zero, since this person is online
mysqli_query($mysqli, "UPDATE buboard_profiles SET followers_posts_since_feed_pull = 0");

$formatted_posts = array();
while ($post = mysqli_fetch_assoc($posts_queryresult)) {
    //turn attachment ids from csv into array
    if ($post['attachment_id'] != null) {
        $post['attachment_id'] = explode(',', $post['attachment_id']);
        foreach( $post['attachment_id'] as &$attachment){
            $attachment = intval($attachment);
        }
    } else {
        $post['attachment_id'] = array();
    }

    $formatted_posts[$post['post_id']] = $post;
}

echo json_encode(array_values($formatted_posts));
