<?php
require '../config.php';

$email = mysqli_real_escape_string($mysqli ,$_GET['email']);
$confirmcode = $_GET['confirmcode'];

$result = mysqli_query($mysqli, "
SELECT *
FROM buboard_profiles
WHERE email_address='$email';
");

$row = mysqli_fetch_assoc($result);
$db_code = $row['email_confirmation_secret'];




if ($confirmcode === $db_code){
    $result2 = mysqli_query($mysqli, "
    UPDATE buboard_profiles
    SET email_is_confirmed='1'
    WHERE email_address='$email';
    ");

    $confirmed = "Email Confirmed: Feel free to log on to BuBoard";



}
else{
    $confirmed = "Invalid email code";
}

?>

<html>
<head>
    <title>Welcome To BuBoard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="../static/css/material.min.css"/>
    <link rel="stylesheet" type="text/css" href="../static/css/signup.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<style>

    .mdl-grid.center-items {
        width: 100%;
        height: 100%;
        overflow: auto;
        justify-content: center;
    }

    .main{
        padding-top: 20px;
    }

    .mainbody{
        text-align:center;
        background-color: #80d8ff;
        height: 50%;
        width: 40%;
        align-items: center;
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .title{
        text-align:center;
    }
    body {
        background-image: url('../static/image/corktile.jpg');
        background-attachment: local;
        padding-top: 20px;
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

<main class="mdl--layout main">
    <form name="mainform"  method="post" onsubmit="return validateForm()" action="api/newProfileSubmit.php" enctype="multipart/form-data">
        <div class="mdl-grid mainbody mdl-shadow--8dp">
            <div class="mdl-grid center-items mdl-shadow--8dp mdl-color--grey-100">
                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone">
                    <img class="thumbtack" src="../static/image/thumbtack.png">
                </div>
                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone"></div>
                <h2 class="mdl-card__title-text mdl-color-text--blue-grey-600 title"><?php echo $confirmed; ?></h2>
                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone"></div>
                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone"></div>
                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone"></div>
                <div class="mdl-cell--12-col-desktop mdl-cell--5-col-phone"></div>
            </div>
        </div>
    </form>
</main>


</html>

