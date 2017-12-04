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

//todo, handle multiple file uploads
$imageUploaded = false;
if(!empty($_FILES) && isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['size'] > 0){
    if (!$_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK){
        APIFail("That image could not be uploaded.");
    } else {
        $imageUploaded = true;
    }
}

$user_id = $userinfo['profile_id'];

$posts_queryresult = mysqli_query($mysqli, "
      INSERT INTO `buboard_posts` (post_by_user_id, belongs_to_category, post_contents, post_title, post_date)
      VALUES ('$user_id', '$tag', '$post', '$title', CURDATE());
    ");

$post_id = mysqli_insert_id($mysqli);

if($imageUploaded) {
    //TODO validation here should totally be improved
    if (strpos($_FILES['fileToUpload']['name'], "jpg") == false) {
        mysqli_query($mysqli, "DELETE FROM post_attachments WHERE attachment_id = '$post_id'");
        APIFail("The image must be in jpeg format.");
    }

    $attachment_query = mysqli_query($mysqli, "
      INSERT INTO post_attachments (belongs_to_post_id, post_attachment_num) VALUES ('$post_id', 1);
    ");
    $newImageName = "../usercontent/post_attachments/";
    $newImageName .= mysqli_insert_id($mysqli) . ".jpg";
    move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $newImageName);
}

?>
