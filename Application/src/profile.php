<?php
require_once 'config.php';
$userinfo = buboard_authenticate($mysqli, $authenticationKey);

if (isset($_GET['id'])) {
    $profile_id = mysqli_real_escape_string($mysqli, $_GET['id']);
} else {
    $profile_id = $userinfo['profile_id'];
}
$data = mysqli_query($mysqli, "select profile_id, real_name, email_address, profile_desc, has_submitted_photo from buboard_profiles where profile_id = '$profile_id'");

$profile_data = mysqli_fetch_assoc($data)


?>

<!doctype html>
<html>
<head>
    <title>Personal Profile</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/profile.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="mdl-color--blue-50" style="height:1500px">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Personal Profile</span>
            <div class="mdl-layout-spacer"></div>
            <a class="mdl-navigation__link" id="help_btn" href="help.php">
                <i class="material-icons">help</i>
                <div class="mdl-tooltip" data-mdl-for="help_btn">
                    Need Help?
                </div>
            </a>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">BuBoard</span>
        <nav class="mdl-navigation mdl-color--blue-light_blue-800">
            <a class="mdl-navigation__link" href="feed.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i> Home</a>
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">forum</i> Personal Feed</a>
            <a class="mdl-navigation__link" href="profile.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i> My Profile</a>
            <a class="mdl-navigation__link" href="help.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help</i> Help</a>
        </nav>
    </div>
	
		<div class="navbar">
			 <a href="feed.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i></a>
            <a  href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">forum</i></a>
            <a  href="profile.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i></a>
            <a href="help.php"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help</i></a>
		</div>
	
    <main>
        <div class="card-profile mdl-shadow--2dp">
            <img id="profile_image" src="<?=($profile_data['has_submitted_photo'] > 0 ? '/usercontent/user_avatars/'.$profile_id.'.jpg' : '/static/image/portrait.jpg')?>">
            <div class="content">
                <h4><?= $profile_data['real_name'] ?></h4>
                <p><?= $profile_data['email_address'] ?><br>
                    <?= $profile_data['profile_desc'] ?></p>
            </div>
            <button id="followBtn" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                <i class="material-icons">add_box</i>Follow
            </button>
			<div id="myModal" class="modal">
				<div class="modal-content">
					<span class="close">&times;</span>
					<img id="checkmark" src="static/image/check_mark.png">
					<h3>Congrats!</h3>
					<p>you have successfully followed  <u><?= $profile_data['real_name'] ?></u>.</p>
				</div>	
			</div>
        </div>
		<div class="example">
			
			<button id="followBtn2" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">
                <i class="material-icons">add_box</i>Follow
            </button>
		</div>
		

    </main>

</div>

<script src="static/js/material.min.js"></script>
<script>
	var modal = document.getElementById("myModal");
	var btn = document.getElementById("followBtn");
	var span = document.getElementsByClassName("close")[0];
	var btn2 = document.getElementById("followBtn2");
	
	btn.onclick = function(){
			modal.style.display = "block";
	}
	
	span.onclick = function() {
			modal.style.display = "none";
	}
	
	window.onclick = function(event) {
		if(event.target == modal) {
			modal.style.display = "none";
		}
	}
	window.onscroll = function(){myFunction()};
	function myFunction() {
		
		if (document.body.scrollTop > 150 ||document.documentElement.scrollTop > 150){
			document.getElementById("followBtn2").style.visibility = "visible";
			
		}
		else {
			document.getElementById("followBtn2").style.visibility = "hidden";
		}
	}
</script>
</body>
</html>
