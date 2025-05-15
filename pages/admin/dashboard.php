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

    <title>Dashboard | Admin</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

</head>
<?php include '../includes/admin-sidebar.php'; ?>

<body>

    <div class="content" id="main-content">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="styles/dashboard.css">
        <div class="container-fluid">
            <div class="header">
                <?php
                $query = "SELECT name FROM users WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $name = $row['name'] ?? 'User';
                ?>
                <h1 class="my-4">Welcome, <?php echo htmlspecialchars($name); ?> 👋</h1>
            </div>
            <div class="dashboard-cards-container">
                <a href="jobs.php?status=open" class="dashboard-card-link">
                    <div class="dashboard-card">
                        <div class="dashboard-card-content">
                            <div class="dashboard-card-header">
                                <h3 class="dashboard-card-title">Open Jobs</h3>
                                <img src="../assets/images/admin-jobs.svg" alt="Users Icon" class="dashboard-card-icon">
                            </div>
                            <?php
                            $query = "SELECT COUNT(*) AS open_jobs FROM jobs WHERE availability = 'open'";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $openJobs = $row['open_jobs'] ?? 0;
                            ?>
                            <div class="dashboard-card-value"><?php echo htmlspecialchars($openJobs); ?></div>
                        </div>
                        <div class="dashboard-card-footer" data-timestamp="<?php echo time(); ?>"></div>
                    </div>
                </a>

                <a href="jobs.php" class="dashboard-card-link">
                    <div class="dashboard-card">
                        <div class="dashboard-card-content">
                            <div class="dashboard-card-header">
                                <h3 class="dashboard-card-title">Total Jobs Listed</h3>
                                <img src="../assets/images/dashboard-total.svg" alt="" class="dashboard-card-icon">
                            </div>
                            <?php
                            $query = "SELECT COUNT(*) AS total_jobs FROM jobs";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $totalJobs = $row['total_jobs'] ?? 0;
                            ?>
                            <div class="dashboard-card-value"><?php echo htmlspecialchars($totalJobs); ?></div>
                        </div>
                        <div class="dashboard-card-footer" data-timestamp="<?php echo time(); ?>"></div>
                    </div>
                </a>

                <a href="applications.php" class="dashboard-card-link">
                    <div class="dashboard-card">
                        <div class="dashboard-card-content">
                            <div class="dashboard-card-header">
                                <h3 class="dashboard-card-title">Received Applications</h3>
                                <img src="../assets/images/dashboard-applications.svg" alt=""
                                    class="dashboard-card-icon">
                            </div>
                            <?php
                            $query = "SELECT COUNT(*) AS total_applications FROM applications";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $totalApplications = $row['total_applications'] ?? 0;
                            ?>
                            <div class="dashboard-card-value"><?php echo htmlspecialchars($totalApplications); ?></div>
                        </div>
                        <div class="dashboard-card-footer" data-timestamp="<?php echo time(); ?>"></div>
                    </div>
                </a>

                <a href="inbox.php" class="dashboard-card-link">
                    <div class="dashboard-card">
                        <div class="dashboard-card-content">
                            <div class="dashboard-card-header">
                                <h3 class="dashboard-card-title">Unread Messages</h3>
                                <img src="../assets/images/admin-inbox.svg" alt="" class="dashboard-card-icon">
                            </div>
                            <?php
                            $query = "SELECT COUNT(*) AS total_messages FROM messages where status = 'unread'";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();
                            $totalMessages = $row['total_messages'] ?? 0;
                            ?>
                            <div class="dashboard-card-value"><?php echo htmlspecialchars($totalMessages); ?></div>
                        </div>
                        <div class="dashboard-card-footer" data-timestamp="<?php echo time(); ?>"></div>
                    </div>
                </a>
            </div>
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
        $('#msgTable').DataTable({
            ordering: true,
            searching: true,
            paging: true,
            responsive: true
        });
    });
    </script>

    <script>
    // Update footers on page load
    updateDashboardFooters();

    // Update footers every 60 seconds
    setInterval(updateDashboardFooters, 60000);
    </script>
</body>


</html>