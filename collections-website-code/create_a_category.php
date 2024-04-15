<?php

session_start();

$con = mysqli_connect('127.0.0.1', 'root');

mysqli_select_db($con, 'search');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['category']);

    // Check if the category already exists
    $checkDuplicateQuery = "SELECT * FROM category_table WHERE name = '$name'";
    $duplicateResult = mysqli_query($con, $checkDuplicateQuery);

    if (mysqli_num_rows($duplicateResult) > 0) {
        $_SESSION['error_message'] = "Error: Category '$name' already exists.";
        header('location:create_category.php');
        exit(); // Stop execution to prevent inserting a duplicate
    }

    // Insert the category if it doesn't already exist
    $insertQuery = "INSERT INTO category_table(name) VALUES ('$name')";
    $result = mysqli_query($con, $insertQuery);

    if ($result) {
        $_SESSION['success_message'] = "Category '$name' created successfully.";
    } else {
        $_SESSION['error_message'] = "Error: " . mysqli_error($con);
    }

    header('location:create_category.php');
} else {
    // Redirect to the create_category.php page if accessed without POST method
    header('location:create_category.php');
    exit(); // Stop execution
}
?>

