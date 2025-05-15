<?php
include("../includes/db-connection.php");
function capitalizeWordsArray($array)
{
    return array_map(function ($item) {
        return ucwords(strtolower($item));
    }, $array);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = capitalizeWordsArray([$_POST['title']])[0];
    $country = capitalizeWordsArray([$_POST['country']])[0];
    $availability = capitalizeWordsArray([$_POST['availability']])[0];
    $description = $_POST['description'];

    $responsibilities_input = capitalizeWordsArray(json_decode($_POST['responsibilities'], true));
    $qualifications_input = capitalizeWordsArray(json_decode($_POST['qualifications'], true));


    $responsibilities = json_encode([
        'responsibilities' => $responsibilities_input
    ]);

    $qualifications = json_encode([
        'qualification' => $qualifications_input
    ]);


    // Handle file upload
    $img_ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
    $img = uniqid('job_', true) . '.' . $img_ext;
    $tmp = $_FILES['img']['tmp_name'];
    $img_path = "../assets/images/jobs_bin/" . $img;

    if (move_uploaded_file($tmp, $img_path)) {
        // Insert job without job_code
        $query = "INSERT INTO jobs (title, country, description, responsibilities, qualification, availability, img)
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        // Check if prepare failed
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "sssssss", $title, $country, $description, $responsibilities, $qualifications, $availability, $img);

        if (mysqli_stmt_execute($stmt)) {
            $inserted_id = mysqli_insert_id($conn);
            $generated_code = "SDJ-" . $inserted_id;

            // Update job_code using inserted ID
            $updateQuery = "UPDATE jobs SET job_code = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);

            if (!$updateStmt) {
                die("Update prepare failed: " . mysqli_error($conn));
            }

            mysqli_stmt_bind_param($updateStmt, "si", $generated_code, $inserted_id);
            mysqli_stmt_execute($updateStmt);

            header("Location: jobs.php?success=Job added successfully.");
            exit();
        } else {
            die("Execute failed: " . mysqli_stmt_error($stmt));
        }
    } else {
        header("Location: jobs.php?error=Image upload failed.");
        exit();
    }
}