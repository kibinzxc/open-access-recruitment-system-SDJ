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
    <meta name="title" content="Sweet Dream Job Website" />
    <meta property="og:type content=" website" />
    <meta property="og:url" content="https://sweetdreamjob.com/" />
    <meta property="og:title" content="Sweet Dream Job Website" />
    <meta property="og:description" content="Sweet Dream Job - Your dream job awaits!" />
    <meta property="og:image" content="assets/images/sdj-icon.png" />
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="https://sweetdreamjob.com/" />
    <meta property="twitter:title" content="Sweet Dream Job Website" />
    <meta property="twitter:description" content="Sweet Dream Job - Your dream job awaits!" />
    <meta property="twitter:image" content="assets/images/sdj-icon.png" />
    <link rel="icon" href="assets/images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Sweet Dream Job</title>
    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">

    <div class="hero">
        <div class="hero-text">
            <h1>Find Your <span class="emphasized"> Dream Job </span> Today</h1>
            <a href="jobs.php" class="explore-jobs-btn">Explore Jobs <img class="arrow-right-icon"
                    src="assets/images/arrow-right.svg" alt="arrow-right svg"></a>
        </div>
    </div>
    <div class="hero-svg">
        <img src="assets/images/smiling-professionals.png" alt="Hero Image">

    </div>
</body>

<script>
const arrowIcon = document.querySelector('.arrow-right-icon');

let moveCount = 0;
let isPaused = false;

function moveArrow() {
    if (isPaused) return;

    moveCount++;

    arrowIcon.style.transition = 'transform 0.2s ease-in-out';
    arrowIcon.style.transform = `translateX(${moveCount % 2 === 0 ? 5 : 10}px)`; // Toggle between 0px and 10px

    // Check if it has moved 3 times
    if (moveCount === 6) {
        isPaused = true;
        setTimeout(() => {
            isPaused = false;
            moveCount = 0;
        }, 3000); // 3-second pause
    }
}

setTimeout(() => {
    setInterval(moveArrow, 200); // Run the movement every 200ms
}, 2000); // 
</script>