<?php
if (isset($_FILES['image'])) {
    $file = $_FILES['image'];

    // File properties
    $fileName = $file['name'];
    $fileTmp = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = array('jpg', 'jpeg', 'png');

    // Check if the file has a valid extension
    if (in_array($fileExt, $allowedExtensions)) {
        // Check for file errors
        if ($fileError === 0) {
            // Generate a unique filename to avoid overwriting existing files
            $uniqueFileName = uniqid('', true) . '.' . $fileExt;

            // File destination path
            $destination = 'uploads/' . $uniqueFileName;

            move_uploaded_file($fileTmp, $destination);


            echo 'Image uploaded successfully!';
        } else {
            echo 'Error uploading the file.';
        }
    } else {
        echo 'Invalid file extension. Only JPG, JPEG, and PNG files are allowed.';
    }
}
?>
