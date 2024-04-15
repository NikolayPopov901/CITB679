<?php

session_start();
$con = mysqli_connect('localhost', 'root');
mysqli_select_db($con, 'registration');

// Check if the form was submitted for banning
if (isset($_POST['name_ban'])) {
    $name2 = $_POST['name_ban'];

    // Check if the user exists
    $s = "SELECT * FROM users WHERE name = '$name2'";
    $result = mysqli_query($con, $s);
    $num = mysqli_num_rows($result);

    if ($num == 0) {
        echo "failed";
    } else {
        // Ban the user by updating their password
        $ban = "UPDATE users SET password='b44nn33dd22' WHERE name = '$name2'";
        mysqli_query($con, $ban);

        echo "success";
    }
}