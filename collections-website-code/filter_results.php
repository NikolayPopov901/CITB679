<?php
// filter_results.php

// Connect to the search database
$searchDB = mysqli_connect('localhost', 'root', '', 'search');
if (!$searchDB) {
    die('Could not connect to the search database: ' . mysqli_connect_error());
}

// Fetch filtered results based on the selected category
$selectedCategory = $_GET['category'];

$filterQuery = "SELECT * FROM searchdata";
if (!empty($selectedCategory)) {
    $filterQuery .= " WHERE category = '$selectedCategory'";
}

$filterResults = mysqli_query($searchDB, $filterQuery);
$filteredData = array();

while ($row = mysqli_fetch_assoc($filterResults)) {
    $filteredData[] = $row;
}

// Close the search database connection
mysqli_close($searchDB);

// Return JSON-encoded data
header('Content-Type: application/json');
echo json_encode($filteredData);
?>
