<?php
session_start();
$con = mysqli_connect('localhost', 'root');
mysqli_select_db($con, 'registration');

$name = $_POST['user'];
$pass = $_POST['password'];

// Check if the entered username and password match those of a banned user
$banned_query = "SELECT * FROM users WHERE name = '$name' AND password = 'b44nn33dd22'";
$banned_result = mysqli_query($con, $banned_query);

if (mysqli_num_rows($banned_result) > 0) {
    echo "banned";
} else {
    // Normal login process
    $s = "SELECT * FROM users WHERE name = '$name' AND password = '$pass'";
    $result = mysqli_query($con, $s);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $row['name'];
        if ($_SESSION['username'] == 'admin') {
            echo "success_admin";
        } else {
            echo "success";
        }
    } else {
        echo "failed";
    }
}
