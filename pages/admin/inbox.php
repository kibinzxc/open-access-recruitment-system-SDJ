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
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="styles/inbox.css">
        <?php
        // Query to fetch the name based on the user ID from the session
        $query = "SELECT name FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id); // Use the user ID from the session
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $name = $row['name'];
        } else {
            $name = "Guest"; // Default name if no user is found
        }

        $stmt->close();
        ?>
        <h1>Welcome, <?php echo htmlspecialchars($name); ?>!</h1>
        <p>This is your inbox where you can manage your messages and notifications.</p>

    </div>
</body>

</html>