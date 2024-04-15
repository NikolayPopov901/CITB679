<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page or any other appropriate action
    header('Location: login.php');
    exit();
}

// Check if the item ID is provided in the POST data
if (!isset($_POST['item_id'])) {
    // Handle the case where item ID is not provided
    echo "Error: Item ID is missing.";
    exit();
}

// Your database connection code
$con = mysqli_connect("127.0.0.1", "root", "", "search");

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Sanitize and get the item ID
$itemId = mysqli_real_escape_string($con, $_POST['item_id']);

// Perform the delete operation
$deleteSql = "DELETE FROM searchdata WHERE id = '$itemId'";
$result = mysqli_query($con, $deleteSql);

// Check for query success
if ($result) {
    echo "Item deleted successfully.";
} else {
    echo "Error: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);
?>
