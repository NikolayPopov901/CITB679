<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style_register.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="container">
    <div class="login-box">
        <div class="row">
            <div class="col-md-6 registration-right">
                <h2> Register here</h2>
                <form id="registration-form" method="post">
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="user" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Password must contain at least 8 characters including at least one uppercase letter, one lowercase letter, and one digit.">
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Please enter a valid email">
                    </div>
                    <button type="submit" class="btn btn-primary"> Register</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Registration form submission
        $('#registration-form').submit(function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            $.ajax({
                url: 'registration.php',
                type: 'post',
                data: $(this).serialize(),
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Registration successful!',
                            text: 'You are now registered.',
                        }).then(() => {
                            window.location.href = 'login.php';
                        });
                    } else if (response === 'taken') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Username already taken!',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Registration failed!',
                        });
                    }
                }
            });
        });
    });
</script>

</body>
</html>
