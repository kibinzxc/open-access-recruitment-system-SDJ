<?php
include("../includes/db-connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM jobs WHERE id = $id";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Decode responsibilities and qualifications
        $responsibilities = json_decode($row['responsibilities'], true);
        $qualifications = json_decode($row['qualifications'], true);

        // Replace original fields with the decoded arrays
        $row['responsibilities'] = $responsibilities['responsibilities'] ?? [];
        $row['qualifications'] = $qualifications['qualifications'] ?? [];

        echo json_encode($row);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Job not found']);
    }
}