<?php
$hostname = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "login_register";

$conn = mysqli_connect($hostname, $dbuser, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: ");
}



?>
