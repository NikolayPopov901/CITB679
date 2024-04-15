<?php
session_start();
?>

<html>
<head>
    <title> Home Page</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style_home.css"
</head>
<body>

<form action="delete.php">
    <input type="submit" class="btn" value="Delete User" />
</form>
<form action="ban.php">
    <input type="submit" class="btn" value="Ban/Unban User" />
</form>
<form action="create_category.php">
    <input type="submit" class="btn" value="Create Category" />
</form>
<form action="addproduct.php">
    <input type="submit" class="btn" value="Add a new Product" />
</form>
<form action="search_a_page.php">
    <input type="submit" class="btn" value="View All Products" />
</form>
<form action="view_activities.php">
    <input type="submit" class="btn" value="View User Activity" />
</form>
<form action="inbox.php">
    <input type="submit" class="btn" value="Inbox" />
</form>
<form action="logout.php">
    <input type="submit" class="btn" value="Logout" />
</form>

</body>
</html>
