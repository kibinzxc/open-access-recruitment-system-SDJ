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
        $pdf->Ln(30); // Add some space after the logo
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Message Details', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(0, 6, 'From: ' . $row['email'], 0, 1, 'C');
        $pdf->SetFont('Arial', '', 14);
        $pdf->Ln(10); // Add some space after the logo

        $pdf->SetFillColor(230, 230, 230); // Light gray for shading
        $pdf->SetFont('Arial', '', 12);

        // Row 1 - Name
        $pdf->Cell(50, 10, 'Name:', 'T', 0, 'L', true);
        $pdf->Cell(0, 10, $row['f_name'] . ' ' . $row['l_name'], 'T', 1, 'L', true);

        // Row 2 - Email
        $pdf->Cell(50, 10, 'Email:', 0, 0, 'L', false); // Even row not shaded
        $pdf->Cell(0, 10, $row['email'], 0, 1, 'L', false);


        // Row 3 - Date Sent
        $pdf->Cell(50, 10, 'Date Sent:', 'B', 0, 'L', true);
        $pdf->Cell(0, 10, date("F j, Y g:i A", strtotime($row['date_sent'])), 'B', 1, 'L', true);
        // Row 3 - Message
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->SetTextColor(65, 43, 173); // Set text color to RGB (65, 43, 173)
        $pdf->Ln(2); // Add a line break
        $pdf->Cell(0, 10, 'Message:', 0, 1, 'L');
        $pdf->SetTextColor(0, 0, 0); // Reset text color to black

        $pdf->SetFont('Arial', '', 12);
        $pdf->MultiCell(0, 10, $row['msg'], 0, 'C');

        //add horizontal line
        $pdf->Ln(5); // Add a line break
        $pdf->SetDrawColor(0, 0, 0); // Set line color to black (default color)
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY()); // Draw line from left to right

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
