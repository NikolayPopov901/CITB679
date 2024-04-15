$(document).ready(function() {
    // Registration form submission
    $('#registration-form').submit(function(e) {
        e.preventDefault(); // Prevent the form from submitting normally

        // Perform AJAX request
        $.ajax({
            url: 'registration.php',
            type: 'post',
            data: $(this).serialize(),
            success: function(response) {
                // Handle the response
                if (response === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: