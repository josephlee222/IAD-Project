<?php
//Connection details
$hostname = "localhost";
$username = "innovate_admin";
$password = "admin";
$db_name = "innovate_training";
$db_connect = "";

//Connect to the database
$db_connect = mysqli_connect($hostname, $username, $password, $db_name);

if (!$db_connect) {
    //In case mySQL connection failed
    die("Connection Failed" . mysqli_connect_error($db_connect));
}
?>