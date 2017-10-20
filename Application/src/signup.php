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
        background-color: white;
        width: 100%;
        height: 100%;
        overflow: auto;
    }

    .mainbody{
        text-align:center;
        background-color: #80d8ff;
        height: 90%;
        width: 60%;
        align-items: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .title{
        text-align:center;
    }
    body {
        background-image: url('/static/image/corktile.jpg');
        background-attachment: local;
        padding-top: 20px;
    }

    .text{
        border-style: solid;
        border-color: gray;
        height: 50px;
        border-radius: 10px;
        border-bottom: none;
    }

    .wide{
        border-style: solid;
        border-color: gray;
        height: 80px;
        border-radius: 10px;
        border-bottom: none;
    }



    @media (max-width: 700px) {
        .mdl-grid.center-items {
            background-color: white;
            width: 100%;
            height: 100%;
            overflow: auto;
        }

        .mainbody{
            background-color: #80d8ff;
            height: 90%;
            width: 92%;
            align-items: center;
            padding-top: 15px;
            padding-bottom: 15px;
        }
    }


</style>




<main class="mdl--layout">
	<form name="mainform"  method="post" onsubmit="return validateForm()" action="api/newProfileSubmit.php" enctype="multipart/form-data">
        <div class="mdl-grid mainbody mdl-shadow--8dp">
            <div class="mdl-grid center-items mdl-shadow--8dp">

                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <img class="thumbtack" src="static/image/thumbtack.png">
                </div>
                <h2 class="mdl-card__title-text mdl-color-text--blue-grey-600 title">Sign Up Page</h2>

                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone"></div>
                <div class="mdl-cell mdl-cell--6-col mdl-cell--5-col-phone">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                            <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="firstname">First Name</label>
                            <input class="mdl-textfield__input" id="firstname" name="firstname" />
                            <span class="mdl-textfield__error">Must enter a First Name</span>
                    </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col mdl-cell--5-col-phone">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                            <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="lastname">Last Name</label>
                            <input class="mdl-textfield__input" id="lastname" name="lastname" />
                    </div>
                    </div>
                    <div class="mdl-layout-spacer"></div>



                <div class="mdl-layout-spacer"></div>
                <div class="mdl-cell mdl-cell--6-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                            <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="email">College Email</label>
                            <input class="mdl-textfield__input" id="email" name="email" />
                    </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="major">Major</label>
                        <input class="mdl-textfield__input" id="major" name="major"/>
                    </div>
                    </div>
                    <div class="mdl-layout-spacer"></div>




                <div class="mdl-layout-spacer"></div>
                <div class="mdl-cell mdl-cell--6-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                            <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password1">Password</label>
                            <input class="mdl-textfield__input" id="password1" type="password" name="password1" />
                    </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password2">Re-enter Password</label>
                        <input class="mdl-textfield__input" id="password2" type="password" name="password2" />
                    </div>
                    </div>
                    <div class="mdl-layout-spacer"></div>


                <div class="mdl-layout-spacer"></div>
                <div class="mdl-cell mdl-cell--12-col">
                      <div class="mdl-textfield mdl-js-textfield wide">
                        <textarea class="mdl-textfield__input " type="text" rows= "2" id="description" name="description"></textarea>
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="description">A brief description of yourself</label>
                      </div>
                </div>


                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <label class="mdl-color-text--blue-grey-600"> Upload a Profile Picture</label>

                </div>
                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                <form>
                    <input class="mdl-button" type="file" name="filetoupload" id="filetoupload">
                 </form>

                </div>

                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <button class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white submit" type="submit" name="submit">
                    Sign Up
                    </button>
                </div>
            </div>
        </div>
	</form>
</main>

<script src="static/js/material.min.js"></script>

<script>

    function validateForm(){

        var firstname = document.getElementById("firstname").value;
        var lastname = document.getElementById("lastname").value;
        var email = document.getElementById("email").value;
        var password1 = document.getElementById("password1").value;
        var password2 = document.getElementById("password2").value;


        if (firstname == ""){
            alert("Must supply an first name");
            return false;
        }

        if (lastname == ""){
            alert("Must supply an last name");
            return false;
        }

        if (email == ""){
            alert("Must supply an email");
            return false;
        }

        if(email.indexOf("@") == -1){
            alert("Not an email");
            return false;
        }

        if (email.indexOf("@gettysburg.edu") == -1){
            alert("Not a Gettysburg email");
            return false;
        }

        if (password1 == "" || password2 == ""){
            alert("Must supply a password")
        }

        if (password1 != password2){
            alert("Passwords do not match");
            return false;
        }

        return true;
    }



</script>



</html>
