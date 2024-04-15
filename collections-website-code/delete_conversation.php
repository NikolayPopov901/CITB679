<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "You are not logged in.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $sender = $_POST['sender'];
    $recipient = $_POST['recipient'];
    $item = $_POST['item']; // Add item parameter

    // Establish a database connection
    $con = mysqli_connect('localhost', 'root', '', 'mesaging');

    // Check the connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Output received parameters for debugging
    echo "Received parameters: sender = $username, recipient = $recipient, item = $item<br>";

    // Construct the SQL query
    $deleteQuery = "DELETE FROM messages WHERE (sender = '$username' AND recipient = '$sender' AND item = '$item') OR (sender = '$sender' AND recipient = '$username' AND item = '$item')";
    echo "SQL query: $deleteQuery<br>";

    // Execute the query
    if (mysqli_query($con, $deleteQuery)) {
        echo "Conversation deleted successfully!";
    } else {
        echo "Error deleting conversation: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);
} else {
    echo "Invalid request.";
}
?>
