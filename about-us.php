<!DOCTYPE html>
<?php
include 'includes/db-connection.php';
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sweet Dream Job - Your dream job awaits!">
    <meta name="keywords" content="job, career, dream job, employment, opportunities">
    <link rel="icon" href="assets/images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/about-us.css">
    <title>Sweet Dream Job</title>
    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">
    <div class="header" style="position: relative;">
        <img class="header-photo" src="assets/images/cover-photo.png" alt="Cover Photo">
        <div class="header-text">
            About Us
        </div>
    </div>

    <div class="content">
        <div class="company-mission">
            <h2>Company <span style="color:#412BAD">Mission</span></h2>
            <?php
            $query = "SELECT details FROM company_details WHERE category_name = 'mission'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo "<p class='mission-details'>" . $row['details'] . "</p>";
            } else {
                echo "Error retrieving mission details.";
            }
            ?>
        </div>

        <div class="company-vision">
            <h2>Company <span style="color:#412BAD">Vision</span></h2>
            <?php
            $query = "SELECT details FROM company_details WHERE category_name = 'vision'";
            $result = mysqli_query($conn, $query);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                echo "<p class='vision-details'>" . $row['details'] . "</p>";
            } else {
                echo "Error retrieving vision details.";
            }
            ?>
        </div>
    </div>

    <hr class="horizontal-line">

    <div class="footer">
        <p>See what pursuing your <span class="bold-text">dream career</span> with Sweet Dream Job can do for your
            future</p>
        <p>We're here to connect your <span class="bold-text">talent</span> and <span class="bold-text">ambition</span>
            with <span class="bold-text">opportunities</span> that truly fit you</p>
        <p>Take the first step toward the <span class="bold-text">career</span> you've always wanted!</p>
        <a class="submit-cv-button" href="jobs.php">
            Submit your CV now<a>
    </div>

</body>