<?php
require_once('libs/tcpdf/tcpdf.php');
include "../database/connect_db_reqwest.php";

// Get the year input if provided
$year = isset($_GET['year']) && !empty($_GET['year']) ? intval($_GET['year']) : null;

if($year) {
    $sql = "SELECT * FROM indigency WHERE status = 'completed' AND YEAR(date_requested) = $year ORDER BY date_requested DESC";
} else {
    $sql = "SELECT * FROM indigency WHERE status = 'completed' ORDER BY date_requested DESC";
}

// Fetch all requests with status 'complete'

$result = $conn->query($sql);

if ($result->num_rows == 0) {
    header("Location: /capstone/Capstone-DIT3-2/alertModals/modal_noList.php");
    exit;
}

// Create new PDF document
$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Barangay Office');
$pdf->SetTitle('Completed Barangay Requests');
$pdf->SetHeaderData('', 0, 'Completed Barangay Requests', '');

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 14));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->AddPage();

$html = "
<h2 style='text-align:center;'>List of Completed Barangay Requests</h2>
<table border='1' cellspacing='0' cellpadding='5'>
    <thead>
        <tr style='font-weight:bold; background-color:#f0f0f0;'>
            <th width='25%'>Name</th>
            <th width='20%'>Date Requested</th>
            <th width='20%'>Document Type</th>
            <th width='35%'>Purpose</th>
        </tr>
    </thead>
    <tbody>
";

// Populate table with data
while ($row = $result->fetch_assoc()) {
    $name = htmlspecialchars(
        $row['first_name'] . ' ' .
        ($row['middle_name'] ? $row['middle_name'] . ' ' : '') .
        $row['last_name'] .
        ($row['suffix'] ? ', ' . $row['suffix'] : '')
    );
    $date = htmlspecialchars($row['date_requested']);
    $docType = htmlspecialchars($row['document_type']);
    $purpose = htmlspecialchars($row['purpose']);

    $html .= "
        <tr>
            <td>$name</td>
            <td>$date</td>
            <td>$docType</td>
            <td>$purpose</td>
        </tr>
    ";
}

$html .= "
    </tbody>
</table>
";

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output(__DIR__ . "/../temp/complete_requests.pdf", 'F');

// Redirect or prompt download
header('Location: /capstone/Capstone-DIT3-2/admin/adminPrintList.php');
exit;
?>
