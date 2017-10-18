<?php
//Login Screen - BuBoard
require_once 'config.php';

?>
<html>
<head>
    <title>Welcome To BuBoard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/login.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

<div id="animationGrid" class="mdl-layout mdl-js-layout mdl-grid">
    <div id="sliding_buboard_logo" class="mdl-cell mdl-cell--3-col">
        <img id="buboard_logo" src="static/image/buboard_logo.png"/>
    </div>
    <div style="display: none; padding: 15px" id="sliding_login_card" class="mdl-card mdl-shadow--6dp">
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="email" id="login"/>
            <label class="mdl-textfield__label" for="login">Email</label>

        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" type="password" id="password"/>
            <label class="mdl-textfield__label" for="password">Password</label>
        </div>

        <button onclick="window.location = 'feed.php'"
                class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
            Sign In
        </button>
<br>
        <button onclick="window.location = 'signup.php'"
                class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
            Sign Up
        </button>
        <br>
        <a class="mdl-color-text--primary" style="text-align: right; font-size: small">Forgot Password</a>

    </div>
</div>
</body>
<script src="static/js/material.min.js"></script>
<script src="static/js/jquery.min.js"></script>
<script src="static/js/jquery.easing.1.3.js"></script>
<script>

$(document).ready(function(){
    setTimeout(function(){
        $('#sliding_login_card').slideDown();
    }, 1200);
});

</script>
</html>
