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

    <title>Jobs | Admin</title>
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
        <!-- Add Job Modal -->
        <div class="modal fade" id="addJobModal" tabindex="-1" aria-labelledby="addJobModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <form id="addJobForm" action="add-job.php" method="POST" enctype="multipart/form-data"
                    class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addJobModalLabel">Add New Job</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="jobTitle" class="form-label">Job Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>


                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" class="form-control" name="country" required>
                        </div>

                        <div class="mb-3">
                            <label for="availability" class="form-label">Availability</label>
                            <select class="form-select" name="availability" required>
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="img" class="form-label">Job Image</label>
                            <input type="file" class="form-control" name="img" accept="image/*" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Job Description</label>
                            <textarea class="form-control" name="description" rows="3" required></textarea>
                        </div>

                        <!-- Responsibilities -->
                        <div class="mb-3">
                            <label class="form-label">Responsibilities</label>
                            <div class="input-group mb-2">
                                <input type="text" id="responsibilityInput" class="form-control">
                                <button type="button" class="btn btn-outline-primary"
                                    id="addResponsibilityBtn">Add</button>
                            </div>
                            <ul id="responsibilityList" class="list-group mb-2"></ul>
                            <input type="hidden" name="responsibilities" id="responsibilityJson">
                        </div>

                        <!-- Qualifications -->
                        <div class="mb-3">
                            <label class="form-label">Qualifications</label>
                            <div class="input-group mb-2">
                                <input type="text" id="qualificationInput" class="form-control">
                                <button type="button" class="btn btn-outline-primary"
                                    id="addQualificationBtn">Add</button>
                            </div>
                            <ul id="qualificationList" class="list-group mb-2"></ul>
                            <input type="hidden" name="qualifications" id="qualificationJson">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Add Job</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>

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
            <div class="header-btns"> <button class="add-job-btn" data-bs-toggle="modal" data-bs-target="#addJobModal">
                    <img class="plus-btn" src="../assets/images/plus.svg" alt=""> Add New Job
                </button></div>

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
        // Always initialize DataTable
        $('#jobTable').DataTable({
            ordering: true,
            searching: true,
            paging: true,
            responsive: true
        });

        // ✅ Always call this on initial page load
        initJobsModalLogic();

        // Also initialize when #jobsLink is clicked via AJAX
        $('#jobsLink').on('click', function(e) {
            e.preventDefault();
            $('#main-content').load('jobs.php', function() {
                initJobsModalLogic(); // For AJAX
                $('#jobTable').DataTable({
                    ordering: true,
                    searching: true,
                    paging: true,
                    responsive: true
                });
            });
        });
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