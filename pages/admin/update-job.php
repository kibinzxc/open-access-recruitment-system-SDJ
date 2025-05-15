<?php
include("../includes/db-connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $availability = mysqli_real_escape_string($conn, $_POST['availability']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $oldImage = $_POST['old_image'] ?? '';

    // Decode JSON arrays
    $responsibilities = json_decode($_POST['responsibilities'], true);
    $qualifications = json_decode($_POST['qualifications'], true);

    $responsibilitiesJson = json_encode(["responsibilities" => $responsibilities]);
    $qualificationsJson = json_encode(["qualification" => $qualifications]);

    // Image processing
    $newImageName = $oldImage;
    $image = $_FILES['image'];

    if (!empty($image['name'])) {
        $uploadDir = '../assets/images/jobs_bin/';
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $newImageName = uniqid('job_', true) . '.' . $ext;
        $targetFile = $uploadDir . $newImageName;

        if (move_uploaded_file($image['tmp_name'], $targetFile)) {
            // Delete old image
            if (!empty($oldImage) && file_exists($uploadDir . $oldImage)) {
                unlink($uploadDir . $oldImage);
            }
        } else {
            $errorMessage = urlencode("Failed to upload new image.");
            header("Location: edit-job.php?id=$id&error=$errorMessage");
            exit();
        }
    }

    // Update query
    $query = "
        UPDATE jobs 
        SET 
            title = '$title', 
            country = '$country', 
            availability = '$availability', 
            description = '$description', 
            responsibilities = '$responsibilitiesJson', 
            qualification = '$qualificationsJson',
            img = '$newImageName'
        WHERE id = $id
    ";

    if (mysqli_query($conn, $query)) {
        $successMessage = urlencode("Job updated successfully.");
        header("Location: jobs.php?success=$successMessage");
        exit();
    } else {
        $errorMessage = urlencode("Database error: " . mysqli_error($conn));
        header("Location: edit-job.php?id=$id&error=$errorMessage");
        exit();
    }
} else {
    $errorMessage = urlencode("Invalid request method.");
    header("Location: jobs.php?error=$errorMessage");
    exit();
}