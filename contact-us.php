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
    <link rel="stylesheet" href="assets/css/contact-us.css">
    <title>Contact Us | Sweet Dream Job</title>
    <!-- <link rel="stylesheet" href="styles.css">
    <script src="script.js"></script> -->
</head>
<?php include 'includes/navbar.php'; ?>

<body class="body">
    <div class="contact-us-container">

        <div class="company-info">
            <h1>Contact Us</h1>
            <div class="company-details">
                <div class="email">
                    <h2>Email Us</h2>
                    <!-- p and h3 tag will be from the database  -->
                    <p>Shoot us an email</p>
                    <h3 class="specific-info no-underline"><img src="assets/images/mail.svg"
                            alt="">sweetdreamjob@gmail.com</h3>
                </div>
                <div class="phone">
                    <h2>Call Us</h2>
                    <!-- p and h3 tag will be from the database  -->
                    <p>Call our team Mon-Fri from 8am to 5pm</p>
                    <h3 class="specific-info no-underline"><img src="assets/images/contact-phone.svg" alt="">+1(555)
                        000-0000</h3>
                </div>
                <div class="location">
                    <h2>Visit Us</h2>
                    <!-- p and h3 tag will be from the database  -->
                    <p>Chat to us in person at our Poland HQ</p>
                    <h3 class="specific-info no-underline"><img src="assets/images/contact-pin.svg" alt="">Sample
                        Address
                        street, Sample City, Sample State, 12345</h3>
                    </h3>
                </div>
            </div>
        </div>


        <div class="contact-form">
            <div class="contact-form-container">
            </div>
        </div>
    </div>
</body>