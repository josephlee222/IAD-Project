<?php
if (isset($_COOKIE["session_username"]) && isset($_COOKIE["session_password"])) {
    $cookie_username = $_COOKIE["session_username"];
    $cookie_password = $_COOKIE["session_password"];

    $sql = "SELECT * FROM users WHERE username='" . $cookie_username . "'";
    $result = mysqli_query($db_connect, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if ($row["password"] != $cookie_password || $row["username"] != $cookie_username) {
            header("Location: ./admin_login.php?error-text=Invaild session. Please login again");
        }
    } else {
        header("Location: ./admin_login.php?error-text=Invaild session. Please login again");
    }


} else {
    header("Location: ./admin_login.php?error-text=Please login to access the page");
}
?>