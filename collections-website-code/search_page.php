<!DOCTYPE html>
<html lang="en">

<head>
    <title>Show Products</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style_search2.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
<div class="search-bar">
    <form action="search.php" method="GET">
        <input type="text" name="search" placeholder="Search products...">
        <button type="submit" name="submit-search">Search</button>
    </form>
</div>


<h1 class="title" style="color: black;">Results:</h1>
<div class="card-container">
    <?php
    $con = mysqli_connect('127.0.0.1', 'root');
    mysqli_select_db($con, 'search');
    $sql = "SELECT * FROM `searchdata`";
    $results = mysqli_query($con, $sql);
    $queryResults = mysqli_num_rows($results);

    if ($queryResults > 0) {
        while ($row = mysqli_fetch_assoc($results)) {
            echo "<div class='card'>
                    <div class='card__content'>
                        <h2 class='card__title'>" . $row['name'] . "</h2>
                        <p class='card__description'>" . $row['description'] . "</p>
                        <p class='card__price'>" . $row['price'] . " EUR</p>
                        <p class='card__date'>" . $row['date'] . "</p>
                        <p class='card__owner'>" . $row['owner'] . "</p>
                        <div class='card__images'>";

            // Fetch and display images
            $productId = $row['id'];
            $imageSQL = "SELECT photo_data, photo_type FROM photos WHERE product_id = $productId";
            $imageResult = mysqli_query($con, $imageSQL);

            $imageCount = 0;
            while ($imageRow = mysqli_fetch_assoc($imageResult)) {
                $imageType = $imageRow['photo_type'];
                $imageData = base64_encode($imageRow['photo_data']);
                $src = "data:image/" . $imageType . ";base64," . $imageData;

                echo "<img class='zoomable-image' src='$src' alt='Product Image' data-index='$imageCount'>";
                $imageCount++;
            }

            echo "</div>
                    <button class='prev-button'>Previous</button>
                    <button class='next-button'>Next</button>
                    <button class='card__button'>Message Seller</button>
                </div>
            </div>";
        }
    } else {
        echo "<p>No results found.</p>";
    }
    ?>
</div>

<!-- Popup container -->
<div class="popup-container" id="popupContainer">
    <div class="popup-content">
        <span class="close-button" onclick="closeImagePopup()">&times;</span>
        <img class="popup-image" id="popupImage" alt="Zoomed Image">
    </div>
</div>
<div class="button-group">
    <a href="javascript:history.back()" class="btn btn-secondary back-button">Back</a>
</div>

<!-- Include your JavaScript code or links to scripts here -->
<script>
    function showImage(card, index) {
        var images = card.querySelectorAll('.zoomable-image');
        images.forEach(function (image, i) {
            image.style.display = i === index ? 'block' : 'none';
        });
    }

    function navigateImages(card, direction) {
        var images = card.querySelectorAll('.zoomable-image');
        var currentIndex = -1;

        // Find the current index
        images.forEach(function (image, index) {
            if (image.style.display === 'block') {
                currentIndex = index;
            }
        });

        if (currentIndex === -1) {
            currentIndex = 0; // Default to the first image
        }

        var newIndex = currentIndex + direction;

        if (newIndex >= 0 && newIndex < images.length) {
            showImage(card, newIndex);
        }
    }

    function openMessageForm(owner, itemName) {
        window.location.href = 'message_form.php?recipient=' + owner + '&item=' + itemName;
    }

    document.addEventListener('DOMContentLoaded', function () {
        var messageButtons = document.querySelectorAll('.card__button');

        messageButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var card = button.closest('.card');
                var owner = card.querySelector('.card__owner').textContent;
                var itemName = card.querySelector('.card__title').textContent;
                openMessageForm(owner, itemName);
            });
        });

        var cards = document.querySelectorAll('.card');

        cards.forEach(function (card) {
            var prevButton = card.querySelector('.prev-button');
            var nextButton = card.querySelector('.next-button');
            var images = card.querySelectorAll('.zoomable-image');

            var currentIndex = 0;

            prevButton.addEventListener('click', function () {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(card, currentIndex);
            });

            nextButton.addEventListener('click', function () {
                currentIndex = (currentIndex + 1) % images.length;
                showImage(card, currentIndex);
            });

            images.forEach(function (image, index) {
                image.addEventListener('click', function () {
                    openImagePopup(image.src);
                });
            });
        });
    });

    function openImagePopup(src) {
        var popupContainer = document.getElementById('popupContainer');
        var popupImage = document.getElementById('popupImage');
        popupImage.src = src;
        popupContainer.style.display = 'flex';
    }

    function closeImagePopup() {
        var popupContainer = document.getElementById('popupContainer');
        popupContainer.style.display = 'none';
    }
</script>

</body>

</html>

