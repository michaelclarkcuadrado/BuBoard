<?php
/**
 * Created by PhpStorm.
 * User: Zachary Miller
 * Date: 11/13/2017
 * Time: 8:37 PM
 */
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
    .mainbodyModal {
        text-align: center;
        background-color: whitesmoke;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .textModal {
        border-color: gray;
        border-style: solid;
        border-radius: 20px;
    }

    .wideModal {
        border-color: gray;
        border-style: solid;
        border-radius: 20px;
        height: 35%;
        width: 80%;
    }
</style>
<div id="overlayModal">
    <form name="mainform" method="post" onsubmit="return validateForm()" action="api/submitPost.php" enctype="multipart/form-data">
        <div class="mdl-grid mainbodyModal mdl-shadow--8dp">
            <div class="mdl-grid center-items">
                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <h2 class="mdl-card__title-text mdl-color-text--blue-grey-600 title">Pin To Buboard</h2>
                </div>

                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label textModal">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="title">Enter the title of your post</label>
                        <input class="mdl-textfield__input" name="newPostTitle"/>
                    </div>
                </div>


                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield wideModal">
                        <textarea class="mdl-textfield__input " type="text" rows="10" name="post"></textarea>
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="post">Your post goes here</label>
                    </div>
                </div>

                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <label class="mdl-color-text--blue-grey-600">Upload a Post Picture</label>

                </div>
                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <input class="mdl-button" type="file" name="fileToUpload">
                </div>


                <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
                    <select class="mdl-selectfield__select" name="tag">
                        <option value=""></option>
                        <option value="Events">Events</option>
                        <option value="Announcements">Announcements</option>
                    </select>
                    <label class="mdl-selectfield__label" for="professsion2">Select the tag for your post</label>
                </div>

                <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--4-col-phone">
                    <button class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white submit" type="submit" name="submit" value="uploadImage">
                        Submit Post
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="static/js/material.min.js"></script>
</html>
