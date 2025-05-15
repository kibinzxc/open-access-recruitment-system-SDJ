<?php
include("../includes/authenticate.php");
$id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sweet Dream Job - Job Applications">
    <meta name="keywords" content="job, applications, dream job, employment">
    <link rel="icon" href="../assets/images/icon.svg" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <title>Job Applications | Admin</title>
</head>
<?php include '../includes/admin-sidebar.php'; ?>

<body>
    <div class="content" id="main-content">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="styles/inbox.css">

        <div class="container-fluid">
            <div class="header">
                <h1 class="my-4">Job Applications</h1>
                <a href="jobs.php" class="view-applicants-btn"> <img class="plus-btn"
                        src="../assets/images/external-link.svg" alt="">View
                    Jobs</a>
            </div>
            <p class="subheadline">List of all submitted job applications</p>
            <div class="table-inbox">
                <div class="table-responsive">
                    <table id="appTable" class="table datatable table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Job</th>
                                <th>Applicant Name</th>
                                <th>Email</th>
                                <th>Date Applied</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT a.app_id, a.job_code, a.f_name, a.l_name, a.email, a.date, a.status, a.attachment,
                                         j.title, j.country
                                  FROM applications a
                                  JOIN jobs j ON a.job_code = j.job_code
                                  ORDER BY a.date DESC";

                            $result = mysqli_query($conn, $query);
                            $rowCount = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $rowClass = ($row["status"] === "new") ? "new-row" : "";
                                echo "<tr class='$rowClass'>";
                                echo "<td>" . $rowCount++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['title']) . " - " . htmlspecialchars($row['country']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['l_name']) . ", " . htmlspecialchars($row['f_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . date("F j, Y g:i A", strtotime($row['date'])) . "</td>";
                                echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                                echo "<td>
                                   <div class='action-btns'>
                                     <a target='_blank' href='view-application.php?id=" . $row['app_id'] . "' class='btn btn-info btn-sm action-btn'>
                                        <img src='../assets/images/view-icon.svg' alt='View Icon'> <span>View</span>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#appTable').DataTable({
            ordering: true,
            searching: true,
            paging: true,
            responsive: true
        });
    });
    </script>
</body>

</html>