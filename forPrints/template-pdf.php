<?php
require_once('libs/tcpdf/tcpdf.php');
include "../database/connect_db_reqwest.php";

// Validate ID and type from the URL
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("Missing parameters.");
}

$id = intval($_GET['id']);
$type = $_GET['type']; // e.g., 'indigency' or 'certResidency'

// Whitelist table names for security
$allowedTables = ['indigency', 'certresidency', 'good_moral', 'permit'];

if (!in_array($type, $allowedTables)) {
    die("Invalid document type.");
}

// Dynamic table name based on type
$table = $conn->real_escape_string($type);
$sql = "SELECT * FROM `$table` WHERE id = $id";

$result = $conn->query($sql);
if ($result->num_rows == 0) {
    die("Request not found.");
}

$row = $result->fetch_assoc();
if (is_null($row)) {
    die("No data found for the given ID.");
}

$fullName = htmlspecialchars($row['first_name'] . ' ' . ($row['middle_name'] ? $row['middle_name'] . ' ' : '') . $row['last_name'] . ($row['suffix'] ? ', ' . $row['suffix'] : ''));
$purpose = htmlspecialchars($row['purpose']);
$docType = htmlspecialchars($row['document_type']);
$date = htmlspecialchars($row['date_requested']);

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Barangay Office');
$pdf->SetTitle("Barangay Certificate of $docType");
$pdf->SetHeaderData('', 0, "Barangay Certificate of $docType", '');

$pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', 14]);
$pdf->setFooterFont([PDF_FONT_NAME_DATA, '', 10]);
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->AddPage();

$html = "
<h2 style='text-align:center;'>Barangay Certificate of $docType</h2>
<p>This is to certify that:</p>
<h3>$fullName</h3>
<p>has requested a Barangay document for the purpose of:</p>
<p><strong>$purpose</strong></p>
<p>Date Requested: $date</p>
<br><br>
<p style='text-align:right;'>Authorized Signature</p>
";

$pdf->writeHTML($html, true, false, true, false, '');
$pdfPath = __DIR__ . "/../temp/barangay_{$type}_$id.pdf";
$pdf->Output($pdfPath, 'F');

// Redirect back to the appropriate modal/view page
header("Location: /capstone/Capstone-DIT3-2/admin/adminPrint{$type}.php?id={$type}_{$id}");
exit;
?>
