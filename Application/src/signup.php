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
       justify-content: center;
        background-color: white;
        width: 90%;
        height: 90%;
        overflow: auto;
    }

    .wide {
       width: 250px;
    }

    .browse {
       width: 75%;
       height: 5%;
    }

    .submit {
        width: 100%;
        height: 5%;
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

    .mainbody{
        background-color: #80d8ff;
        height: 90%;
        width: 50%;
        align-items: center;
        padding-top: 20px;
    }

    .center{
        justify-content: center;
    }


</style>


<!--
De squish the card
-->

<main class="mdl--layout">
	<form action="api/input.php" method="post" enctype="multipart/form-data">
        <div class="mdl-grid center">
            <div class="mdl-card--border mainbody mdl-shadow--8dp">
                <div class="mdl-grid center-items mdl-shadow--8dp">
                    <div class="mdl-cell--1-col-desktop">
                        <img class="thumbtack" src="static/image/thumbtack.png">
                    </div>
                    <div class="mdl-cell--12-col-desktop">
                    </div>
                    <div class="mdl-cell--4-col-desktop">
                        <div class="mdl-layout-spacer"></div>
                        <h2 class="mdl-card__title-text mdl-color-text--blue-grey-600">Sign Up Page</h2>
                        <div class="mdl-layout-spacer"></div>
                    </div>
                        <!-- This is an individual row, two text fields to a row -->
                        <div class="content-grid mdl-grid">
                            <div class="mdl-layout-spacer"></div>
                            <div class="mdl-cell mdl-cell--4-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="firstname">First Name</label>
                                        <input class="mdl-textfield__input" id="firstname" name="firstname" />
                                </div>
                                </div>
                                <div class="mdl-cell mdl-cell--4-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="lastname">Last Name</label>
                                        <input class="mdl-textfield__input" id="lastname" name="lastname" />
                                </div>
                                </div>
                                <div class="mdl-layout-spacer"></div>
                        </div>

                        <!-- This is an individual row, two text fields to a row -->
                        <div class="content-grid mdl-grid">
                            <div class="mdl-layout-spacer"></div>
                            <div class="mdl-cell mdl-cell--4-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="email">College Email</label>
                                        <input class="mdl-textfield__input" id="email" name="email" />
                                </div>
                                </div>
                                <div class="mdl-cell mdl-cell--4-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                                    <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="major">Major</label>
                                    <input class="mdl-textfield__input" id="major" name="major"/>
                                </div>
                                </div>
                                <div class="mdl-layout-spacer"></div>
                        </div>


                        <div class="content-grid mdl-grid">
                            <div class="mdl-layout-spacer"></div>
                            <div class="mdl-cell mdl-cell--4-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password1">Password</label>
                                        <input class="mdl-textfield__input" id="password1" type="password" name="password1" />
                                </div>
                                </div>
                                <div class="mdl-cell mdl-cell--4-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                                    <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="password2">Re-enter Password</label>
                                    <input class="mdl-textfield__input" id="password2" type="password" name="password2" />
                                </div>
                                </div>
                                <div class="mdl-layout-spacer"></div>

                        </div>

                        <div class="content-grid mdl-grid">
                            <div class="mdl-layout-spacer"></div>
                                        <!-- Floating Multiline Textfield -->
                              <div class="mdl-textfield mdl-js-textfield wide">
                                <textarea class="mdl-textfield__input " type="text" rows= "2" id="description" name="description"></textarea>
                                <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="description">A brief description of yourself</label>
                              </div>

                        </div>


                        <div class="content-grid mdl-grid">
                            <div class="mdl-layout-spacer"></div>
                            <div class="mdl-cell mdl-cell--4-col">
                                <label class="mdl-color-text--blue-grey-600"> Upload a Profile Picture</label>

                            </div>
                                <div class="mdl-cell mdl-cell--4-col">
                                <form>
                                    <input type="file" name="filetoupload" id="filetoupload">
                                 </form>

                                </div>
                                <div class="mdl-layout-spacer"></div>

                        </div>




                        <div class="content-grid mdl-grid">
                            <div class="content-grid mdl-grid">
                                            <div class="mdl-cell mdl-cell--12-col">
                                                <button class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white submit" type="submit" name="submit">
                                                Sign Up
                                                </button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
	</form>
</main>

<script src="static/js/material.min.js"></script>



</html>
