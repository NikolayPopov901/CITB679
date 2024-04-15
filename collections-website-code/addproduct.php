<!DOCTYPE html>
<html lang="en">
<head>
    <title>Publish Item</title>
    <link rel="stylesheet" type="text/css" href="style_test.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Post your item here</h2>
    <form action="product_addition.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="pname" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="pname" name="pname" placeholder="Product name.." required>
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Product Description</label>
            <textarea class="form-control" id="subject" name="description" placeholder="Product description.." style="height:200px" required></textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price in EUR</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Price of the item.." required>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <?php
            // Connect to database
            $con = mysqli_connect("127.0.0.1", "root", "", "search");

            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT id, name FROM category_table";
            $result = mysqli_query($con, $sql);
            ?>
            <select class="form-control" id="category" name="category" required>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="upload" class="form-label">Upload Photos</label>
            <input type="file" class="form-control" id="upload" name="upload[]" multiple>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button class="btn btn-secondary back-button" onclick="window.history.back()">Back</button>
        </div>
    </form>
</div>
</body>
</html>

