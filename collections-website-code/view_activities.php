<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Page</title>
    <link rel="stylesheet" type="text/css" href="style_search_page.css">
</head>

<body>
<div class="container-bg">
    <div class="container">
        <h1>Search Page:</h1>
        <form action="view_activities.php" method="POST">
            <div class="search-container">
                <input type="text" placeholder="Search for products..." name="uname" required>
                <button type="submit" name="submit-search">Search</button>
            </div>
        </form>
        <div class="card">
            <button class="back-button" onclick="history.back()">Back</button>
            <?php
            if (isset($_POST['submit-search'])) {
                $con = mysqli_connect('127.0.0.1', 'root');
                mysqli_select_db($con, 'search');

                $search = mysqli_real_escape_string($con, $_POST['uname']);
                $sql = "SELECT * FROM searchdata WHERE owner LIKE '%$search%'";
                $result = mysqli_query($con, $sql);
                $queryResults = mysqli_num_rows($result);
                if ($queryResults > 0) {
                    echo "<table class='result-table'>";
                    echo "<thead><tr>";
                    echo "<th>Name of Product</th>";
                    echo "<th>Price</th>";
                    echo "<th>Photo</th>";
                    echo "<th>Date</th>";
                    echo "<th>Category</th>";
                    echo "</tr></thead>";
                    echo "<tbody>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>€" . $row["price"] . "</td>";

                        // Fetch and display only the first photo
                        $productId = $row['id'];
                        $imageSQL = "SELECT photo_data, photo_type FROM photos WHERE product_id = $productId LIMIT 1";
                        $imageResult = mysqli_query($con, $imageSQL);

                        if ($imageRow = mysqli_fetch_assoc($imageResult)) {
                            $imageType = $imageRow['photo_type'];
                            $imageData = base64_encode($imageRow['photo_data']);
                            $src = "data:image/" . $imageType . ";base64," . $imageData;

                            echo "<td><img src='$src' style='max-width:60px; max-height:80px;'></td>";
                        } else {
                            echo "<td>No photo available</td>";
                        }

                        echo "<td>" . $row["date"] . "</td>";
                        echo "<td>" . $row["category"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    echo "<p class='no-results'>No results found.</p>";
                }
            }
            ?>
        </div>
    </div>
</div>
</body>

</html>
