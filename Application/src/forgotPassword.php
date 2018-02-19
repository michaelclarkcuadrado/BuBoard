<?php
/**
 * Created by PhpStorm.
 * User: Zachary Miller
 * Date: 11/24/2017
 * Time: 10:46 AM
 */
?>

<html>

<head>
    <title>Welcome To BuBoard</title>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?=getenv("ANALYTICS_ID")?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', '<?=getenv("ANALYTICS_ID")?>');
    </script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" type="text/css" href="static/css/signup.css"/>
    <meta name="theme-color" content="#2196f3">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--Used for favicon generation -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
</head>


<style>

    .main{
        justify-content: center;
    }

    .mdl-grid.center-items {
        width: 100%;
        height: 100%;
        overflow: auto;
        justify-content: center;
    }

    .mainbody {
        text-align: center;
        background-color: #80d8ff;
        margin-left: 35px;
        margin-right: 35px;
        width: fit-content;
        align-items: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .title {
        text-align: center;
    }

    body {
        background-image: url('/static/image/corktile.jpg');
        background-attachment: local;
        padding-top: 20px;
    }

    .text {
        border-color: lightgray;
        border-style: double;
        border-width: 5px;
        border-radius: 10px;
        margin: 5px;
    }

    .submit {
        postion: fixed;
        buttom: 5%;
        right: 3%;

    }

    @media (max-width: 700px) {
        .mdl-grid.center-items {
            background-color: white;
            width: 100%;
            height: 100%;
            overflow: auto;
        }

        .mainbody {
            background-color: #80d8ff;
            margin: 5px;
            width: calc(100% - 26px);
            align-items: center;
            padding-top: 15px;
            padding-bottom: 15px;
        }
    }


</style>

<main class="mdl--layout">
    <form name="mainform" method="post" onsubmit="return validateForm()" action="api/forgotPasswordScript.php">
        <div class="mdl-grid main">
            <div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
                <div class="mdl-grid mainbody mdl-shadow--8dp">
                    <div class="mdl-grid center-items mdl-shadow--8dp mdl-color--grey-100">

                        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
                            <img class="thumbtack" src="static/image/thumbtack.png">
                        </div>
                        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col">
                            <h4 class="mdl-color-text--blue-grey-600 title">Enter in your information click submit</h4>
                        </div>

                        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                                <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="email">Enter your accounts email</label>
                                <input class="mdl-textfield__input" id="email" name="email"/>
                            </div>
                        </div>

                        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                                <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password1">Enter your new password</label>
                                <input class="mdl-textfield__input" type="password" id="password1" name="password1"/>
                            </div>
                        </div>

                        <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col">
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                                <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password2">Re-enter your new password</label>
                                <input class="mdl-textfield__input" type="password" id="password2" name="password2"/>
                            </div>
                        </div>

                        <div class="mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
                            <button class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white submit" type="submit" name="submit" value="uploadImage">
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<script src="static/js/material.min.js"></script>

<script>
    function validateForm(){
        var email = document.getElementById("email").value;
        var password1 = document.getElementById("password1").value;
        var password2 = document.getElementById("password2").value;

        if (password1 != password2){
            alert("Passwords do not match");
            return false;
        }

        return true;
    }
</script>
</html>
