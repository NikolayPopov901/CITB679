<?php
session_start();
header('location:show_products.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selected_color = $_POST['category'];

    // Validate the input values
    $pname = $_POST['pname'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $photos = $_FILES['upload'];

    // Check if any of the required fields are empty
    if (empty($pname) || empty($description) || empty($price)) {
        // Redirect back with an error message
        $_SESSION['error_message'] = 'Please fill in all the required fields.';
        exit();
    }

    // Connect to the database
    $con = mysqli_connect("127.0.0.1", "root", "", "search");

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Retrieve the selected color name from the database
    $sql = "SELECT name FROM category_table WHERE id = $selected_color";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $selected_color_name = $row['name'];

    // Insert the data into the database
    $add = "INSERT INTO searchdata (name, description, price, date, owner, category) VALUES ('$pname', '$description', '$price', NOW(), '".$_SESSION['username']."', '$selected_color_name')";
    mysqli_query($con, $add);

    // Get the last inserted product ID
    $product_id = mysqli_insert_id($con);

    // Upload and insert photos into the database
    foreach ($photos['tmp_name'] as $key => $tmp_name) {
        $photo_name = $photos['name'][$key];
        $photo_size = $photos['size'][$key];
        $photo_type = $photos['type'][$key];
        $photo_error = $photos['error'][$key];

        if ($photo_error == 0 && is_uploaded_file($tmp_name) && ($photo_type == 'image/jpeg' || $photo_type == 'image/png')) {
            $photo_data = file_get_contents($tmp_name);
            $photo_data = mysqli_real_escape_string($con, $photo_data);

            // Insert photo data into the database
            $add_photo = "INSERT INTO photos (product_id, photo_name, photo_data, photo_type) VALUES ('$product_id', '$photo_name', '$photo_data', '$photo_type')";
            mysqli_query($con, $add_photo);
        }
    }

    // Close the database connection
    mysqli_close($con);
}
?>
