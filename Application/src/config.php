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
    $profile_auth = mysqli_query($mysqli, "SELECT password_hash, email_is_confirmed, email_address FROM buboard_profiles WHERE email_address = '$username'");
    if(mysqli_num_rows($profile_auth) == 0){
        //no such username
        return array('messagePresent' => true, 'message' => "Incorrect password or username, try again.");
    }
    $profile_auth = mysqli_fetch_assoc($profile_auth);
    if($profile_auth['email_is_confirmed'] > 0) {
        if (password_verify($_POST['password'], $profile_auth['password_hash'])) {
            //ding ding ding!
            setcookie('username', $username);
            setcookie('token', crypt($username, $authenticationKey));
            die("<script>window.location = '/feed.php'</script>");
        } else {
            return array('messagePresent' => true, 'message' => "Incorrect password or username, try again.");
        }
    } else {
        return array('messagePresent' => true, 'message' => "You need to confirm your email at " . $profile_auth['email_address'] . " before you can log in.");
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

function kill_signup($mysqli, $sql_check, $pic_check, $profile_id){
    $target = "/usercontent/user_avatars/";
    // if $sql_check = true: then the data was added to the database, but an error was encountered later
    // if $pic_check = true: then the picture was added to the database, but an error was encountered later

    // if both false: nothing need to be done, as no data was added before a failure

    // if $sql_check = true and $pic_check = false: we have to remove the most recent addition to the profile list
    if ($sql_check == true && $pic_check == false){
        $posts_queryresult = mysqli_query($mysqli, "
            DELETE
            FROM buboard_profiles
            WHERE profile_id = '$profile_id';
        ");
    }
    // if $sql_check = false and $pic_check = true: we need to remove the profile pic with the highest number
    else if ($sql_check == false && $pic_check == true){
        unlink('$target$profile_id');
    }
    // if both true: remove most recent profile and most recent profile pic
    else if ($sql_check == true && $pic_check == true){
        $posts_queryresult = mysqli_query($mysqli, "
            DELETE
            FROM buboard_profiles
            WHERE profile_id = '$profile_id';
        ");
        unlink('$target$profile_id');
    }

}


/**
 * Kills a connection and gives an error message
 * @param $errorMsg - string, failure reason given
 */
function APIFail($errorMsg = 'Internal Server Error'){
    header($_SERVER['SERVER_PROTOCOL'] . '500 ' . $errorMsg, true, 500);
    error_log($errorMsg);
    die();
}