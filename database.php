<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "foster_care";
$conn = mysqli_connect($hostName, $dbUser, $dbPassword, $dbName);
if (!$conn) {
    die("Something went wrong;");
}

?>