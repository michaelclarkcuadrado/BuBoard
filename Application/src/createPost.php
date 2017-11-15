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
    .mdl-grid.center-items {
        width: 100%;
        height: 100%;
        overflow: auto;
    }

    .mainbody{
        text-align:center;
        background-color: whitesmoke;
        height: 90%;
        width: 60%;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .text{
        border-color: gray;
        border-style: solid;
        border-radius: 20px;
    }

    .wide{
        border-color: gray;
        border-style: solid;
        border-radius: 20px;
        height: 35%;
        width: 80%;
    }




    @media (max-width: 700px) {

    }
</style>
<main class="mdl--layout">
    <form name="mainform"   method="post" onsubmit="return validateForm()" action="api/submitPost.php" enctype="multipart/form-data">
        <div class="mdl-grid mainbody mdl-shadow--8dp">
            <div class="mdl-grid center-items">
                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <h2 class="mdl-card__title-text mdl-color-text--blue-grey-600 title">Create a Post</h2>
                </div>

                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label text">
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="title">Enter the title of your post</label>
                        <input class="mdl-textfield__input" id="title" name="title" />
                    </div>
                </div>


                <div class="mdl-cell mdl-cell--12-col">
                    <div class="mdl-textfield mdl-js-textfield wide">
                        <textarea class="mdl-textfield__input " type="text" rows= "10" id="post" name="post"></textarea>
                        <label class="mdl-textfield__label mdl-color-text--blue-grey-600" for="post">Your post goes here</label>
                    </div>
                </div>

                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <label class="mdl-color-text--blue-grey-600">Upload a Post Picture</label>

                </div>
                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <input class="mdl-button" type="file" name="fileToUpload" id="fileToUpload">
                </div>


                <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label">
                    <select class="mdl-selectfield__select" id="tag" name="tag">
                        <option value=""></option>
                        <option value="Events">Events</option>
                        <option value="Announcements">Announcements</option>
                    </select>
                    <label class="mdl-selectfield__label" for="professsion2">Select the tag for your post</label>
                </div>

                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <button class="mdl-button mdl-button--raised mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-color-text--white submit" type="submit" name="submit" value="uploadImage">
                        Submit Post
                    </button>
                </div>
            </div>
        </div>
    </form>
</main>

<script>
    function validateForm(){
        var title = document.getElementById("title").value;
        var tag = document.getElementById("tag").value;
        var post = document.getElementById("post").value;

        if (title == ""){
            alert ("Your post must have a title");
            return false;
        }

        if (post == ""){
            alert ("Your post must have text");
            return false;
        }

        if (tag == ""){
            alert ("Your post must have a tag");
            return false;
        }

        return true;
    }

</script>



<script src="static/js/material.min.js"></script>
</html>
