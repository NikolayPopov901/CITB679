<?php
session_start();

if (isset($_POST['sender']) && isset($_POST['recipient'])) {
    $sender = $_POST['sender'];
    $recipient = $_POST['recipient'];

    // Fetch message history between sender and recipient
    $con = mysqli_connect('localhost', 'root', '', 'mesaging');
    $sql = "SELECT * FROM messages WHERE (sender = '$sender' AND recipient = '$recipient') OR (sender = '$recipient' AND recipient = '$sender') ORDER BY timestamp DESC ";
    $result = mysqli_query($con, $sql);
    $messages = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $messages[] = array(
            'sender' => $row['sender'],
            'message' => $row['message'],
            'timestamp' => $row['timestamp']
        );
    }

    mysqli_close($con);

    // Return JSON response
    echo json_encode($messages);
} else {
    echo 'Invalid parameters';
}
?>
