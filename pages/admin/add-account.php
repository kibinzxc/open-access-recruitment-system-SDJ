<?php
include("../includes/db-connection.php");

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Build query string for repopulating fields
$queryString = http_build_query([
    'name' => $name,
    'email' => $email
]);

function is_valid_password($password)
{
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
}

if ($password !== $confirm_password) {
    header("Location: settings.php?error=Passwords do not match.&$queryString");
    exit();
}

if (!is_valid_password($password)) {
    header("Location: settings.php?error=Password must be at least 8 characters and include uppercase, lowercase, number, and special character.&$queryString");
    exit();
}

// Check if email exists
$query = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    header("Location: settings.php?error=Email already exists.&$queryString");
    exit();
}

// Insert user
$hashed_password = md5($password);
$query = "INSERT INTO users (name, email, password, account_type) VALUES (?, ?, ?, 'admin')";
$stmt = $conn->prepare($query);
$stmt->bind_param("sss", $name, $email, $hashed_password);
$stmt->execute();

header("Location: settings.php?success=Account created successfully.");
exit();