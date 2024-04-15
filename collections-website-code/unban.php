<?php

session_start();
$con = mysqli_connect('localhost','root');

mysqli_select_db($con, 'registration' );

$name2 = $_POST['unban'];

$s = "select * from users where name = '$name2'";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);

// Check if the form was submitted for unbanning
if (isset($_POST['unban'])) {
    $name2 = $_POST['unban'];

    // Check if the user exists
    $s = "SELECT * FROM users WHERE name = '$name2'";
    $result = mysqli_query($con, $s);
    $num = mysqli_num_rows($result);

    if ($num == 0) {
        echo "failed";
    } else {
        // Unban the user by resetting their password
        $unban = "UPDATE users SET password='123456' WHERE name = '$name2'";
        mysqli_query($con, $unban);

        echo "success";
    }
}

