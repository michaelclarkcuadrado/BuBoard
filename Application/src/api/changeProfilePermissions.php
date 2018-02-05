<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 2/5/18
 * Time: 5:16 AM
 */
require_once('../config.php');
$userinfo = buboard_authenticate($mysqli, $authenticationKey);
if ($userinfo['isAdmin'] == 0) {
    APIFail('UNAUTHORIZED');
}

if (isset($_GET['profile_id'])) {
    $profile_id = intval($_GET['profile_id']);
    $did_something = false;
    if (isset($_GET['verifiedAccount']) && ($_GET['verifiedAccount'] == 'true' || $_GET['verifiedAccount'] == 'false')) {
        $verifiedAccount = $_GET['verifiedAccount'] == 'true' ? '1' : '0';
        mysqli_query($mysqli, "
            UPDATE buboard_profiles SET isVerifiedAccount = '$verifiedAccount' WHERE profile_id = '$profile_id';
        ");
        $did_something = true;
    }
    if (isset($_GET['isAdmin']) && ($_GET['isAdmin'] == 'true' || $_GET['isAdmin'] == 'false')) {
        $isAdmin = $_GET['isAdmin'] == 'true' ? '1' : '0';
        if ($profile_id == $userinfo['profile_id'] && $isAdmin == 0) {
            APIFail("Can't un-admin yourself.");
        }
        mysqli_query($mysqli, "
              UPDATE buboard_profiles SET isAdmin = '$isAdmin' WHERE profile_id = '$profile_id';
            ");
        $did_something = true;
    }
    if (!$did_something) {
        APIFail('Parameters not valid.');
    }
} else {
    APIFail('No ID specified.');
}