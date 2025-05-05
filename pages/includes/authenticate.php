<?php
session_start();
include 'db-connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../../index.php');
    exit();
}

if (!isset($_SESSION['account_type'])) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT account_type FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die('Database error: ' . $conn->error);
    }
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['account_type'] = $row['account_type'];
    } else {
        header('Location: ../../index.php');
        exit();
    }
    $stmt->close();
}

if ($_SESSION['account_type'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}