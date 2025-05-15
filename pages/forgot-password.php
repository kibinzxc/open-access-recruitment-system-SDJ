<?php
session_start();
include 'includes/db-connection.php';
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/vendor/autoload.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

    if (!$email) {
        $response['message'] = 'Invalid email address';
        echo json_encode($response);
        exit;
    }

    // Check if email exists in database
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $response['message'] = 'Account does not exist';
        echo json_encode($response);
        exit;
    }

    // Generate temporary password
    $tempPassword = bin2hex(random_bytes(4)); // 8-character random password
    $hashedPassword = md5($tempPassword);

    // Update password in database
    $updateStmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
    $updateStmt->bind_param("ss", $hashedPassword, $email);

    if ($updateStmt->execute()) {
        // Send email with temporary password
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

            // Recipients
            $mail->setFrom('sweetdreamjob.noreply@gmail.com', 'Sweet Dream Job');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Temporary Password';
            $mail->Body    = "
                <h2>Password Reset Request</h2>
                <p>You recently requested to reset your password for Sweet Dream Job.</p>
                <p>Your temporary password is: <strong>$tempPassword</strong></p>
                <p>Please log in using this temporary password and change it immediately.</p>
                <br>
                <p>If you didn't request this password reset, please contact our support team.</p>
                <br>
                <p>Best regards,<br>Sweet Dream Job Team</p>
            ";

            // Send email
            if ($mail->send()) {
                $response['success'] = true;
                $response['message'] = 'Password reset successfully. Kindly check your email';
            } else {
                $response['message'] = 'Password was reset but email failed to send. Please contact support.';
            }
        } catch (Exception $e) {
            $response['message'] = 'Password was reset but email failed: ' . $e->getMessage();
        }
    } else {
        $response['message'] = 'Error updating password. Please try again.';
    }
}

echo json_encode($response);