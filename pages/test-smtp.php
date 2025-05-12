<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'libs/vendor/autoload.php';

$mail = new PHPMailer(true);
try {
    $mail->SMTPDebug = 2;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sweetdreamjob.noreply@gmail.com';
    $mail->Password   = 'ajzd lyad muas wpzd';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('sweetdreamjob.noreply@gmail.com', 'Sweet Dream Job');
    $mail->addAddress('mamadaddyalexa@gmail.com'); // Replace with your email

    $mail->isHTML(true);
    $mail->Subject = 'SMTP Test';
    $mail->Body    = 'Hello Mr. Almirante, this is a test email from Sweet Dream Job.';

    $mail->send();
    echo 'Message sent successfully!';
} catch (Exception $e) {
    echo 'Message could not be sent. Error: ', $mail->ErrorInfo;
}
