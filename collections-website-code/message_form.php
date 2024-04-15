<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $sender = $_SESSION['username'];
    $recipient = $_POST['recipient'];
    $item = $_POST['item'];
    $message = $_POST['message'];

    $con = mysqli_connect("127.0.0.1", "root", "", "mesaging");
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $insertQuery = "INSERT INTO messages (sender, recipient, item, message) VALUES ('$sender', '$recipient', '$item', '$message')";
    $result = mysqli_query($con, $insertQuery);

    mysqli_close($con);

    header('Location: success.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Form</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <link href="msg.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <form class="message-form" action="message.php" method="post">
        <input type="hidden" name="recipient" value="<?php echo $_GET['recipient']; ?>">
        <input type="hidden" name="item" value="<?php echo $_GET['item']; ?>">
        <h1>Message Seller</h1>
        <label for="message">Message:</label>
        <textarea id="message" name="message"></textarea>
        <button type="submit">Send</button>
    </form>
</div>
</body>
</html>



