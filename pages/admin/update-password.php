<?php
session_start();
include("../includes/db-connection.php");

$user_id = $_SESSION['user_id'];
$old_password = $_POST['old_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';
$confirm_password = $_POST['confirm_new_password'] ?? '';

function is_valid_password($password)
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

// Fetch current password hash
$query = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || md5($old_password) !== $user['password']) {
    header("Location: settings.php?error=Old password is incorrect.");
    exit();
}

if ($new_password !== $confirm_password) {
    header("Location: settings.php?error=New passwords do not match.");
    exit();
}

if (!is_valid_password($new_password)) {
    header("Location: settings.php?error=New password must meet complexity requirements.");
    exit();
}

$new_hash = md5($new_password);
$update = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $conn->prepare($update);
$stmt->bind_param("si", $new_hash, $user_id);
$stmt->execute();

header("Location: settings.php?success=Password updated successfully.");
exit();