<?php
require_once('libs/tcpdf/tcpdf.php');
include "../database/connect_db_reqwest.php";

// Debugging: Check if 'id' is passed via the URL
// if (!isset($_GET['id']) || empty($_GET['id'])) {
//     die("No request ID provided.");
// } else {
//     echo "ID from URL: " . $_GET['id'] . "<br>";
// }

$id = intval($_GET['id']);
$sql = "SELECT * FROM indigency WHERE id = $id";

// Debugging: Show SQL query
// echo "SQL Query: " . $sql . "<br>";

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Request not found.");
} else {
    // echo "Number of rows found: " . $result->num_rows . "<br>";
}

$row = $result->fetch_assoc();

// Debugging: Show the contents of $row
// echo "<pre>";
// print_r($row);
// echo "</pre>";

// Check if the data exists before accessing array values
if (is_null($row)) {
    die("Database returned no data for the given ID.");
}

$fullName = htmlspecialchars($row['first_name'] . ' ' . ($row['middle_name'] ? $row['middle_name'] . ' ' : '') . $row['last_name'] . ($row['suffix'] ? ', ' . $row['suffix'] : ''));
$purpose = htmlspecialchars($row['purpose']);
$docType = htmlspecialchars($row['document_type']);
$date = htmlspecialchars($row['date_requested']);

// Create PDF
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Barangay Office');
$pdf->SetTitle('Barangay Document');
$pdf->SetHeaderData('', 0, 'Barangay Document', '');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 14));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
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

// Debugging: Show the HTML content
// echo "<hr>";
// echo "HTML Content: <br>";
// echo $html;
// echo "<hr>";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output(__DIR__ . "/../temp/barangay_$id.pdf", 'F');
 // Save to a temporary file

header('Location: /capstone/Capstone-DIT3-2/admin/adminPrintIndigency.php?id=' . $id);
exit;
?>
