<?php
session_start();
include("../includes/db-connection.php");

// Check if 'id' is set in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: jobs.php?error=Invalid+job+ID");
    exit();
}

$jobId = intval($_GET['id']);

// Fetch job title and image filename before deleting
$title = '';
$image = '';
$stmt = $conn->prepare("SELECT title, img FROM jobs WHERE id = ?");
$stmt->bind_param("i", $jobId);
$stmt->execute();
$stmt->bind_result($title, $image);
$stmt->fetch();
$stmt->close();

if (empty($title)) {
    header("Location: jobs.php?error=Job+not+found");
    $conn->close();
    exit();
}

// Delete the image file if it exists
if (!empty($image)) {
    $imagePath = "../assets/images/jobs_bin/" . $image; // Adjust path based on your upload directory
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

// Delete the job record
$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
$stmt->bind_param("i", $jobId);

if ($stmt->execute()) {
    header("Location: jobs.php?success=Job+'" . urlencode($title) . "'+deleted+successfully");
} else {
    header("Location: jobs.php?error=Failed+to+delete+job+'" . urlencode($title) . "'+Please+try+again");
}

$stmt->close();
$conn->close();
exit();