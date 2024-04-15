<!DOCTYPE html>
<html lang="en">
<head>
    <title>Ban User</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style_ban.css">
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
</head>
<body>
<div class="container">
    <div class="login-box">
        <div class="row">
            <div class="col-md-6 login-left">
                <h2> Ban User</h2>
                <form action="ban_user.php" method="post" id="ban_user">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="name_ban" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary"> Ban</button>
                </form>
            </div>
            <div class="col-md-6 registration-right">
                <h2> Unban User</h2>
                <form action="unban.php" method="post" id="unban_user">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="unban" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-success"> Unban</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Ban form submission
        $('#ban_user').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            // Perform AJAX request
            $.ajax({
                url: 'ban_user.php',
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    // Handle the response
                    if (response === 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'User banned!',
                            text: 'New Password is: b44nn33dd22',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'home_admin.php';
                            }
                        });
                    } else if (response === 'failed') {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'User does not exist'
                        });
                    }
                }
            });
        });
    });
        $(document).ready(function() {
        // Unban form submission
        $('#unban_user').submit(function(e) {
            e.preventDefault();

            // Perform AJAX request
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    // Handle the response
                    if (response === 'success') {

                        Swal.fire({
                            icon: 'success',
                            title: 'User unbanned!',
                            text: 'New Password is: 123456',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else if (response === 'failed') {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'User does not exist'
                        });
                    }
                }
            });
        });
    });
</script>
</body>
</html>
