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
    <link rel="stylesheet" href="assets/css/job-details.css">
    <title> Jobs | Sweet Dream Job</title>
    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">

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
    <div class="container">
        <div class="content-wrapper">
            <div class="job-header">
                <div class="job-image">
                    <img src="assets/images/jobs_bin/<?= $jobImage; ?>" alt="Job Image">
                </div>
                <div class="job-title">
                    <h1><?= $jobTitle; ?></h1>
                    <p class="job-location"><img src="assets/images/details-pin.svg" alt=""><?= $jobCountry; ?> </p>
                    <hr />

                    <div class="tags">
                        <div class="label">
                            <p>Needed:</p>
                        </div>

                        <div class="job-tags">
                            <?php
                            $qualifications = json_decode($job['qualification'], true);
                            if (is_array($qualifications) && isset($qualifications['qualification'])) {
                                // Get all qualifications
                                $tags = $qualifications['qualification'];
                                
                                // Sort by string length (shortest first)
                                usort($tags, function($a, $b) {
                                    return strlen($a) - strlen($b);
                                });
                                
                                // Display sorted tags
                                foreach ($tags as $qualification) {
                                    echo '<div class="job-tag">' . htmlspecialchars($qualification) . '</div>';
                                }
                            } else {
                                echo '<div class="job-tag">No qualifications listed</div>';
                            }
                            ?>
                        </div>

                    </div>

                    <div class="buttons">
                        <button type="submit" id="apply-button">Apply Now</button>
                        <button type="submit" id="share-button"><img src="assets/images/share.svg" alt=""
                                style="width:24px;">Share</button>
                    </div>
                </div>

            </div>
            <div class="job-description">
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita dolorem explicabo illo eveniet
                    vitae consectetur. Tempora, deserunt? Deleniti, esse consequuntur non impedit doloribus, excepturi
                    repellendus aspernatur nam debitis quas porro.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita dolorem explicabo illo eveniet
                    vitae consectetur. Tempora, deserunt? Deleniti, esse consequuntur non impedit doloribus, excepturi
                    repellendus aspernatur nam debitis quas porro.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita dolorem explicabo illo eveniet
                    vitae consectetur. Tempora, deserunt? Deleniti, esse consequuntur non impedit doloribus, excepturi
                    repellendus aspernatur nam debitis quas porro.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita dolorem explicabo illo eveniet
                    vitae consectetur. Tempora, deserunt? Deleniti, esse consequuntur non impedit doloribus, excepturi
                    repellendus aspernatur nam debitis quas porro.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita dolorem explicabo illo eveniet
                    vitae consectetur. Tempora, deserunt? Deleniti, esse consequuntur non impedit doloribus, excepturi
                    repellendus aspernatur nam debitis quas porro.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita dolorem explicabo illo eveniet
                    vitae consectetur. Tempora, deserunt? Deleniti, esse consequuntur non impedit doloribus, excepturi
                    repellendus aspernatur nam debitis quas porro.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita dolorem explicabo illo eveniet
                    vitae consectetur. Tempora, deserunt? Deleniti, esse consequuntur non impedit doloribus, excepturi
                    repellendus aspernatur nam debitis quas porro.</p>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Expedita dolorem explicabo illo eveniet
                    vitae consectetur. Tempora, deserunt? Deleniti, esse consequuntur non impedit doloribus, excepturi
                    repellendus aspernatur nam debitis quas porro123.</p>
            </div>
        </div>

</body>