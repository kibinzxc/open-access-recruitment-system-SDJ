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
    <title>About Us | Sweet Dream Job</title>
    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">
    <div class="note">Rotate your device for the best experience!</div>
    <div class="header" style="position: relative;">
        <img class="header-photo" src="assets/images/cover-photo.png" alt="Cover Photo">
        <div class="header-text">
            Company Profile
        </div>
    </div>

    <div class="content">
        <div class="float-left">
            <div class="profile-card">
                <img src="assets/images/ceo-photo.jpg" alt="CEO Photo" class="profile-photo">
                <h2>May E. Rolle</h2>
                <p class="position">President & CEO</p>
            </div>
        </div>
        <div class="float-right">
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

    </div>
    <br>
    <hr class="horizontal-line">
    <br>
    <section style="text-align: center; padding: 40px 20px;">
        <h2 style="font-size: 2rem; font-weight: 600;">
            Sweet Dream Job<span style="color:#412BAD;"> is Hiring! 💼</span>
        </h2>
        <p style="margin-top: 10px; color: #555; max-width: 600px; margin-inline: auto;">
            Discover handpicked job opportunities that fit your goals and lifestyle. Whether you're starting fresh or
            leveling up, your dream job might just be a scroll away. <strong>All European country workers are accepted
                to apply.</strong>
        </p>
        <a href="jobs.php" class="explore-jobs-btn">
            EXPLORE JOBS
        </a>
    </section>
    <div class="job-container">
        <div class="carousel-container">
            <button id="prev-btn">❮</button>
            <button id="next-btn">❯</button>

            <div class="carousel-track" id="job-carousel">
                <?php
                $jobQuery = "SELECT job_code, title, country, img FROM jobs ORDER BY RAND()";
                $jobResult = mysqli_query($conn, $jobQuery);
                $jobs = [];
                if ($jobResult && mysqli_num_rows($jobResult) > 0) {
                    while ($job = mysqli_fetch_assoc($jobResult)) {
                        $jobs[] = $job;
                    }
                    // Output jobs twice for infinite loop effect
                    foreach (array_merge($jobs, $jobs, $jobs) as $job) {
                        echo '<a href="job-details.php?id=' . $job['job_code'] . '" class="card" style="text-decoration:none; color:inherit;">';
                        echo '<img src="assets/images/jobs_bin/' . htmlspecialchars($job['img']) . '" alt="' . htmlspecialchars($job['title']) . '" style="width:100%;height:150px;object-fit:cover;">';
                        echo '<h3>' . htmlspecialchars($job['title']) . '</h3>';
                        echo '<p>' . htmlspecialchars($job['country']) . '</p>';
                        echo '</a>';
                    }
                } else {
                    echo '<p>No jobs available at the moment.</p>';
                }
                ?>
            </div>
        </div>
        <script>
        const track = document.getElementById('job-carousel');
        const nextBtn = document.getElementById('next-btn');
        const prevBtn = document.getElementById('prev-btn');

        let cardWidth = 280; // card + margin
        let autoScrollInterval;
        let restartTimeout;

        // ✅ Scroll to the middle copy on load
        window.addEventListener('load', () => {
            const middle = track.scrollWidth / 3; // middle copy
            track.scrollLeft = middle;
            track.style.scrollBehavior = 'smooth'; // Enable smooth scrolling
            startAutoScroll();
        });

        // ✅ Auto-scroll
        function startAutoScroll() {
            clearInterval(autoScrollInterval);
            autoScrollInterval = setInterval(() => {
                track.scrollLeft += 1;
                resetScrollIfNeeded();
            }, 10);
        }

        function stopAutoScroll() {
            clearInterval(autoScrollInterval);
        }

        function restartAutoScrollAfterDelay() {
            clearTimeout(restartTimeout);
            restartTimeout = setTimeout(() => {
                startAutoScroll();
            }, 2000);
        }

        // ✅ Reset if we scroll too far left or right
        function resetScrollIfNeeded() {
            const totalWidth = track.scrollWidth;
            const section = totalWidth / 3;
            const currentScroll = track.scrollLeft;

            // If scrolled too far to the right (into the third copy)
            if (currentScroll >= section * 2) {
                track.scrollLeft = currentScroll - section;
            }
            // If scrolled too far to the left (into the first copy)
            else if (currentScroll <= 0) {
                track.scrollLeft = currentScroll + section;
            }
        }

        // ✅ Button controls with improved infinite scrolling
        nextBtn.addEventListener('click', () => {
            stopAutoScroll();

            // Move to next card
            track.scrollLeft += cardWidth;

            // Check if we need to reset position for infinite effect
            setTimeout(() => {
                const originalBehavior = track.style.scrollBehavior;
                track.style.scrollBehavior = 'auto'; // Disable smooth scroll for reset
                resetScrollIfNeeded();
                track.style.scrollBehavior = originalBehavior; // Re-enable smooth scroll
            }, 50); // Small delay to ensure scroll completes

            restartAutoScrollAfterDelay();
        });

        prevBtn.addEventListener('click', () => {
            stopAutoScroll();

            // Move to previous card
            track.scrollLeft -= cardWidth;

            // Check if we need to reset position for infinite effect
            setTimeout(() => {
                const originalBehavior = track.style.scrollBehavior;
                track.style.scrollBehavior = 'auto'; // Disable smooth scroll for reset
                resetScrollIfNeeded();
                track.style.scrollBehavior = originalBehavior; // Re-enable smooth scroll
            }, 50); // Small delay to ensure scroll completes

            restartAutoScrollAfterDelay();
        });

        // ✅ Hover to pause
        track.addEventListener('mouseenter', stopAutoScroll);
        track.addEventListener('mouseleave', restartAutoScrollAfterDelay);
        </script>




    </div>
    <br>

    <hr class="horizontal-line">

    <div class="footer">
        <p>See what pursuing your <span class="bold-text">dream career</span> with Sweet Dream Job can do for your
            future</p>
        <p>We're here to connect your <span class="bold-text">talent</span> and <span class="bold-text">ambition</span>
            with <span class="bold-text">opportunities</span> that truly fit you</p>
        <p>Take the first step toward the <span class="bold-text">career</span> you've always wanted!</p>
        <a class="submit-cv-button" href="jobs.php">
            Submit your CV now</a>
    </div>

</body>