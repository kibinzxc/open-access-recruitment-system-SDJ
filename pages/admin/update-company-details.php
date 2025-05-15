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

    <div class="content" id="main-content">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="styles/settings.css">
        <div class="container-fluid">
            <div class="header">

                <h1 class="my-4">Update Company Details</h1>
            </div>
            <!-- <p class="subheadline">All settings related to the application</p> -->

            <div class="table-settings space-top">
                <div class="table-responsive">
                    <?php
                    $query = "SELECT * FROM company_details";
                    $result = mysqli_query($conn, $query);
                    if (mysqli_num_rows($result) > 0) {
                        echo '<form action="update-company.php" method="POST">';
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<div class='mb-3'>";
                            echo "<label class='form-label'>" . htmlspecialchars($row['category_name']) . "</label>";
                            echo "<textarea class='form-control' name='details[" . $row['id'] . "]' rows='4' required>" . htmlspecialchars($row['details']) . "</textarea>";
                            echo "</div>";
                        }
                        echo '<button type="submit" class="btn btn-primary">Save Changes</button>';
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


</body>

</html>