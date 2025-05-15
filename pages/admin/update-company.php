<?php
include("../includes/db-connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['details'])) {
    foreach ($_POST['details'] as $id => $detail) {
        $cleaned = htmlspecialchars(trim($detail));
        $query = "UPDATE company_details SET details = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $cleaned, $id);
        $stmt->execute();
    }
    header("Location: settings.php?success=Company details updated successfully.");
    exit();
} else {
    header("Location: settings.php?error=Invalid submission.");
    exit();
}