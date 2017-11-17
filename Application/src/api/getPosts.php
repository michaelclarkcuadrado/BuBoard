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
    $curViewIsCategory = mysqli_real_escape_string($mysqli, $_GET['curViewIsCategory']);
} else {
    $curViewIsCategory = 0;
}
if(isset($_GET['curView'])) {
    $curView = mysqli_real_escape_string($mysqli, $_GET['curView']);
} else {
    $curView = 0;
}
if(isset($_GET['latestPostCurView'])) {
    $latestPostCurView = mysqli_real_escape_string($mysqli, $_GET['latestPostCurView']);
} else {
    $latestPostCurView = -1;
}

/*Build query based on params*/
$query = "SELECT
  post_id,
  post_by_user_id,
  belongs_to_category,
  post_contents,
  post_title,
  post_date,
  profile_id,
  real_name,
  has_submitted_photo,
  category_id,
  category_name,
  category_color,
  GROUP_CONCAT(DISTINCT attachment_id SEPARATOR ',') as attachment_id,
  IF(IFNULL(followee_id, TRUE), FALSE , TRUE ) as isSubscribed
FROM buboard_posts
  JOIN buboard_profiles ON buboard_posts.post_by_user_id = buboard_profiles.profile_id
  JOIN post_categories ON buboard_posts.belongs_to_category = post_categories.category_id
  LEFT JOIN post_attachments ON buboard_posts.post_id = post_attachments.belongs_to_post_id
  LEFT JOIN (SELECT * FROM profile_follows WHERE follower_id = '$userID') t1 ON post_by_user_id=followee_id
  ";

if ($latestPostCurView != -1) {
    $query .= " WHERE post_id < $latestPostCurView";
}

$query .= " GROUP BY post_id ORDER BY post_id DESC LIMIT 10";

/*End build query*/

$posts_queryresult = mysqli_query($mysqli, $query);

$formatted_posts = array();
while ($post = mysqli_fetch_assoc($posts_queryresult)) {
    #determine if requesting account follows author of post
    if ($post['follower_id'] != null) {
        $post['isSubscribed'] = false;
    } else {
        $post['isSubscribed'] = true;
    }
    unset($post['follower_id']);
    unset($post['followee_id']);

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
