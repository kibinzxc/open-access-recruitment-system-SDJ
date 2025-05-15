<?php
include("../includes/db-connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Decode raw arrays
    $responsibilities = json_decode($_POST['responsibilities'], true);
    $qualifications = json_decode($_POST['qualifications'], true);

    // Save the raw array as JSON
    $responsibilitiesJson = json_encode(["responsibilities" => $responsibilities]);
    $qualificationsJson = json_encode(["qualification" => $qualifications]);

    $query = "
        UPDATE jobs 
        SET 
            title = '$title', 
            country = '$country', 
            availability = '$availability', 
            description = '$description', 
            responsibilities = '$responsibilitiesJson', 
            qualification = '$qualificationsJson' 
        WHERE id = $id
    ";

    if (mysqli_query($conn, $query)) {
        $successMessage = urlencode("Job updated successfully.");
        header("Location: jobs.php?id=$id&success=$successMessage");
        exit();
    } else {
        $errorMessage = urlencode("Database error: " . mysqli_error($conn));
        header("Location: jobs.php?id=$id&error=$errorMessage");
        exit();
    }
} else {
    $errorMessage = urlencode("Invalid request method.");
    header("Location: jobs.php?error=$errorMessage");
    exit();
}