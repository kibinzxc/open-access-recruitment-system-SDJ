<?php
// Include database connection
include 'includes/db-connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/vendor/autoload.php';

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if submission cookie exists
    // if (isset($_COOKIE['form_submitted'])) {
    //     header('Location: contact-us.php?error=You have already submitted a message.');
    //     exit;
    // }


    // Sanitize and validate input
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Check for empty fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($message)) {
        header('Location: contact-us.php?error=All fields are required.');
        exit;
    }

    // Check if email is valid
    if (!$email) {
        header('Location: contact-us.php?error=Invalid email address.');
        exit;
    }

    // Insert data into the database
    $query = "INSERT INTO messages (f_name, l_name, email, msg, status) VALUES (?, ?, ?, ?, 'unread')";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param('ssss', $firstName, $lastName, $email, $message);
        if ($stmt->execute()) {
            // Set generic cookie for 7 days (604800 seconds)
            setcookie('form_submitted', '1', time() + 604800, '/');

            $mail = new PHPMailer(true);
            try {

                //get company email from database
                $companyEmailQuery = "SELECT details FROM company_details WHERE id = 3";
                $result = mysqli_query($conn, $companyEmailQuery);
                $row = mysqli_fetch_assoc($result);
                $company_email = $row['details'];

                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'sweetdreamjob.noreply@gmail.com';
                $mail->Password   = 'ajzd lyad muas wpzd';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients and content for user
                $mail->setFrom('sweetdreamjob.noreply@gmail.com', 'Sweet Dream Job');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Contact Form Submission';
                $emailMessage = "
                    <p>Thank you for reaching out to us! We will get back to you shortly.</p>
                    <br>
                    <p>Here are the details you submitted:</p>
                    <p><strong>Name:</strong> $firstName $lastName</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Message:</strong> $message</p>
                    <br>
                    <br>
                    <p>Best regards,</p>
                    <p>Sweet Dream Job Team</p>
                    <br>
                    <p>This is an automated message. Please do not reply.</p>
                ";
                $mail->Body    = $emailMessage;

                if ($mail->send()) {
                    // Send notification to admin

                    $mail->clearAddresses(); // Clear previous recipient
                    $mail->setFrom('sweetdreamjob.noreply@gmail.com', 'Sweet Dream Job');
                    $mail->addAddress($company_email); // Send to company email
                    $mail->Subject = 'Received a new message from contact form';
                    $mail->isHTML(true);
                    $adminMessage = "
                        <p>Dear Admin,</p>
                        <p>You have received a new message from the contact form on your website.</p>
                        <p>Here are the details:</p>
                        <p><strong>Name:</strong> $firstName $lastName</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Message:</strong> $message</p>
                    ";
                    $mail->Body    = $adminMessage;
                    if ($mail->send()) {
                        header('Location: contact-us.php?success=Your message has been sent successfully!');
                    } else {
                        header('Location: contact-us.php?error=Message sent to user but failed to notify admin.');
                    }
                } else {
                    header('Location: contact-us.php?error=Failed to send confirmation email to user.');
                }
            } catch (Exception $e) {
                header('Location: contact-us.php?error=Message saved but email notification failed.');
            }
        } else {
            header('Location: contact-us.php?error=Something went wrong. Please try again later.');
        }
    } else {
        header('Location: contact-us.php?error=Database error: ' . $conn->error);
    }
    exit;
} else {
    header('Location: contact-us.php?error=Invalid request.');
    exit;
}