<?php
include("../includes/db-connection.php");

if (isset($_GET['id'])) {
    $app_id = intval($_GET['id']);

    // Get attachment path
    $query = "SELECT attachment FROM applications WHERE app_id = $app_id";
    $result = mysqli_query($conn, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $attachment = $row['attachment'];

        // Update status to viewed
        $updateQuery = "UPDATE applications SET status = 'viewed' WHERE app_id = $app_id";
        mysqli_query($conn, $updateQuery);

        // Redirect to resume file
        header("Location: ../assets/uploads/resumes/" . urlencode($attachment));
        exit();
    } else {
        echo "Application not found.";
    }
} else {
    echo "No application ID provided.";
}