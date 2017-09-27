<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.blue-light_blue.min.css" />
<script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>

<style>


.mdl--layout__content {
  align-items: center;
  justify-content: center;
}

.mdl-grid{
  max-width: 50%;
  height: 600px;
  align-items: center;
  justify-content: center;
}



</style




</head>

<body class="mdl-color--light-blue-A100">
	<!-- This creates a header section in general -->
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header ">
		<!-- Makes a header subsection, pieces go here -->
		<header class="mdl-layout__header">
			<!-- This creates a particular row in the headers, additional can be added -->
			<div class="mdl-layout__header-row">
				<!-- Span is basically just text -->
				<!-- Text could easily be replaced with a query response, so it could be dynamic -->
				<span class="mdl-layout-title">Local Feed: Whats Happening Around You</span>
				<!-- Is suppose to add spacing -->
				<div class="mdl-layout-spacer"></div>
				<!-- Adds the individual tabs -->
				<nav class="mdl-navigation mdl-layout--large-screen-only">
					<!-- Can add sytle="color:color" to make colored text -->
					<a class="mdl-navigation__link" href="">Home</a>
					<a class="mdl-navigation__link" href="">Tag 1</a>
					<a class="mdl-navigation__link" href="">Tag 2</a>
					<a class="mdl-navigation__link" href="">Tag 3</a>
					<a class="mdl-navigation__link" href="">Help</a>
				</nav>
			</div>
		</header>
		
		<!-- Creates the drop down menu for items -->
		<div class="mdl-layout__drawer">
			<!-- Drop down menu title -->
			<span class="mdl-layout-title">BuBoard</span>
			<!-- Sets the style and color of the drop down menu -->
			<nav class="demo-navigation mdl-navigation mdl-color--blue-light_blue-800">
				<!-- Items inside the drop down menu -->
				 <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i>Home</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">forum</i>Tag 1</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i>Tag 2</a>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">people</i>Tag 3</a>
          <div class="mdl-layout-spacer"></div>
          <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">help_outline</i><span class="visuallyhidden">Help</span></a>
			

			</nav>
		</div>	

		<!-- Creates the main content of the page -->
		<div class="mdl-layout-spacer"></div>
		<main class="mdl--layout__content ">
			<!-- Creates a grid where main page content can go -->
			<!-- As long as content is kept in the cell sections, it will be centered, and a "new line" requires another cell section -->
			<!-- Basically just add new post cards into a mdl cell, should format correctly -->
			<div class="mdl-grid mdl-color--grey-300">
				<div class="mdl-cell mdl-cell--1-col mdl-cell--middle">
				Content		
				</div>
			</div>
		</main>
		<div class="mdl-layout-spacer"></div>
			
	</div>

</body>
</html>















