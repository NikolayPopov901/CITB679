<?php
session_start();
$con = mysqli_connect('localhost', 'root');
mysqli_select_db($con, 'registration');

$name2 = $_POST['name_del'];

$s = "SELECT * FROM users WHERE name = '$name2'";
$result = mysqli_query($con, $s);
$num = mysqli_num_rows($result);

if ($num == 0) {
    echo "failed";
} else {
    $del = "DELETE FROM users WHERE name = '$name2'";
    if (mysqli_query($con, $del)) {
        echo "success";
    } else {
        echo "failed2";
    }
}
?>
