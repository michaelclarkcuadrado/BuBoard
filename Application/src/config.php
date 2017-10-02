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

//smtp server details
$smtpHost = '';
$smtpUser = '';
$smtpPassword = '';
$smtpPort = '587';

$mysqli = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname, $dbport);
if (mysqli_connect_errno()){
    die("Internal Database Server error.");
}