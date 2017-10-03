<!doctype html>
<html>
<head>
    <title>BuBoard Feed</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/feed.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="mdl-color--light-blue-A100">
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <span class="mdl-layout-title">Local Feed</span>
            <div class="mdl-layout-spacer"></div>
            <a class="mdl-navigation__link" href="help.php">
                <i class="material-icons">help</i>
            </a>
        </div>
    </header>
    <div class="mdl-layout__drawer">
        <span class="mdl-layout-title">BuBoard</span>
        <nav class="mdl-navigation mdl-color--blue-light_blue-800">
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">home</i> Home</a>
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">forum</i> Personal Feed</a>
            <a class="mdl-navigation__link" href=""><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">flag</i> My Profile</a>
        </nav>
    </div>

    <!-- Creates the main content of the page -->
    <main class="mdl--layout__content ">
        <div class="mdl-grid">
            <div class="mdl-card mdl-shadow--4dp mdl-cell mdl-cell--4-col">
                <div class="mdl-card__title mdl-color--blue">
                    <h2 class="mdl-card__title-text">
                        Welcome to BuBoard!
                    </h2>
                </div>
                <div class="mdl-card__supporting-text">
                    This is a long text post about things and stuff. Many things are said here, regarding several other things. Sometimes, this text has substance. Sometimes, like this 			    one, they do not.
                    <div class="card-image-attachments">
                        <hr>
                        Attachments:
                        <div>
                            <a target="_blank" href="static/image/buboard_logo.jpg"><img class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone" src="static/image/buboard_logo.jpg"></a>
                            <a target="_blank" href="static/image/buboard_logo.jpg"><img class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone" src="static/image/buboard_logo.jpg"></a>
                            <a target="_blank" href="static/image/buboard_logo.jpg"><img class="mdl-cell mdl-cell--2-col mdl-cell--1-col-phone" src="static/image/buboard_logo.jpg"></a>
                        </div>
                    </div>
                </div>
                <div class="mdl-card__menu">
                    <button id="demo-menu-lower-right"
                            class="mdl-button mdl-js-button mdl-button--icon">
                        <i class="material-icons">more_vert</i>
                    </button>
                    <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect"
                        for="demo-menu-lower-right">
                        <li class="mdl-menu__item">Follow User</li>
                        <li class="mdl-menu__item">RSVP</li>
                        <li class="mdl-menu__item">Delete Post</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    <div class="mdl-layout-spacer"></div>

</div>

</body>
<script src="static/js/material.min.js"></script>

</html>















