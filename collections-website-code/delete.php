<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Deletion</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style_delete.css">
</head>
<body>
<div class="container">
    <div class="login-box">
        <div class="row">
            <div class="col-md-6 login-left">
                <h2> Delete User</h2>
                <form action="delete_user.php" method="post" id="delete_user">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="name_del" class="form-control" required>
                    </div>
                    <div class="button-group">
                        <button type="submit" name="delete" class="btn btn-danger"> Delete</button>
                        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Delete user form submission
        $('#delete_user').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            // Perform AJAX request
            $.ajax({
                url: 'delete_user.php',
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    // Handle the response
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'User deleted successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        setTimeout(function() {
                            window.location.href = 'home.php';
                        }, 1500);
                    } else if (response === 'failed') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'User Does not exist'
                        });
                    } else if (response === 'failed2') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'User already deleted'
                        });
                    }
                }
            });
        });
    });
</script>
</body>
</html>
