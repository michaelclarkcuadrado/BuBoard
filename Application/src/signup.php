<?php
//Sign Up Screen - BuBoard


?>
<html>
<head>
    <title>Welcome To BuBoard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/signup.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<style>


.mdl-grid.center-items {
  justify-content: center;
}

.wide {
   width: 250px;
}


</style>


<!--
This div here should center this log in screen on any page that the user is on
-->

<main class="mdl--layout">
	<div class="mdl-grid center-items">
	

		<div class="mdl-card mdl-shadow--6dp sign-up-card mdl-cell--4-col mdl-cell--4-col-phone">
			<div class="mdl-card__title mdl-color--primary mdl-color-text--white relative">
				<div class="mdl-layout-spacer"></div>
				<h2 class="mdl-card__title-text">Sign Up</h2>
				<div class="mdl-layout-spacer"></div>
			</div>

			<!-- This is an individual row, two text fields to a row -->
			<div class="content-grid mdl-grid">
				<div class="mdl-layout-spacer"></div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    		<label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="firstname">First Name</label>
				    		<input class="mdl-textfield__input" id="firstname"/>
					</div>
			    	</div>
			    	<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    	<label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="lastname">Last Name</label>
				    	<input class="mdl-textfield__input" id="lastname"/>
					</div>
			    	</div>
			    	<div class="mdl-layout-spacer"></div>
			</div>

			<!-- This is an individual row, two text fields to a row -->
			<div class="content-grid mdl-grid">
				<div class="mdl-layout-spacer"></div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    		<label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="email">College Email</label>
				    		<input class="mdl-textfield__input" id="email"/>
					</div>
			    	</div>
			    	<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    	<label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="major">Major</label>
				    	<input class="mdl-textfield__input" id="major"/>
					</div>
			    	</div>
			    	<div class="mdl-layout-spacer"></div>
			</div>


			<div class="content-grid mdl-grid">
				<div class="mdl-layout-spacer"></div>
				<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    		<label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password1">Password</label>
				    		<input class="mdl-textfield__input" id="password1" type="password"/>
					</div>
			    	</div>
			    	<div class="mdl-cell mdl-cell--4-col">
					<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
				    	<label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password2">Re-enter Password</label>
				    	<input class="mdl-textfield__input" id="password2" type="password"/>
					</div>
			    	</div>
			    	<div class="mdl-layout-spacer"></div>

			</div>

			<div class="content-grid mdl-grid">
				<div class="mdl-layout-spacer"></div>
                    		<!-- Floating Multiline Textfield -->
				<form action="#">
				  <div class="mdl-textfield mdl-js-textfield wide">
				    <textarea class="mdl-textfield__input " type="text" rows= "2" id="description" ></textarea>
				    <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="description">A brief description of yourself</label>
				  </div>
				</form>

			</div>


			<div class="content-grid mdl-grid">
				<div class="content-grid mdl-grid">
                    			<div class="mdl-cell mdl-cell--12-col">
                        			<button onclick="window.location = 'feed.php'" class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
                           			Sign Up
                        			</button>
                    </div>
                </div>
			
			</div>
		
		</div>

	</div>
</main>

<script src="static/js/material.min.js"></script>

</html>
