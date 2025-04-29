<!DOCTYPE html>
<?php
include 'includes/db-connection.php';

if (isset($_GET['id'])) {
$jobId = $_GET['id'];

} else {
    echo "Job ID not provided.";
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sweet Dream Job - Your dream job awaits!">
    <meta name="keywords" content="job, career, dream job, employment, opportunities">
    <link rel="icon" href="assets/images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/jobs.css">
    <title> Jobs | Sweet Dream Job</title>
    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">

    <?php
    
    $query = "SELECT * FROM jobs WHERE job_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $jobId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
        //echo the job_code 
        echo $job['job_code'];
        echo "<h1>" . htmlspecialchars($job['title']) . "</h1>";
        echo "<p>" . htmlspecialchars($job['description']) . "</p>";
    } else {
        echo "No job found.";
    }




?>

</body>