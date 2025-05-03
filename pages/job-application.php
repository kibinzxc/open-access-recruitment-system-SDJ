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
    <?php include 'includes/dreamy-stars2.php'; ?>
    <div class="top-nav">
        <div class="job-title">
            <h1><?= htmlspecialchars($job['title']); ?></h1>
            <div class="location"><img src="assets/images/map-pin.svg" alt="">
                <p><?= htmlspecialchars($job['country']); ?>
                </p>
            </div>
        </div>
        <div class="cancel">
            <a href="jobs.php" class="cancel-button-mobile">Cancel</a>
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
                        <label for="email">Email Address*</label>
                        <input type="email" id="email" name="email" placeholder="yourname@example.com" required>
                    </div>
                    <div class="form-column-full">
                        <label for="phone">Phone Number*</label>
                        <input type="tel" id="phone" name="phone" placeholder="(123) 456-7890" required
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                    <div class="form-column-full">
                        <label for="resume">Upload Resume (PDF only)*</label>
                        <input type="file" id="resume" name="resume" accept=".pdf" required>
                    </div>

                    <div class="form-column-full">
                        <button type="submit" class="submit-button">Submit</button>
                        <a href="jobs.php" class="cancel-button">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="job-details">
            <div class="job-details-container">
                <h1> <?= htmlspecialchars($job['title']); ?></h1>
                <div class="location2"><img src="assets/images/map-pin.svg" alt="">
                    <p><?= htmlspecialchars($job['country']); ?>
                    </p>
                </div>
                <hr class="job-details-divider" />
                <div class="scroll">
                    <h2 class="top-h2">Responsibilities</h2>
                    <div class="early-show" id="early-show">
                        <?php
                            $responsibilities = json_decode($job['responsibilities'], true);
                            if (is_array($responsibilities) && isset($responsibilities['responsibilities'])) {
                                // Get all responsibilities
                                $tasks = $responsibilities['responsibilities'];
                                

                                // Display only the first two responsibilities in an unordered list
                                echo '<ul class="job-responsibilities">';
                                foreach (array_slice($tasks, 0, 2) as $responsibility) {
                                    echo '<li>' . htmlspecialchars($responsibility) . '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<p>No responsibilities listed</p>';
                            }
                ?>
                    </div>

                    <div class="late-show" id="desc" style="display: none;">
                        <?php
                            $responsibilities = json_decode($job['responsibilities'], true);
                            if (is_array($responsibilities) && isset($responsibilities['responsibilities'])) {
                                // Get all responsibilities
                                $tasks = $responsibilities['responsibilities'];
                                
                                // Display responsibilities in an unordered list
                                echo '<ul class="job-responsibilities2">';
                                foreach ($tasks as $responsibility) {
                                    echo '<li>' . htmlspecialchars($responsibility) . '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<p>No responsibilities listed</p>';
                            }
                        ?>
                        <h2>Qualifications</h2>
                        <?php
                            $qualifications = json_decode($job['qualification'], true);
                            if (is_array($qualifications) && isset($qualifications['qualification'])) {
                                // Get all qualifications
                                $tags = $qualifications['qualification'];
                                
                                // Sort by string length (shortest first)
                                usort($tags, function($a, $b) {
                                    return strlen($a) - strlen($b);
                                });
                                
                                // Display sorted qualifications in an unordered list
                                echo '<ul class="job-responsibilities2">';
                                foreach ($tags as $qualification) {
                                    echo '<li>' . htmlspecialchars($qualification) . '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<p>No qualifications listed</p>';
                            }
                        ?>


                    </div>
                </div>
                <button id="toggleDesc"><span class="desc-label">View full job description</span> <img
                        src="assets/images/down-arrow.svg" alt=""></button>
            </div>
        </div>
    </div>
    </div>
</body>

<script>
document.getElementById("toggleDesc").addEventListener("click", function() {
    var earlyShow = document.getElementById("early-show");
    var desc = document.getElementById("desc");
    if (desc.style.display === "none") {
        desc.style.display = "block";
        earlyShow.style.display = "none";
        this.innerHTML =
            "<span class=\"desc-label\">Hide full job description </span> <img src='assets/images/up-arrow.svg' alt=''>";
    } else {
        desc.style.display = "none";
        earlyShow.style.display = "block";
        this.innerHTML =
            "<span class=\"desc-label\"> View full job description </span><img src='assets/images/down-arrow.svg' alt=''>";
    }
});
</script>