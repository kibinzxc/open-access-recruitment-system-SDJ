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

    <title>Inbox | Admin</title>
</head>
<?php include '../includes/admin-sidebar.php'; ?>

<body>

    <div class="content" id="main-content">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="styles/inbox.css">
        <div class="container-fluid">
            <div class="header">
                <?php
                $unreadQuery = "SELECT COUNT(*) AS unread_count FROM messages WHERE status = 'unread'";
                $unreadResult = mysqli_query($conn, $unreadQuery);
                $unreadCount = 0;
                if ($unreadResult) {
                    $row = mysqli_fetch_assoc($unreadResult);
                    $unreadCount = $row['unread_count'];
                }
                ?>
                <h1 class="my-4">Inbox
                    <?php if ($unreadCount > 0): ?>
                    <span class="unread">(<?php echo $unreadCount; ?> unread)</span>
                    <?php endif; ?>
                </h1>
            </div>
            <p class="subheadline">All messages/inquiries/concerns from users</p>

            <div class="table-inbox">
                <div class="table-responsive">
                    <table id="msgTable" class="table datatable  table-bordered table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Sender's Email</th>
                                <th>Date Received</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT * FROM messages ORDER BY date_sent DESC";
                            $result = mysqli_query($conn, $query);
                            $rowCount = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                // Check if the status is "unread"
                                $rowClass = ($row["status"] === "unread") ? "unread-row" : "";
                                echo "<tr class='$rowClass'>";
                                //count the number of rows

                                echo "<td>" . $rowCount++ . "</td>";
                                echo "<td>" . $row['email'] . "</td>";
                                echo "<td>" . date("F j, Y g:i A", strtotime($row['date_sent'])) . "</td>";
                                echo "<td>" . ($row["status"] === "read" ? "already viewed" : $row["status"]) . "</td>";
                                echo "<td>
                                    <div class='action-btns'>
                                        <a target='_blank' href='view-message.php?id=" . $row['msg_id'] . "' class='btn btn-info btn-sm action-btn'>
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
</body>

</html>