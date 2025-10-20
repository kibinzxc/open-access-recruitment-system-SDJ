<?php
// Include database connection
include 'includes/db-connection.php';

date_default_timezone_set('Asia/Manila');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/vendor/autoload.php';

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if submission cookie exists --- THIS IS DISABLED FOR NOW TO ALLOW MULTIPLE SUBMISSIONS
    // if (isset($_COOKIE['job_application_submitted'])) {
    //     header('Location: job-application.php?id=' . $_POST['job_code'] . '&error=You have already submitted an application recently.');
    //     exit;
    // }

    // Validate job code
    if (!isset($_POST['job_code']) || empty($_POST['job_code'])) {
        header('Location: jobs.php?error=Invalid job reference.');
        exit;
    }

    // Sanitize and validate input
    $firstName = htmlspecialchars(trim($_POST['first_name']));
    $lastName = htmlspecialchars(trim($_POST['last_name']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $phone = preg_replace('/[^0-9]/', '', $_POST['phone']);
    $jobCode = htmlspecialchars(trim($_POST['job_code']));

    // Check for empty fields
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
        header('Location: job-application.php?id=' . $jobCode . '&error=All fields are required.');
        exit;
    }

    // Check if email is valid
    if (!$email) {
        header('Location: job-application.php?id=' . $jobCode . '&error=Invalid email address.');
        exit;
    }

    // Validate phone number
    if (strlen($phone) < 10) {
        header('Location: job-application.php?id=' . $jobCode . '&error=Please enter a valid phone number.');
        exit;
    }

    // Validate file upload
    if (!isset($_FILES['resume']) || $_FILES['resume']['error'] !== UPLOAD_ERR_OK) {
        header('Location: job-application.php?id=' . $jobCode . '&error=Please upload your resume.');
        exit;
    }

    $app_id = strtoupper(date('dmY') . bin2hex(random_bytes(4)));

    // Check file type (PDF only)
    $fileType = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
    if ($fileType !== 'pdf') {
        header('Location: job-application.php?id=' . $jobCode . '&error=Only PDF files are allowed.');
        exit;
    }

    // Check file size (max 5MB)
    if ($_FILES['resume']['size'] > 5000000) {
        header('Location: job-application.php?id=' . $jobCode . '&error=File size must be less than 5MB.');
        exit;
    }

    $resumeFilename = 'resume_' . strtolower($app_id) . '.pdf';
    $uploadPath = 'assets/uploads/resumes/' . $resumeFilename;

    // Create uploads directory if it doesn't exist
    if (!file_exists('assets/uploads/resumes')) {
        mkdir('assets/uploads/resumes', 0777, true);
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES['resume']['tmp_name'], $uploadPath)) {
        header('Location: job-application.php?id=' . $jobCode . '&error=Failed to upload resume.');
        exit;
    }

    // Insert data into the database
    $query = "INSERT INTO applications (app_id, job_code, f_name, l_name, email, p_number, attachment, status) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $status = 'new';
        $stmt->bind_param('ssssssss', $app_id, $jobCode, $firstName, $lastName, $email, $phone, $resumeFilename, $status);
        if ($stmt->execute()) {
            // Set cookie for 7 days to prevent duplicate submissions
            setcookie('job_application_submitted', '1', time() + 604800, '/');

            // Get job details for email
            $jobQuery = "SELECT title, country FROM jobs WHERE job_code = ?";
            $jobStmt = $conn->prepare($jobQuery);
            $jobStmt->bind_param('s', $jobCode);
            $jobStmt->execute();
            $jobResult = $jobStmt->get_result();
            $job = $jobResult->fetch_assoc();
            $jobTitle = htmlspecialchars($job['title']);
            $jobCountry = htmlspecialchars($job['country']);

            // Get company email from database
            $companyEmailQuery = "SELECT details FROM company_details WHERE id = 3";
            $result = mysqli_query($conn, $companyEmailQuery);
            $row = mysqli_fetch_assoc($result);
            $company_email = $row['details'];

            // Initialize PHPMailer
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

                // Email to applicant
                $mail->setFrom('sweetdreamjob.noreply@gmail.com', 'Sweet Dream Job');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Application Received: ' . $jobTitle;
                $emailMessage = "
                    <p>Thank you for applying for the <strong>$jobTitle</strong> job at Sweet Dream Job!</p>
                    <p>We have received your application and will review it shortly. Here are your application details:</p>
                    <p><strong>Application ID:</strong> $app_id</p>
                    <p><strong>Position:</strong> $jobTitle ($jobCountry)</p>
                    <p><strong>Name:</strong> $firstName $lastName</p>
                    <p><strong>Email:</strong> $email</p>
                    <p><strong>Phone:</strong> " . formatPhoneNumber($phone) . "</p>
                    <p><strong>Attachments:</strong> File Uploaded</p>
                    <br>
                    <p>Best regards,</p>
                    <p>Sweet Dream Job</p>
                    <br>
                    <p>This is an automated message. Please do not reply.</p>
                ";
                $mail->Body = $emailMessage;

                if ($mail->send()) {
                    // Email to admin
                    $mail->clearAddresses();
                    $mail->setFrom('sweetdreamjob.noreply@gmail.com', 'Sweet Dream Job');
                    $mail->addAddress($company_email);
                    $mail->Subject = 'New Application: ' . $jobTitle . ' (ID: ' . $app_id . ')';
                    $mail->isHTML(true);
                    $mail->addAttachment($uploadPath); // Attach the resume

                    $adminMessage = "
                        <p>Dear Admin,</p>
                        <p>A new application has been submitted for the <strong>$jobTitle</strong> position.</p>
                        <br>
                        <p>Here are the details:</p>
                        <p><strong>Position:</strong> $jobTitle ($jobCountry)</p>
                        <p><strong>Application ID:</strong> $app_id</p>
                        <p><strong>Name:</strong> $firstName $lastName</p>
                        <p><strong>Email:</strong> $email</p>
                        <p><strong>Phone:</strong> " . formatPhoneNumber($phone) . "</p>
                        <p><strong>Applied On:</strong> " . date('F j, Y \a\t g:i a') . "</p>
                        <br>
                        <p>The applicant's resume is attached to this email.</p>
                    ";
                    $mail->Body = $adminMessage;

                    if ($mail->send()) {
                        header('Location: job-application.php?id=' . $jobCode . '&success=Your application has been submitted successfully!');
                    } else {
                        header('Location: job-application.php?id=' . $jobCode . '&error=Application submitted but failed to notify admin. Your application ID is: ' . $app_id);
                    }
                } else {
                    header('Location: job-application.php?id=' . $jobCode . '&error=Application submitted but failed to send confirmation email. Your application ID is: ' . $app_id);
                }
            } catch (Exception $e) {
                header('Location: job-application.php?id=' . $jobCode . '&error=Application submitted but email notification failed. Your application ID is: ' . $app_id);
            }
        } else {
            header('Location: job-application.php?id=' . $jobCode . '&error=Database error. Please try again.');
        }
    } else {
        header('Location: job-application.php?id=' . $jobCode . '&error=Database error: ' . $conn->error);
    }
    exit;
} else {
    header('Location: jobs.php');
    exit;
}

// Helper function to format phone number
function formatPhoneNumber($phone)
{
    if (strlen($phone) === 10) {
        return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
    }
    return $phone;
}