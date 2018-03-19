<?php
require '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

$title = mysqli_real_escape_string($mysqli, $_POST['newPostTitle']);
$tag = mysqli_real_escape_string($mysqli, $_POST['tag']);
$post = mysqli_real_escape_string($mysqli, $_POST['post']);

// have to do checks at some point
if (empty($title)){
    APIFail("All posts must have a title.");
}
if (empty($post)){
    APIFail("Your post must have a body.");
}
if (empty($tag)){
    APIFail("All posts must have a tag set.");
}

//todo, handle multiple file uploads, the backend supports up to 3
$imageUploaded = false;
if(!empty($_FILES) && isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0){
    if (!$_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK){
        APIFail("That image could not be uploaded.");
    } else {
        $image_type = exif_imagetype($_FILES['fileToUpload']['tmp_name']);
        if($image_type !== false) {
            $attachment_extension = image_type_to_extension($image_type);
            $imageUploaded = true;
        }
    }
}

$user_id = $userinfo['profile_id'];

$posts_queryresult = mysqli_query($mysqli, "
      INSERT INTO `buboard_posts` (post_by_user_id, belongs_to_category, post_contents, post_title, post_date)
      VALUES ('$user_id', '$tag', '$post', '$title', NOW());
    ");

$post_id = mysqli_insert_id($mysqli);

//send SMS to profiles who haven't pulled the feed in a while
mysqli_query($mysqli, "UPDATE buboard_profiles JOIN profile_follows follow ON buboard_profiles.profile_id = follow.follower_id SET followers_posts_since_feed_pull = followers_posts_since_feed_pull + 1 WHERE phone_number_is_confirmed > 0 AND followee_id = '".$userinfo['profile_id']."'");
$user_ids_to_notify = mysqli_query($mysqli, "SELECT profile_id, followers_posts_since_feed_pull FROM buboard_profiles WHERE followers_posts_since_feed_pull >= POWER(2, buboard_profiles.power_of_two_posts_til_notification) AND unread_texts_enabled");
while($sms = mysqli_fetch_assoc($user_ids_to_notify)){
    sendTextMessage($mysqli, $sms['profile_id'], false,"You have " . $sms['followers_posts_since_feed_pull'] . " unread posts from your subscriptions on BuBoard!");
}

//bump up notification
mysqli_query($mysqli, "UPDATE buboard_profiles SET power_of_two_posts_til_notification = power_of_two_posts_til_notification + 1 WHERE followers_posts_since_feed_pull >= POWER(2, power_of_two_posts_til_notification)");

if($imageUploaded) {
    //TODO validation here should totally be improved

    $attachment_query = mysqli_query($mysqli, "
      INSERT INTO post_attachments (belongs_to_post_id, attachment_filename_extension) VALUES ('$post_id', '$attachment_extension');
    ");
    $newImageName = "../usercontent/post_attachments/" . mysqli_insert_id($mysqli) . $attachment_extension;
    move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $newImageName);
}