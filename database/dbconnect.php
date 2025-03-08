<?php

date_default_timezone_set('Asia/Kolkata');
$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "user_auth_php";

$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if(!$conn){
    die('Something went wrong');
}

?>