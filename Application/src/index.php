<html>
<!-- test -->
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue-light_blue.min.css" />
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

<style>
.mdl-card__title > img {
  max-width: 100%;
}


.mdl-layout {
  align-items: center;
  justify-content: center;
}

body{
	background-color: #80d8ff;
}
</style>

<body>

<!--
This div here should center this log in screen on any page that the user is on
-->
<main class="mdl--layout__content">

	<!-- Subsection of the main page -->
	<div class="page-content"> 
			<!-- Centers the card on the page -->
			<div class="mdl-layout">
			<div class="mdl-layout mdl-js-layout" style="width:800px; margin:0 auto;">


				<div id="cube" class="show-front">
				    <figure class="front">
					<div class="mdl-card mdl-shadow--6dp">
					    <div class="mdl-card__title mdl-color--primary mdl-color-text--white relative">
						<img src = "static/image/buboard_logo.jpg"/>
						<h2 class="mdl-card__title-text">Buboard Login</h2>
					    </div>

					    <div class="mdl-card__supporting-text">
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" id="login"/>
						    <label class="mdl-textfield__label" for="login">Email or Username</label>

						</div>
						<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
						    <input class="mdl-textfield__input" type="password" id="password"/>
						    <label class="mdl-textfield__label" for="password">Password</label>
						</div>
					    </div>

					    <div class="mdl-card__actions mdl-card--border">
						<div class="mdl-grid">
						    <button class="mdl-cell mdl-cell--12-col mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
						        Sign In
						    </button>

						    <button class="mdl-cell mdl-cell--12-col mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
						        Sign Up
						    </button>
				



						</div>

						<div class="mdl-grid">
						    <div class="mdl-cell mdl-cell--12-col">
						        <a onClick='index.php' class="mdl-color-text--primary" style="float: right">Forgot Password</a>
						    </div>
						</div>
					    </div>
					</div>
				    </figure>

				</div>
			</div>
	</div>
	</div>
</main>


</body>

</html>
