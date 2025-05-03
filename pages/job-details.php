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

    <a class="back-button" href="jobs.php">
        <img src="assets/images/back-button.svg" alt="Back">Back
    </a>

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
                        <form action="job-application.php" method="get">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($jobCode); ?>">
                            <button type="submit" id="apply-button" class="apply-button">Apply Now</button>
                        </form>
                        <button type="button" id="share-button" onclick="copyLinkToClipboard()">
                            <img src="assets/images/share.svg" class="share-button-icon" alt="">Share
                        </button>

                    </div>
                </div>

            </div>
            <div class="job-description">
                <div class="job-desc">
                    <h2>Job Description</h2>
                    <p><?= htmlspecialchars($job['description']); ?></p>
                </div>
                <div class="job-responsibilities">
                    <h2>Responsibilities</h2>
                    <?php
                            $responsibilities = json_decode($job['responsibilities'], true);
                            if (is_array($responsibilities) && isset($responsibilities['responsibilities'])) {
                                // Get all responsibilities
                                $tasks = $responsibilities['responsibilities'];
                                
                                // Display responsibilities in an unordered list
                                echo '<ul class="job-responsibilities">';
                                foreach ($tasks as $responsibility) {
                                    echo '<li>' . htmlspecialchars($responsibility) . '</li>';
                                }
                                echo '</ul>';
                            } else {
                                echo '<p>No responsibilities listed</p>';
                            }
                        ?>
                </div>
                <div class="job-qualification">

                    <h2>Qualifications</h2>
                    <?php
                        if (is_array($qualifications) && isset($qualifications['qualification'])) {
                            // Sort qualifications by string length (shortest first)
                            usort($qualifications['qualification'], function($a, $b) {
                                return strlen($a) - strlen($b);
                            });

                            echo '<ul class="qualification-list">';
                            foreach ($qualifications['qualification'] as $qualification) {
                                echo '<li>' . htmlspecialchars($qualification) . '</li>';
                            }
                            echo '</ul>';
                        } else {
                            echo '<p>No qualifications listed</p>';
                        }
                    ?>
                </div>
            </div>
        </div>

</body>

<script>
function copyLinkToClipboard() {
    const link = window.location.href;
    navigator.clipboard.writeText(link).then(() => {
        showCopiedMessage();
    }).catch(err => {
        console.error('Failed to copy link: ', err);
    });
}

function showCopiedMessage() {
    let msg = document.createElement('div');
    msg.className = 'copied-message';
    msg.innerText = 'Link copied to clipboard!';
    document.body.appendChild(msg);

    // Trigger animation
    setTimeout(() => {
        msg.classList.add('show');
    }, 10);

    setTimeout(() => {
        msg.classList.remove('show');
    }, 1500);

    setTimeout(() => {
        msg.remove();
    }, 2000);
}
</script>