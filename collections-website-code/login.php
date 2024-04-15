<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <div class="login-box">
        <div class="row">
            <div class="col-md-6 login-left">
                <h2>Login here</h2>
                <form id="login-form" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="user" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
            </div>
            <div class="col-md-6 registration-right">
                <h2>Register here</h2>
                <p>Don't have an account? <a href="registration_page.php">Register now!</a></p>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Login form submission
        $('#login-form').submit(function(e) {
            e.preventDefault();

            // Perform AJAX request
            $.ajax({
                url: 'validation.php',
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    // Handle the response
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Login successful!',
                            text: 'You are now logged in.',
                        }).then(() => {
                            window.location.href = 'home.php';
                        });
                    } else if (response === 'success_admin') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Admin Login successful!',
                            text: 'You are now logged in as admin.',
                        }).then(() => {
                            window.location.href = 'home_admin.php';
                        });
                    } else if (response === 'banned') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Sorry...',
                            text: 'You have been banned.',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Login failed!',
                        });
                    }
                }
            });
        });
    });
</script>


</body>
</html>
