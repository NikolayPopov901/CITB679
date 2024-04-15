<!DOCTYPE html>
<html>
<head>
    <title>Error</title>
    <meta http-equiv="refresh" content="2; URL=search_page.php">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="style_error.css">
    <style>
    </style>
</head>
<body>
<div class="error-message">
    <h1>An error occurred while sending the message.</h1>
    <p>You will be redirected back to the search page in 2 seconds...</p>
</div>
<button class="back-button" onclick="goBack()">Back</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>
