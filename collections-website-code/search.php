<?php
$con = mysqli_connect('127.0.0.1', 'root');
mysqli_select_db($con, 'search');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style_gallery.css">
</head>

<body>
<div class="container">
    <h1 class="header">Search Results:</h1>
</div>

<?php
if (isset($_GET['submit-search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $sql = "SELECT * FROM searchdata WHERE name LIKE '%$search%' OR description LIKE '%$search%'";
    $result = mysqli_query($con, $sql);
    $queryResults = mysqli_num_rows($result);

    if ($queryResults > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Fetch image data from the photos table
            $productId = $row['id'];
            $imageSQL = "SELECT photo_data FROM photos WHERE product_id = $productId";
            $imageResult = mysqli_query($con, $imageSQL);

            echo "<div class='card'>
                            <div class='card__content'>
                                <h2 class='card__title'>" . $row['name'] . "</h2>
                                <p class='card__description'>" . $row['description'] . "</p>
                                <p class='card__price'>" . $row['price'] . " EUR</p>
                                <p class='card__date'>" . $row['date'] . "</p>
                                <p class='card__owner'>" . $row['owner'] . "</p>
                                <div class='card__images'>";

            // Fetch and display images
            $imageCount = 0;
            while ($imageRow = mysqli_fetch_assoc($imageResult)) {
                $imageData = base64_encode($imageRow['photo_data']);
                $src = "data:image/jpeg;base64," . $imageData;

                echo "<img class='zoomable-image' src='$src' alt='Product Image' data-index='$imageCount'>";
                $imageCount++;
            }

            echo "</div>
                                <button class='prev-button'>Previous</button>
                                <button class='next-button'>Next</button>
                                <button class='card__button' onclick='openMessageForm(\"" . $row['owner'] . "\", \"" . $row['name'] . "\")'>Message Seller</button>
                                <button class='card__button' onclick='deleteItem(\"" . $row['name'] . "\")'>Delete Item</button>
                            </div>
                        </div>";
        }
    } else {
        echo "<p class='no-results'>No results match the keyword</p>";
    }
}
?>

<!-- Popup container -->
<div class="popup-container" id="popupContainer">
    <div class="popup-content">
        <span class="close-button" onclick="closeImagePopup()">&times;</span>
        <img class="popup-image" id="popupImage" alt="Zoomed Image">
    </div>
</div>
<div class="button-group">
    <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
</div>
<script>
    function showImage(card, index) {
        var images = card.querySelectorAll('.zoomable-image');
        images.forEach(function(image, i) {
            image.style.display = i === index ? 'block' : 'none';
        });
    }

    function navigateImages(card, direction) {
        var images = card.querySelectorAll('.zoomable-image');
        var currentIndex = -1;

        // Find the current index
        images.forEach(function(image, index) {
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

    document.addEventListener('DOMContentLoaded', function() {
        var messageButtons = document.querySelectorAll('.card__button');

        messageButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var card = button.closest('.card');
                var owner = card.querySelector('.card__owner').textContent;
                var itemName = card.querySelector('.card__title').textContent;
                openMessageForm(owner, itemName);
            });
        });

        var cards = document.querySelectorAll('.card');

        cards.forEach(function(card) {
            var prevButton = card.querySelector('.prev-button');
            var nextButton = card.querySelector('.next-button');
            var images = card.querySelectorAll('.zoomable-image');

            var currentIndex = 0;

            prevButton.addEventListener('click', function() {
                currentIndex = (currentIndex - 1 + images.length) % images.length;
                showImage(card, currentIndex);
            });

            nextButton.addEventListener('click', function() {
                currentIndex = (currentIndex + 1) % images.length;
                showImage(card, currentIndex);
            });

            images.forEach(function(image, index) {
                image.addEventListener('click', function() {
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

    function deleteItem(itemName) {
        // Your delete item logic goes here
        console.log('Delete item: ' + itemName);
    }
</script>
</body>

</html>
