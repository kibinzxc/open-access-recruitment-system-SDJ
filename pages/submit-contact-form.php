<?php
// Include database connection
include 'includes/db-connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/vendor/autoload.php';

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if submission cookie exists
    if (isset($_COOKIE['form_submitted'])) {
        header('Location: contact-us.php?error=You have already submitted a message.');
        exit;
    }

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
                // Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'sweetdreamjob.noreply@gmail.com';
                $mail->Password   = 'ajzd lyad muas wpzd';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients and content (unchanged)
                $mail->setFrom('sweetdreamjob.noreply@gmail.com', 'Sweet Dream Job');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Contact Form Submission';
                $emailMessage = "..."; // Your existing email template
                $mail->Body = $emailMessage;

                $mail->send();
                header('Location: contact-us.php?success=Your message has been sent successfully!');
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
