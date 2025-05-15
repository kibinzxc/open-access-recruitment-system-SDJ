<?php
include("../includes/authenticate.php");
$id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sweet Dream Job - Your dream job awaits!">
    <meta name="keywords" content="job, career, dream job, employment, opportunities">
    <link rel="icon" href="../assets/images/icon.svg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <title>Settings | Admin</title>
</head>
<?php include '../includes/admin-sidebar.php'; ?>

<body>
    <?php
    if (isset($_GET['success'])) {
        echo '<div class="alert alert-success" id="alert-message">' . htmlspecialchars($_GET['success']) . '</div>';
    }

    if (isset($_GET['error'])) {
        echo '<div class="alert alert-danger" id="alert-message">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>

    <div class="content" id="main-content">
        <!-- Add Account Modal -->
        <div class="modal fade" id="addAccountModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="addAccountForm" method="POST" action="add-account.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Account</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label>Confirm Password</label>
                                <input type="text" class="form-control" name="confirm_password" required>
                            </div>
                            <div id="addAccountError" class="text-danger small"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Password Modal -->
        <div class="modal fade" id="updatePasswordModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="updatePasswordForm" method="POST" action="update-password.php">
                        <div class="modal-header">
                            <h5 class="modal-title">Update Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Old Password</label>
                                <input type="text" class="form-control" name="old_password" required>
                            </div>
                            <div class="mb-3">
                                <label>New Password</label>
                                <input type="text" class="form-control" name="new_password" required>
                            </div>
                            <div class="mb-3">
                                <label>Confirm New Password</label>
                                <input type="text" class="form-control" name="confirm_new_password" required>
                            </div>
                            <div id="updatePasswordError" class="text-danger small"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-warning">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="styles/settings.css">
        <div class="container-fluid">
            <div class="header">

                <h1 class="my-4">Settings</h1>
            </div>
            <!-- <p class="subheadline">All settings related to the application</p> -->

            <div class="table-settings">

                <div class="header-btns">
                    <h4 class="table-title">Account Management</h4>
                    <div class="group-btns">
                        <button class="create-acc-btn" data-bs-toggle="modal" data-bs-target="#addAccountModal">
                            <img class="plus-btn" src="../assets/images/plus.svg" alt=""> Create New Account
                        </button>

                        <button class="create-acc-btn" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">
                            <img class="plus-btn" src="../assets/images/white-edit.svg" alt=""> Update Password
                        </button>
                    </div>

                </div>
                <div class="table-responsive">
                    <table id="accTable" class="table datatable table-striped table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM users";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . $row["name"] . "</td>";
                                echo "<td>" . $row['account_type'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="table-settings space-top">

                <div class="header-btns">
                    <h4 class="table-title">Company Details</h4> <a href="update-company-details.php"
                        class="create-acc-btn"> <img class="plus-btn" src="../assets/images/white-edit.svg" alt="">
                        Update</a>
                </div>
                <div class="table-responsive">
                    <?php
                    $query = "SELECT * FROM company_details";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        echo "<form>";
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='mb-3'>";
                            echo "<label class='form-label'>" . htmlspecialchars($row['category_name']) . "</label>";
                            echo "<textarea class='form-control' style='resize: none;' readonly>" . htmlspecialchars($row['details']) . "</textarea>";
                            echo "</div>";
                        }
                        echo "</form>";
                    } else {
                        echo "<p>No company details found.</p>";
                    }
                    ?>
                </div>
            </div>



        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#accTable').DataTable({
            ordering: true,
            searching: true,
            paging: true,
            responsive: true
        });
    });
    </script>



    <script>
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    document.getElementById("addAccountForm").addEventListener("submit", function(e) {
        const form = e.target;
        const password = form.password.value;
        const confirm = form.confirm_password.value;
        const errorDiv = document.getElementById("addAccountError");

        if (!passwordRegex.test(password)) {
            e.preventDefault();
            errorDiv.textContent =
                "Password must be at least 8 characters, include uppercase, lowercase, number, and special character.";
            return;
        }

        if (password !== confirm) {
            e.preventDefault();
            errorDiv.textContent = "Passwords do not match.";
            return;
        }
    });

    document.getElementById("updatePasswordForm").addEventListener("submit", function(e) {
        const form = e.target;
        const newPass = form.new_password.value;
        const confirm = form.confirm_new_password.value;
        const errorDiv = document.getElementById("updatePasswordError");

        if (!passwordRegex.test(newPass)) {
            e.preventDefault();
            errorDiv.textContent =
                "Password must be at least 8 characters, include uppercase, lowercase, number, and special character.";
            return;
        }

        if (newPass !== confirm) {
            e.preventDefault();
            errorDiv.textContent = "New passwords do not match.";
            return;
        }
    });
    </script>
    <script>
    // Automatically hide the alert message after 5 seconds
    setTimeout(() => {
        const alertMessage = document.getElementById('alert-message');
        if (alertMessage) {
            alertMessage.style.transition = 'opacity 0.5s ease';
            alertMessage.style.opacity = '0';
            setTimeout(() => alertMessage.remove(), 500); // Remove the element after fading out
        }
    }, 1000);
    </script>
</body>

</html>