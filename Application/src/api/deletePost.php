<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 11/20/17
 * Time: 12:30 AM
 */
require_once '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

if(isset($_GET['post_id'])){
    //determine if requester can delete this post
    $post_id = intval(mysqli_real_escape_string($mysqli, $_GET['post_id']));
    $authorized = false;
    if($userinfo['isAdmin'] > 0){
        $authorized = true;
    } else {
        $post = mysqli_query($mysqli, "SELECT post_by_user_id FROM buboard_posts WHERE post_id = '$post_id'");
        if(mysqli_num_rows($post) === 0){
            APIFail('Cannot delete: No Such Post.');
        } elseif (mysqli_fetch_assoc($post)['post_by_user_id'] == $userinfo['profile_id']){
            $authorized = true;
        }
    }

    //delete it
    if($authorized){
        //delete attachment files
        $attachments = mysqli_query($mysqli, "SELECT CONCAT(attachment_id, attachment_filename_extension) as filename FROM post_attachments WHERE belongs_to_post_id = '$post_id'");
        while($attachment = mysqli_fetch_assoc($attachments)){
            $stat = unlink('../usercontent/post_attachments/'.$attachment['filename']);
            if(!$stat){
                APIFail('Cannot delete attachments');
            }
        }
        //delete attachment rows
        mysqli_query($mysqli, "DELETE FROM post_attachments WHERE belongs_to_post_id = '$post_id'");
        //delete post row
        mysqli_query($mysqli, "DELETE FROM buboard_posts WHERE post_id  = '$post_id'");
    } else {
        APIFail('Cannot delete: Unauthorized');
    }
} else {
    APIFail('Cannot delete: Must Specify Post.');
}