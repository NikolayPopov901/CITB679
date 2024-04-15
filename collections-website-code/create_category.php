<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Deletion</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="style_category.css">
</head>
<body>
<div class="container">
    <div class="login-box">
        <div class="row">
            <div class="col-md-6 login-left">
                <h2>Create Category</h2>

                <!-- Display success message using Bootstrap Modal -->
                <?php
                session_start();

                if (isset($_SESSION['success_message'])) {
                    echo '<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ' . $_SESSION['success_message'] . '
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>';
                    echo '<script>var successModal = new bootstrap.Modal(document.getElementById("successModal")); successModal.show();</script>';
                    unset($_SESSION['success_message']); // Clear the message after displaying
                }
                ?>

                <!-- Display error message using Bootstrap Modal -->
                <?php
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ' . $_SESSION['error_message'] . '
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>';
                    echo '<script>var errorModal = new bootstrap.Modal(document.getElementById("errorModal")); errorModal.show();</script>';
                    unset($_SESSION['error_message']); // Clear the message after displaying
                }
                ?>

                <form action="create_a_category.php" method="post">
                    <div class="form-group">
                        <label>Product Category Name</label>
                        <input type="text" class="form-control" id="category" name="category">
                    </div>
                    <div class="button-group">
                        <button type="submit" name="create_category" class="btn btn-primary">Create Category</button>
                        <a href="home_admin.php" class="btn btn-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</body>
</html>
