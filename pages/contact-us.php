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
    <div class="note">Rotate your device for the best experience!</div>
    <div class="contact-us-container">

        <div class="company-info">
            <h1>Contact Us</h1>
            <div class="company-details">
                <div class="email">
                    <h2>Email Us</h2>
                    <!-- p and h3 tag will be from the database  -->
                    <p>Shoot us an email</p>
                    <h3 class="specific-info no-underline"><img src="assets/images/mail.svg" alt="">
                        <?php
                        $emailQuery = "SELECT * FROM company_details WHERE category_name = 'email'";
                        $emailResult = mysqli_query($conn, $emailQuery);
                        if ($emailResult && mysqli_num_rows($emailResult) > 0) {
                            $emailRow = mysqli_fetch_assoc($emailResult);
                            echo '<a class="clickable-details">' . htmlspecialchars($emailRow['details']) . '</a>';
                        } else {
                            echo '<a class="clickable-details">Email not available</a>';
                        }
                        ?>
                    </h3>
                </div>
                <div class="phone">
                    <h2>Call Us</h2>
                    <!-- p and h3 tag will be from the database  -->
                    <p>Call our team Mon-Fri from 8am to 5pm</p>
                    <h3 class="specific-info no-underline"><img src="assets/images/contact-phone.svg" alt="">
                        <?php
                        $phoneQuery = "SELECT * FROM company_details WHERE category_name = 'telephone'";
                        $phoneResult = mysqli_query($conn, $phoneQuery);
                        if ($phoneResult && mysqli_num_rows($phoneResult) > 0) {
                            $phoneRow = mysqli_fetch_assoc($phoneResult);
                            echo '<a class="clickable-details">' . htmlspecialchars($phoneRow['details']) . '</a>';
                        } else {
                            echo '<a class="clickable-details">Phone number not available</a>';
                        }
                        ?>
                    </h3>
                </div>
                <div class="location">
                    <h2>Visit Us</h2>
                    <!-- p and h3 tag will be from the database  -->
                    <p>Chat to us in person at our Poland HQ</p>
                    <h3 class="specific-info no-underline"><img src="assets/images/contact-pin.svg" alt="">
                        <?php
                        $locationQuery = "SELECT * FROM company_details WHERE category_name = 'address'";
                        $locationResult = mysqli_query($conn, $locationQuery);
                        if ($locationResult && mysqli_num_rows($locationResult) > 0) {
                            $locationRow = mysqli_fetch_assoc($locationResult);
                            echo '<a class="clickable-details">' . htmlspecialchars($locationRow['details']) . '</a>';
                        } else {
                            echo '<a class="clickable-details">Address not available</a>';
                        }
                        ?>
                    </h3>
                </div>
            </div>
        </div>


        <div class="contact-form">
            <div class="contact-form-container">
                <form action="submit-contact-form.php" method="POST" class="form-grid">
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
                        <label for="message">Message*</label>
                        <textarea id="message" name="message" rows="10" placeholder="Leave us a message..."
                            required></textarea>
                    </div>
                    <div class="form-column-full">
                        <button type="submit" class="submit-button">Send message</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>