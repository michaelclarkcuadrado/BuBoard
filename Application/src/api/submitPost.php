<?php
/**
 * Created by PhpStorm.
 * User: Zachary Miller
 * Date: 11/13/2017
 * Time: 9:36 PM
 */

require '../config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

$title = mysqli_real_escape_string($mysqli, $_POST['title']);
$tag = mysqli_real_escape_string($mysqli, $_POST['tag']);
$post = mysqli_real_escape_string($mysqli, $_POST['post']);

// have to do checks at some point
$check = true;
if (empty($title)){
    echo "check1";
    $check == false;
}
if (empty($tag)){
    echo "check2";
    $check == false;
}
if (empty($post)){
    echo "check3";
    $check == false;
}

if (!$check){
    // go back to the feed page and throw an alert
    header("location: ../createpost.php");
}




// Get the tag number to submit the query with
$tag_query = mysqli_query($mysqli, "
    SELECT category_id
    FROM post_categories
    WHERE category_name = '$tag';
    ");



$tag_id = mysqli_fetch_assoc($tag_query);



$user_id = $userinfo['profile_id'];
$tag_id = $tag_id["category_id"];




$posts_queryresult = mysqli_query($mysqli, "
      INSERT INTO `buboard_posts` (post_by_user_id, belongs_to_category, post_contents, post_title, post_date)
      VALUES ($user_id, '$tag_id', '$post', '$title', NOW());
    ");



$post_id = mysqli_insert_id($mysqli);


if (!empty($_FILES) && isset($_FILES['fileToUpload'])) {
    switch ($_FILES['fileToUpload']["error"]) {
        case UPLOAD_ERR_OK:
            $target = "../usercontent/post_attachments/";
            $target = $target . basename($_FILES['fileToUpload']['name']);


            $uploadOk = 1;

            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            if (pathinfo($target, PATHINFO_EXTENSION) != "jpg") {
                $uploadOk = 0;
            }

            if ($uploadOk == 1) {
                $isUploaded = move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);

                if ($isUploaded) {
                    $status = "The file " . basename($_FILES['fileToUpload']['name']) . " has been uploaded";

                } else {
                    $status = "Sorry, there was a problem uploading your file.";
                }

                rename("$target", "../usercontent/post_attachments/$post_id.jpg");
            }
    }
}


?>