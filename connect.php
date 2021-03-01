<?php
$hostname = "localhost";
$username = "innovate_admin";
$password = "admin";
$db_name = "innovate_training";
$db_connect = "";

$db_connect = mysqli_connect($hostname, $username, $password, $db_name);

if (!$db_connect) {
    die("Connection Failed" . mysqli_connect_error($db_connect));
}
?>