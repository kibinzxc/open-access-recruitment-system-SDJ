<?php
include("../includes/authenticate.php");
require __DIR__ . '/../libs/vendor/autoload.php';

// Start output buffering to prevent any output before headers
ob_start();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $updateQuery = "UPDATE messages SET status = 'read' WHERE msg_id = $id";
    mysqli_query($conn, $updateQuery);

    $query = "SELECT * FROM messages WHERE msg_id = $id";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        ob_end_clean(); // Clean the buffer before outputting an error
        die("Database query failed: " . mysqli_error($conn));
    }

    if ($row = mysqli_fetch_assoc($result)) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->Image('../assets/images/sdj-icon2.png', ($pdf->GetPageWidth() - 45) / 2, 10, 45); // Center horizontally, adjust size and position as needed
        $pdf->Ln(25); // Add some space after the logo
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Message Details', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'From: ' . $row['email'], 0, 1, 'C');
        $pdf->Cell(0, 6, 'Date: ' . date("F j, Y g:i A", strtotime($row['date_sent'])), 0, 1, 'C');
        $pdf->Ln(15); // Add a line break
        $pdf->SetFont('Arial', '', 14);

        $pdf->Cell(0, 10, 'Name: ' . $row['f_name'] . ' ' . $row['l_name'], 0, 1);
        $pdf->Cell(0, 10, 'Email: ' . $row['email'], 0, 1);
        $pdf->MultiCell(0, 8, "Message:\n" . $row['msg'], 0, 1);

        // Clean the output buffer before sending headers
        ob_end_clean();

        // Set headers to force download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="message_' . $id . '.pdf"');

        // Output the PDF
        $pdf->Output();
        exit;
    } else {
        ob_end_clean(); // Clean the buffer before outputting an error
        echo "Message not found.";
    }
} else {
    ob_end_clean(); // Clean the buffer before outputting an error
    echo "Invalid request.";
}