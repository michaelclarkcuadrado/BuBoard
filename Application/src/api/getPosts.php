<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 10/3/17
 * Time: 3:34 PM
 */

require '../config.php';

//TODO get your own userid. this should be properly handled by authentication api when implemented
$userID = '1';

$posts_queryresult = mysqli_query($mysqli, "
SELECT *
FROM buboard_posts
JOIN buboard_profiles ON buboard_posts.post_by_user_id = buboard_profiles.profile_id
JOIN post_categories ON buboard_posts.belongs_to_category = post_categories.category_id
LEFT JOIN post_attachments ON buboard_posts.post_id = post_attachments.belongs_to_post_id 
LEFT JOIN (SELECT * FROM profile_follows WHERE follower_id = '$userID') t1 ON post_by_user_id=followee_id
");

$formatted_posts = array();
while($post = mysqli_fetch_assoc($posts_queryresult)){
    #determine if requesting account follows author of post
    if ($post['follower_id'] != null){
        $post['isSubscribed'] = false;
    } else {
        $post['isSubscribed'] = true;
    }
    unset($post['follower_id']);
    unset($post['followee_id']);

    # merge attachment info, insert to final array
    if(isset($formatted_posts[$post['post_id']])){
        $attachment = array('attachment_id' => $post['attachment_id'], 'post_attachment_num' => $post['post_attachment_num'], 'belongs_to_post_id' => $post['belongs_to_post_id']);
        $formatted_posts[$post['post_id']]['attachments'][$post['attachment_id']] = $attachment;
    } else {
        $post['attachments'] = array();
        if($post['attachment_id'] != null){
            $attachment = array('attachment_id' => $post['attachment_id'], 'post_attachment_num' => $post['post_attachment_num'], 'belongs_to_post_id' => $post['belongs_to_post_id']);
            $post['attachments'][$post['attachment_id']] = $attachment;
        }
//        unset($post['attachment_id'], $post['post_attachment_num'], $post['belongs_to_post_id']);
        $formatted_posts[$post['post_id']] = $post;
    }
}

echo json_encode($formatted_posts);
