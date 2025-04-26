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
    <link rel="stylesheet" href="assets/css/jobs.css">
    <title> Jobs | Sweet Dream Job</title>
    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">
    <div class="header" style="position: relative;">
        <img class="header-photo" src="assets/images/cover-photo.png" alt="Cover Photo">
        <div class="header-container">
            <div class="search-container">
                <!-- First Column -->
                <div class="search-column">
                    <label for="what" class="mobile-hidden-text">What:</label>
                    <input type="text" id="what" name="what" placeholder="Job title, keywords...">
                </div>

                <!-- Second Column -->
                <div class="search-column mobile-hidden">
                    <label for="where">Where:</label>
                    <select id="where" name="where" class="placeholder-shown">
                        <option value="" disabled selected>Select location</option>
                        <option value="new-york">New York</option>
                        <option value="los-angeles">Los Angeles</option>
                        <option value="chicago">Chicago</option>
                        <option value="houston">Houston</option>
                        <option value="miami">Miami</option>
                    </select>
                </div>

                <div class="search-column">
                    <label class="hidden-class" for="search">search</label>
                    <button type="submit" id="search" name="search">Search</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="wrapper">
            <div class="content">

                <a href="job-details.php" class="job-card" style="text-decoration: none; color: inherit;">
                    <div class="job-image"><img src="assets/images/sample-image.jfif" alt=""></div>
                    <div class="job-title">
                        <h2>Pipe Fitter</h2>
                    </div>
                    <div class="job-location"><img src="assets/images/map-pin.svg" alt="">Poland</div>
                    <div class="job-tags">
                        <div class="job-tag">Full-time</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                    </div>
                </a>

                <div class="job-card">
                    <div class="job-image"><img src="assets/images/sample-image.jfif" alt=""></div>
                    <div class="job-title">
                        <h2>Pipe Fitter</h2>
                    </div>
                    <div class="job-location"><img src="assets/images/map-pin.svg" alt="">Poland</div>
                    <div class="job-tags">
                        <div class="job-tag">Full-time</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>

                    </div>
                </div>
                <div class="job-card">
                    <div class="job-image"><img src="assets/images/sample-image.jfif" alt=""></div>
                    <div class="job-title">
                        <h2>Pipe Fitter</h2>
                    </div>
                    <div class="job-location"><img src="assets/images/map-pin.svg" alt="">Poland</div>
                    <div class="job-tags">
                        <div class="job-tag">Full-time</div>
                        <div class="job-tag">Remote</div>
                    </div>
                </div>

                <div class="job-card">
                    <div class="job-image"><img src="assets/images/sample-image.jfif" alt=""></div>
                    <div class="job-title">
                        <h2>Pipe Fitter</h2>
                    </div>
                    <div class="job-location"><img src="assets/images/map-pin.svg" alt="">Poland</div>
                    <div class="job-tags">
                        <div class="job-tag">Full-time</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>

                    </div>
                </div>

                <div class="job-card">
                    <div class="job-image"><img src="assets/images/sample-image.jfif" alt=""></div>
                    <div class="job-title">
                        <h2>Pipe Fitter</h2>
                    </div>
                    <div class="job-location"><img src="assets/images/map-pin.svg" alt="">Poland</div>
                    <div class="job-tags">
                        <div class="job-tag">Full-time</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>
                        <div class="job-tag">Remote</div>

                    </div>
                </div>
                <div class="job-card">
                    <div class="job-image"><img src="assets/images/sample-image.jfif" alt=""></div>
                    <div class="job-title">
                        <h2>Pipe Fitter</h2>
                    </div>
                    <div class="job-location"><img src="assets/images/map-pin.svg" alt="">Poland</div>
                    <div class="job-tags">
                        <div class="job-tag">Full-time</div>
                        <div class="job-tag">Remote</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script>
document.querySelectorAll('.search-column select').forEach(select => {
    select.addEventListener('change', function() {
        if (this.value === "") {
            this.classList.add('placeholder-shown');
        } else {
            this.classList.remove('placeholder-shown');
        }
    });
});
</script>