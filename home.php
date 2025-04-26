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
    <!-- HTML Meta Tags -->
    <meta name="description" content="Sweet Dream Job - Your dream job awaits!">

    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="https://sweetdreamjob.com">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Sweet Dream Job">
    <meta property="og:description" content="Sweet Dream Job - Your dream job awaits!">
    <meta property="og:image"
        content="https://opengraph.b-cdn.net/production/images/11e7952b-30a8-49ee-9143-6a1de0f6d534.png?token=zZjfmBSD0D69hPysZn2gK5szwJhUbYaTf3eDdB8y5pg&height=262&width=424&expires=33281211347">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="sweetdreamjob.com">
    <meta property="twitter:url" content="https://sweetdreamjob.com">
    <meta name="twitter:title" content="Sweet Dream Job Website">
    <meta name="twitter:description" content="Sweet Dream Job - Your dream job awaits!">
    <meta name="twitter:image"
        content="https://opengraph.b-cdn.net/production/images/11e7952b-30a8-49ee-9143-6a1de0f6d534.png?token=zZjfmBSD0D69hPysZn2gK5szwJhUbYaTf3eDdB8y5pg&height=262&width=424&expires=33281211347">

    <!-- Meta Tags Generated via https://www.opengraph.xyz -->
    <link rel="icon" href="assets/images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Sweet Dream Job</title>
    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">
    <div class="note">Rotate your device for the best experience!</div>
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
    <?php include 'includes/dreamy-stars.php'; ?>
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