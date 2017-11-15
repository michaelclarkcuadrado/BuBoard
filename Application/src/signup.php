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


<style>

    .mdl-grid.center-items {
        width: 100%;
        height: 100%;
        overflow: auto;
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
    <form name="mainform" method="post" onsubmit="return validateForm()" action="api/newProfileSubmit.php" enctype="multipart/form-data">
        <div class="mdl-grid mainbody mdl-shadow--8dp">
            <div class="mdl-grid center-items mdl-shadow--8dp mdl-color--grey-100">

                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
                    <img class="thumbtack" src="static/image/thumbtack.png">
                </div>
                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col">
                    <h2 class="mdl-color-text--blue-grey-600 title">Welcome to BuBoard!</h2>
                </div>

                <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="firstname">First Name</label>
                        <input class="mdl-textfield__input" id="firstname" name="firstname"/>
                        <span class="mdl-textfield__error">Must enter a First Name</span>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="lastname">Last Name</label>
                        <input class="mdl-textfield__input" id="lastname" name="lastname"/>
                    </div>
                </div>
                <div class="mdl-layout-spacer"></div>


                <div class="mdl-layout-spacer"></div>
                <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="email">College Email</label>
                        <input class="mdl-textfield__input" id="email" name="email"/>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="major">Major</label>
                        <input class="mdl-textfield__input" id="major" name="major"/>
                    </div>
                </div>
                <div class="mdl-layout-spacer"></div>


                <div class="mdl-layout-spacer"></div>
                <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password1">Password</label>
                        <input class="mdl-textfield__input" id="password1" type="password" name="password1"/>
                    </div>
                </div>
                <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password2">Re-enter Password</label>
                        <input class="mdl-textfield__input" id="password2" type="password" name="password2"/>
                    </div>
                </div>
                <div class="mdl-layout-spacer"></div>


                <div class="mdl-layout-spacer"></div>
                <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="description">A brief description of yourself</label>
                        <textarea class="mdl-textfield__input " type="text" rows="3" id="description" name="description"></textarea>

                    </div>
                </div>
                <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--4-col">
                    <label class="mdl-color-text--blue-grey-600"> Upload a Profile Picture</label>
                    <input class="mdl-button" type="file" name="fileToUpload" id="fileToUpload"/>
                </div>

                <div class="mdl-layout-spacer"></div>

                <div class="mdl-cell--12-col-desktop mdl-cell--8-col-tablet mdl-cell--4-col-phone">
                    <button class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white submit" type="submit" name="submit" value="uploadImage">
                        Sign Up
                    </button>
                </div>
            </div>
        </div>
        </div>
    </form>
</main>

<script src="static/js/material.min.js"></script>

<script>

    function validateForm() {
        var firstname = document.getElementById("firstname").value;
        var lastname = document.getElementById("lastname").value;
        var email = document.getElementById("email").value;
        var password1 = document.getElementById("password1").value;
        var password2 = document.getElementById("password2").value;


        if (firstname == "" && lastname == "") {
            alert("Must supply a first and last name");
            return false;
        }

        if (firstname == "") {
            alert("Must supply an first name");
            return false;
        }

        if (lastname == "") {
            alert("Must supply an last name");
            return false;
        }

        if (email == "") {
            alert("Must supply an email");
            return false;
        }

        if (email.indexOf("@") == -1) {
            alert("Not an email");
            return false;
        }

        if (email.indexOf("@gettysburg.edu") == -1) {
            alert("Not a Gettysburg email");
            return false;
        }

        if (password1 == "" || password2 == "") {
            alert("Must supply a password");
            return false;
        }

        if (password1 != password2) {
            alert("Passwords do not match");
            return false;
        }

        return true;
    }


</script>


</html>
