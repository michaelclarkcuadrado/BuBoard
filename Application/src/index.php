<?php
//Login Screen - BuBoard
require_once 'config.php';

$messagePresent = false;
$message = null;

if(isset($_COOKIE['username']) && isset($_COOKIE['token'])){
    die("<script>window.location = '/feed.php'</script>");
}

//if authenticating, run login
if (isset($_POST['username']) && isset($_POST['password'])) {
    $returnVal = buboard_login($mysqli, $authenticationKey);
    $messagePresent = $returnVal['messagePresent'];
    $message = $returnVal['message'];
}

if (isset($_GET['message'])) {
    $messagePresent = true;
    $message = $_GET['message'];
}
?>
<html>
<head>
    <title>Welcome To BuBoard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/login.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#2196f3">

    <!--Used for favicon generation -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
</head>

<body style="overflow:hidden">

<div id="animationGrid"  class="mdl-layout mdl-js-layout mdl-grid">
    <div id="sliding_buboard_logo" class="mdl-cell mdl-cell--3-col">
        <img id="buboard_logo" src="static/image/buboard_logo.png"/>
    </div>
    <div style="display: none; padding: 15px" id="sliding_login_card" class="mdl-card mdl-shadow--6dp">
        <form action="index.php" method="post">
        <div class="mdl-typography--text-center"><?=($messagePresent ? strip_tags($message) : "")?></div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="username" type="email" id="login" required/>
            <label class="mdl-textfield__label" for="login">Email</label>
        </div>
        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
            <input class="mdl-textfield__input" name="password" type="password" id="password" required/>
            <label class="mdl-textfield__label" for="password">Password</label>
        </div>

        <button style="width:100%"
                class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
            Sign In
        </button>
        </form>
        <br>
        <button onclick="window.location = 'signup.php'"
                class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
            Sign Up
        </button>
        <br>
        <a class="mdl-color-text--primary" href="forgotPassword.php" style="text-align: right; font-size: small">Forgot Password</a>

    </div>
</div>
</body>
<script src="static/js/material.min.js"></script>
<script src="static/js/jquery.min.js"></script>
<script src="static/js/jquery.easing.1.3.js"></script>
<script>

    $(document).ready(function () {
        setTimeout(function () {
            $('#sliding_login_card').slideDown();
        }, <?=($messagePresent ? 0 : 1200)?>);
    });
</script>
</html>
