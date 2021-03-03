<?php
//Common php script to check whether the user is logged in before loading content
if (isset($_COOKIE["session_username"]) && isset($_COOKIE["session_password"])) {
    //Retrive cookies to check
    $cookie_username = $_COOKIE["session_username"];
    $cookie_password = $_COOKIE["session_password"];

    //Retrive database user entry
    $sql = "SELECT * FROM users WHERE username='" . $cookie_username . "'";
    $result = mysqli_query($db_connect, $sql);

    //Checking if the user exist
    if (mysqli_num_rows($result) > 0) {
        //user exist, get array and start checking
        $row = mysqli_fetch_assoc($result);
        if ($row["password"] != $cookie_password || $row["username"] != $cookie_username) {
            //If the details doesnt match, wipe cookies and return to login page with error message
            setcookie("session_username", "", time() - 3600);
            setcookie("session_password", "", time() - 3600);
            header("Location: ./admin_login.php?error-text=Invaild session. Please login again");
        }
    } else {
        //User does not exist, redirect to login page with error message
        header("Location: ./admin_login.php?error-text=Invaild session. Please login again");
    }
} else {
    //If cookie does not exist, return to login page with error message
    header("Location: ./admin_login.php?error-text=Please login to access the page");
}
?>