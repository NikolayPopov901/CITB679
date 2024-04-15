<!DOCTYPE html>
<html lang="en">
<head>
    <title>Inbox</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="inbox.css">

    <style>
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<h1>Inbox</h1>

<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo "<p>You are not logged in.</p>";
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submitReply'])) {
        $replyMessage = $_POST['replyMessage'];
        $originalSender = $_POST['originalSender'];
        $recipient = $_POST['recipient'];
        $originalItem = $_POST['originalItem'];

        // Add "RE:" to the subject of the reply
        $replySubject = "RE: " . $originalItem;

        $con = mysqli_connect('localhost', 'root', '', 'mesaging');
        $reply = "INSERT INTO messages (sender, recipient, item, message) VALUES ('$username', '$originalSender', '$replySubject', '$replyMessage')";
        mysqli_query($con, $reply);

        // Fetch all messages exchanged between two users
        $allMessages = fetchAllMessages($username, $originalSender);

        // Display popup with messages
        echo "<div id='popup' class='popup'>Reply sent. Redirecting you back...</div>";
        echo "<script>setTimeout(function(){ location.href = 'inbox.php'; }, 2000);</script>";
        exit();
    }
}

function fetchAllMessages($user1, $user2) {
    $con = mysqli_connect('localhost', 'root', '', 'mesaging');
    $sql = "SELECT * FROM messages WHERE (sender = '$user1' AND recipient = '$user2') OR (sender = '$user2' AND recipient = '$user1') ORDER BY timestamp ASC";
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
    return $messages;
}

$con = mysqli_connect('localhost', 'root', '', 'mesaging');
$sql = "SELECT * FROM messages WHERE recipient = '$username' ORDER BY timestamp DESC";
$results = mysqli_query($con, $sql);

if (mysqli_num_rows($results) > 0) {
    echo "<table>
                <tr>
                    <th>Sender</th>
                    <th>Recipient</th>
                    <th>Message</th>
                    <th>Item</th>
                    <th>Timestamp</th>
                </tr>";
    while ($row = mysqli_fetch_assoc($results)) {
        echo "<tr>
                <td>" . $row['sender'] . "</td>
                <td>" . $row['recipient'] . "</td>
                <td>" . $row['message'] . "</td>
                <td>" . $row['item'] . "</td>
                <td>" . $row['timestamp'] . "</td>
                <td>
                    <button class='show-form-button' onclick='toggleReplyForm(this)'>Reply</button>
                    <button class='show-history-button' onclick='showMessageHistory(\"" . $row['sender'] . "\", \"" . $row['recipient'] . "\")'>Show History</button>
                    <button class='delete-button' onclick='deleteConversation(\"" . $row['sender'] . "\", \"" . $row['recipient'] . "\", \"" . $row['item'] . "\")'>Delete</button>
                    <button id='hideHistoryButton' onclick='hideMessageHistory()'>Hide History</button>
                    <form class='reply-form' method='post' action=''>
                        <textarea name='replyMessage' placeholder='Enter your reply'></textarea>
                        <input type='hidden' name='originalSender' value='" . $row['sender'] . "'>
                        <input type='hidden' name='recipient' value='" . $row['recipient'] . "'>
                        <input type='hidden' name='originalItem' value='" . $row['item'] . "'>
                        <button class='reply-button' type='submit' name='submitReply'>Send</button>
                        <button class='cancel-button' type='button' onclick='cancelReplyForm(this)'>Cancel</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No messages found.</p>";
}

mysqli_close($con);
?>

<script>
    function deleteConversation(sender, recipient, item) {
        if (confirm('Are you sure you want to delete this conversation?')) {
            $.ajax({
                type: 'POST',
                url: 'delete_conversation.php',
                data: {
                    sender: sender,
                    recipient: recipient,
                    item: item // Include item name in the data sent to delete_conversation.php
                },
                success: function (data) {
                    alert('Conversation deleted successfully!');
                    location.reload(); // Reload the page
                    // You may choose to reload the page or update the UI as needed.
                },
                error: function () {
                    alert('Error deleting conversation');
                }
            });
        }
    }



    function toggleReplyForm(button) {
        var form = button.parentNode.querySelector('.reply-form');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    function cancelReplyForm(button) {
        var form = button.parentNode;
        form.style.display = 'none';
    }

    // Show success message and redirect back to inbox after 2 seconds
    function showMessagePopup(messages) {
        var popupContainer = document.createElement('div');
        popupContainer.classList.add('popup-container');

        var popupContent = document.createElement('div');
        popupContent.classList.add('popup-content');

        var closeButton = document.createElement('span');
        closeButton.classList.add('close-button');
        closeButton.innerHTML = '&times;';
        closeButton.onclick = function () {
            popupContainer.style.display = 'none';
            window.location.href = 'inbox.php'; // Redirect here
        };

        popupContent.appendChild(closeButton);

        var messageList = document.createElement('ul');
        messageList.classList.add('message-list');

        messages.forEach(function (message) {
            var listItem = document.createElement('li');
            listItem.textContent = message.sender + ': ' + message.message + ' (' + message.timestamp + ')';
            messageList.appendChild(listItem);
        });

        popupContent.appendChild(messageList);
        popupContainer.appendChild(popupContent);

        document.body.appendChild(popupContainer);
        popupContainer.style.display = 'block';
    }

    // Show message history in a table
    function showMessageHistory(sender, recipient) {
        $.ajax({
            type: 'POST',
            url: 'fetch_message_history.php',
            data: { sender: sender, recipient: recipient },
            success: function (data) {
                var history = JSON.parse(data);
                showHistoryTable(history);
            },
            error: function () {
                alert('Error fetching message history');
            }
        });
    }

    // Check if popup exists and show it
    var popup = document.getElementById('popup');
    if (popup) {
        showPopup();
    }

    // Display message history in a table
    function showHistoryTable(history) {
        // Remove existing message history table if it exists
        var existingTable = document.getElementById('messageHistoryTable');
        if (existingTable) {
            existingTable.remove();
        }

        var historyBanner = document.createElement('div');
        historyBanner.id = 'messageHistoryBanner';
        historyBanner.textContent = 'Message History';
        document.body.appendChild(historyBanner);

        var table = document.createElement('table');
        table.id = 'messageHistoryTable';

        var header = table.createTHead();
        var row = header.insertRow(0);
        var cell1 = row.insertCell(0);
        var cell2 = row.insertCell(1);
        var cell3 = row.insertCell(2);

        cell1.innerHTML = '<b>Sender</b>';
        cell2.innerHTML = '<b>Message</b>';
        cell3.innerHTML = '<b>Timestamp</b>';

        var tbody = table.createTBody();

        history.forEach(function (message) {
            var row = tbody.insertRow(-1);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);

            cell1.textContent = message.sender;
            cell2.textContent = message.message;
            cell3.textContent = message.timestamp;
        });

        document.body.appendChild(table);
    }
    function hideMessageHistory() {
        var historyContainer = document.getElementById('messageHistoryTable');
        historyContainer.style.display = 'none';
        var historyBanner = document.getElementById('messageHistoryBanner');
        historyBanner.style.display = 'none';
    }
</script>
</body>
</html>
