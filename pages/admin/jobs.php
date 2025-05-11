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


    <title>Jobs | Admin</title>
</head>
<?php include '../includes/admin-sidebar.php'; ?>

<body>

    <div class="content" id="main-content">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="styles/jobs.css">
        <div class="container-fluid">
            <div class="header">
                <h1 class="my-4">Manage Job Listings</h1>
                <a href="" class="view-applicants-btn"> <img class="plus-btn" src="../assets/images/external-link.svg"
                        alt="">View
                    Applications</a>
            </div>
            <div class="header-btns"> <a href="add-job.php" class="add-job-btn"> <img class="plus-btn"
                        src="../assets/images/plus.svg" alt=""> Add
                    New Job</a></div>

            <div class="table-jobs">
                <div class="table-responsive">
                    <table id="jobTable" class="table datatable table-striped table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Image</th>
                                <th>Job Title</th>
                                <th>Location</th>
                                <th>Job Code</th>
                                <th>Availability</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM jobs";
                            $result = mysqli_query($conn, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td><img class ='tbl-img' src='../assets/images/jobs_bin/" . $row['img'] . "' alt='Job Image'></td>";
                                echo "<td>" . $row['title'] . "</td>";
                                echo "<td>" . $row['country'] . "</td>";
                                echo "<td>" . $row['job_code'] . "</td>";
                                echo "<td>" . $row['availability'] . "</td>";
                                echo "<td>
                                <div class='action-btns'>
                                    <a target='_blank' href='../job-details.php?id=" . $row['job_code'] . "' class='btn btn-info btn-sm action-btn'>
                                        <img src='../assets/images/view-icon.svg' alt='View Icon'> <span>View</span>
                                    </a>
                                    <a href='edit-job.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm action-btn'>
                                        <img src='../assets/images/edit-icon.svg' alt='Edit Icon'> <span>Edit</span>
                                    </a>
                                    <a href='delete-job.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm action-btn'>
                                        <img src='../assets/images/delete-icon.svg' alt='Delete Icon'> <span>Delete</span>
                                    </a>
                                </div>
                                </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
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
            $('#jobTable').DataTable({
                ordering: true,
                searching: true,
                paging: true,
                responsive: true
            });
        });
    </script>
</body>

</html>