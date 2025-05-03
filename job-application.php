<!DOCTYPE html>
<?php
include 'includes/db-connection.php';


if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Job ID (job_code) not provided in the URL.");
}
$jobCode = $_GET['id']; 
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sweet Dream Job - Your dream job awaits!">
    <meta name="keywords" content="job, career, dream job, employment, opportunities">
    <link rel="icon" href="assets/images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/job-application.css">
    <title> Jobs | Sweet Dream Job</title>
    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">
    <div class="note">Rotate your device for the best experience!</div>

    <a class="back-button" href="jobs.php">
        <img src="assets/images/back-button.svg" alt="Back">Back
    </a>

    <?php
    if (isset($jobCode)) {
        $query = "SELECT * FROM jobs WHERE job_code = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $jobCode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $job = $result->fetch_assoc();
            $jobTitle = htmlspecialchars($job['title']);
            $jobImage = htmlspecialchars($job['img']);
            $jobCountry = htmlspecialchars($job['country']);
        } else {
            echo "Job not found.";
            exit;
        }
        $stmt->close();
    } else {
        echo "Error: Job ID not found";
        exit;
    }
    ?>
    <?php include 'includes/dreamy-stars.php'; ?>
    <div class="top-nav">
        <div class="job-title">
            <h1><?= htmlspecialchars($job['title']); ?></h1>
            <div class="location"><img src="assets/images/map-pin.svg" alt="">
                <p><?= htmlspecialchars($job['country']); ?>
                </p>
            </div>
        </div>
        <div class="cancel">
            <a href="jobs.php" class="cancel-button">Cancel</a>
        </div>
    </div>
    <div class="container">
        <div class="job-apply-form">
            <div class="job-apply-form-container">
                <form action="submit-job-application.php" method="POST" enctype="multipart/form-data" class="form-grid">
                    <div class="form-column-full">
                        <div class="name-column">
                            <div class="form-column">
                                <label for="first-name">First Name*</label>
                                <input type="text" id="first-name" name="first_name" placeholder="First Name" required>
                            </div>
                            <div class="form-column">
                                <label for="last-name">Last Name*</label>
                                <input type="text" id="last-name" name="last_name" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-column-full">
                        <label for="email">Email*</label>
                        <input type="email" id="email" name="email" placeholder="yourname@example.com" required>
                    </div>
                    <div class="form-column-full">
                        <label for="phone">Phone Number*</label>
                        <input type="tel" id="phone" name="phone" placeholder="(123) 456-7890" required>
                    </div>
                    <div class="form-column-full">
                        <label for="resume">Upload Resume (PDF only)*</label>
                        <input type="file" id="resume" name="resume" accept=".pdf" required>
                    </div>

                    <div class="form-column-full">
                        <button type="submit" class="submit-button">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="job-details">
        </div>
    </div>
</body>