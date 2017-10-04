<?php
//Sign Up Screen - BuBoard


?>
<html>
<head>
    <title>Welcome To BuBoard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="static/css/material.min.css"/>
    <link rel="stylesheet" href="static/css/signup.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>


<!--
This div here should center this log in screen on any page that the user is on
-->

<main class="mdl--layout">
    <!-- Subsection of the main page -->
    <div class="page-content">
        <!-- Centers the card on the page -->
        <div class="mdl-grid">
            <div class="mdl-layout-spacer"></div>
            <div class="mdl-card">
                <div class="mdl-card__title mdl-color--primary mdl-color-text--white relative">
                    <h2 class="mdl-card__title-text">Sign Up Page</h2>
                </div>

                <!-- This is an individual row, two text fields to a row -->
                <div class="content-grid mdl-grid">
                    <div class="mdl-layout-spacer"></div>

                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <h5 class="mdl-color-text--blue-grey-400">First Name</h5>
                            <input class="mdl-textfield__input" id="firstname"/>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <h5 class="mdl-color-text--blue-grey-400">First Name</h5>
                            <input class="mdl-textfield__input" id="lastname"/>
                        </div>
                    </div>
                    <div class="mdl-layout-spacer"></div>


                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label extrawide" id="email">
                            <h5 class="mdl-color-text--blue-grey-400">Email</h5>
                            <input class="mdl-textfield__input" id="firstname"/>
                        </div>
                    </div>

                    <div class="mdl-cell mdl-cell--6">
                        <h5 class="mdl-color-text--blue-grey-400">College</h5>
                        <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">

                            <select class="mdl-selectfield__select mdl-color-text--blue-grey-400" id="college" name="college">
                                <option value="option1">Gettysburg College</option>
                                <option value="option2">Also Gettysburg College</option>

                            </select>

                        </div>
                    </div>


                    <div class="mdl-layout-spacer"></div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <h5 class="mdl-color-text--blue-grey-400">Password</h5>
                            <input class="mdl-textfield__input" id="firstname"/>
                        </div>
                    </div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <h5 class="mdl-color-text--blue-grey-400">Re-enter Password</h5>
                            <input class="mdl-textfield__input" id="lastname"/>
                        </div>
                    </div>
                    <div class="mdl-layout-spacer"></div>


                    <div class="mdl-layout-spacer"></div>
                    <div class="mdl-cell mdl-cell--6-col">
                        <h5 class="mdl-color-text--blue-grey-400">Description</h5>
                        <textarea class="mdl-textfield__input" type="text" rows="5" id="description"></textarea>
                    </div>
                </div>


                <div class="content-grid mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <button onclick="window.location = 'feed.php'" class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white">
                            Sign Up
                        </button>
                    </div>
                </div>


            </div>
            <div class="mdl-layout-spacer"></div>
        </div>
    </div>
    </div>
</main>

<script src="static/js/material.min.js"></script>

</html>
