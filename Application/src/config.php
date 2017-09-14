<?php
//Mysql db details
$dbhost = 'buboard-database';
$dbusername = 'buboard';
$dbpassword = 'buboard';
$dbport = '3306';
$dbname = 'buboard-data';

//smtp server details
$smtpHost = '';
$smtpUser = '';
$smtpPassword = '';
$smtpPort = '587';

$mysqli = mysqli_connect($dbhost, $dbusername, $dbpassword, $dbname, $dbport);
if (mysqli_connect_errno()){
    die("Internal Database Server error.");
}