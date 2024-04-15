<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $recipient = $_POST['recipient'];
    $item = $_POST['item'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $sender = $_SESSION['username'];

    $messageDB = mysqli_connect('localhost', 'root', '', 'mesaging');
    if (!$messageDB) {
        die('Could not connect to the messaging database: ' . mysqli_connect_error());
    }

    $insertSQL = "INSERT INTO messages (recipient, item, subject, message, sender) VALUES ('$recipient', '$item', '$subject', '$message', '$sender')";
    if (mysqli_query($messageDB, $insertSQL)) {
        $insertedID = mysqli_insert_id($messageDB);

        header("Location: success.php?id=$insertedID");
        exit();
    } else {
        header('Location: error.php');
        exit();
    }

    mysqli_close($messageDB);
} else {
    header('Location: error.php');
    exit();
}
?>