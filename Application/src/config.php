<?php
//Mysql db details
$dbhost = 'buboard-database';
$dbusername = 'buboard';
$dbpassword = 'buboard';
$dbport = '3306';
$dbname = 'buboard-data';

//authentication private key
//this is in the repo, and is obviously not secret. Replace on a real deployment
$authenticationKey = "c68RgEqQVAJkD3cg1kAz0Go8R96x3G/iWDMsCx3IQuU=";

$mysqli = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname, $dbport);
if (mysqli_connect_errno()) {
    die("Internal Database Server error.");
}

function buboard_login($mysqli, $authenticationKey) {
    //check for login request
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $hash = mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT password_hash FROM buboard_profiles WHERE email_address = '$username'"))['password_hash'];
    if (password_verify($_POST['password'], $hash)) {
        //ding ding ding!
        setcookie('username', $username);
        setcookie('token', crypt($username, $authenticationKey));
        die("<script>window.location = '/feed.php'</script>");
    } else {
        $messagePresent = true;
        $message = "Incorrect password or username. Try again.";
    }
}

function buboard_authenticate($mysqli, $authenticationKey) {
    if (!isset($_COOKIE['token']) || !isset($_COOKIE['username'])) {
        die("<script>window.location.replace('/')</script>");
    } else if (!hash_equals($_COOKIE['token'], crypt($_COOKIE['username'], $authenticationKey))) {
        die("<script>window.location.replace('/')</script>");
    } else {
        $SecuredUserName = mysqli_real_escape_string($mysqli, $_COOKIE['username']);
        return mysqli_fetch_assoc(mysqli_query($mysqli, "SELECT * FROM buboard_profiles WHERE email_address = '$SecuredUserName'"));
    }
}