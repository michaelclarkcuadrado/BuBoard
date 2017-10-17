<?php
require '../config.php';

 $firstname = $_REQUEST['firstname'];
 $lastname = $_REQUEST['lastname'];
 $email = $_REQUEST['email'];
 $major = $_REQUEST['major'];
 $description = $_REQUEST['description'];
 $password1 = $_REQUEST['password1'];
 $password2 = $_REQUEST['password2'];


	$target_dir = "photo/";
	$target_file = $target_dir.basename($_FILES["filetoupload"]["newphoto"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	echo $target_file;

	if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    		echo "File is valid, and was successfully uploaded.\n";
	} else {
    		echo "Possible file upload attack!\n";
	}

	echo 'Here is some more debugging info:';
	print_r($_FILES);






$posts_queryresult = mysqli_query($mysqli, "
INSERT INTO `buboard_profiles` (`profile_id`, `real_name`, `date_signup`, `password_hash`, `email_confirmation_secret`, `email_address`, `email_is_confirmed`, `profile_desc`, `has_submitted_photo`) VALUES (LAST_INSERT_ID(), '$firstname $lastname', '2017-10-03 00:00:00', '$password1', 'fsadfasdf', '$email', '1', '$description', '1');
");




?>

<meta http-equiv="refresh" content="0;URL=../feed.php" />
