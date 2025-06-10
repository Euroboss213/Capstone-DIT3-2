<?php
require_once('libs/tcpdf/tcpdf.php');
include "../database/connect_db_reqwest.php";

// Validate ID and type
if (!isset($_GET['id']) || !isset($_GET['type'])) {
    die("Missing parameters.");
}

$id = intval($_GET['id']);
$type = $_GET['type'];

// Get status from the database
$stmt = $conn->prepare("SELECT status FROM indigency WHERE id = ?");
$stmt->bind_param("i", $requestId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// if (!$row || $row['status'] !== 'For Pickup') {
//     echo "<script>alert('PDF generation not allowed. Status must be \"For Pickup\".'); window.history.back();</script>";
//     exit;
// }


$allowedTables = ['indigency', 'certresidency', 'good_moral', 'permit'];
if (!in_array($type, $allowedTables)) {
    die("Invalid document type.");
}

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

// Format applicant name
$fullName = htmlspecialchars(
    $row['first_name'] . ' ' .
    ($row['middle_name'] ? $row['middle_name'] . ' ' : '') .
    $row['last_name'] .
    ($row['suffix'] ? ', ' . $row['suffix'] : '')
);

// Format date and purpose
$escapedPurpose = htmlspecialchars($row['purpose']);
$formattedDate = date("F j, Y", strtotime($row['date_requested']));

// Document title map
$documentTitles = [
    'indigency' => 'CERTIFICATE OF INDIGENCY',
    'certresidency' => 'CERTIFICATE OF RESIDENCY',
    'good_moral' => 'CERTIFICATE OF GOOD MORAL CHARACTER',
    'permit' => 'BARANGAY PERMIT',
];
$certTitle = $documentTitles[$type] ?? 'BARANGAY CERTIFICATE';

// Dynamic body content
$bodyContent = '';
switch ($type) {
    case 'indigency':
        $bodyContent = "
        This is to certify that <strong>{$fullName}</strong>, Filipino, is a resident of 
        <strong>BARANGAY WEST KAMIAS, QUEZON CITY</strong>, and belongs to one of the many indigent families 
        of this barangay. The income of this family is barely enough to meet their day-to-day needs.<br/><br/>
        This certification is being issued to the subject resident for the purpose of 
        <strong>{$escapedPurpose}</strong>.
        ";
        break;

    case 'certresidency':
        $bodyContent = "
        This is to certify that <strong>{$fullName}</strong>, Filipino, is a resident of 
        <strong>BARANGAY WEST KAMIAS, QUEZON CITY</strong> and has been residing here continuously for the past years.<br/><br/>
         This certification is being issued to the subject resident for the purpose of  <strong>{$escapedPurpose}</strong>.
        ";
        break;

    case 'good_moral':
        $bodyContent = "
        This is to certify that <strong>{$fullName}</strong>, Filipino, resident of 
        <strong>BARANGAY WEST KAMIAS, QUEZON CITY</strong>, is known to be of good moral character, law-abiding, and has no derogatory records filed in this barangay.<br/><br/>
        This certification is being issued to the subject resident for the purpose of <strong>{$escapedPurpose}</strong>.
        ";
        break;

    case 'permit':
        $bodyContent = "
        This is to certify that <strong>{$fullName}</strong> has secured the necessary clearance and is granted this permit by the Barangay West Kamias.<br/><br/>
         This certification is being issued to the subject resident for the purpose of <strong>{$escapedPurpose}</strong>.
        ";
        break;

    default:
        $bodyContent = "
        This certifies that <strong>{$fullName}</strong> is a bonafide resident of Barangay West Kamias, Quezon City.<br/><br/>
        Issued for the purpose of <strong>{$escapedPurpose}</strong>.
        ";
        break;
}

// Create PDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Barangay West Kamias');
$pdf->SetTitle('Barangay Document');
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->SetFont('times', '', 12);
$pdf->AddPage();

// Optional watermark / seal
$watermark = __DIR__ . '/../assets/brgy-logo-watermark.jpg';
if (file_exists($watermark)) {
    $pdf->Image($watermark, 60, 90, 90, 90, 'JPG', '', '', false, 300, '', false, false, 0);
}

// Logos
$leftLogo = __DIR__ . '/../assets/QC-LOGO.jpg';
$rightLogo = __DIR__ . '/../assets/brgy-logo-jpg.jpg';

if (file_exists($leftLogo)) {
    $pdf->Image($leftLogo, 20, 25, 30); // left margin x=20, y=20, width=30mm
}

if (file_exists($rightLogo)) {
    $pdf->Image($rightLogo, 160, 25, 30); // right margin x=160 (depends on page width), y=20, width=30mm
}

// Build HTML
$html = '
<style>
    .header-title { text-align: center; font-size: 16px; font-weight: bold; }
    .sub-header { text-align: center; font-size: 12px; }
    .cert-title { text-align: center; font-size: 18px; font-weight: bold; margin-top: 10px; text-decoration: underline; }
    .content { text-align: justify; font-size: 12px; line-height: 1.6; margin-top: 20px; }
    .signature { text-align: right; margin-top: 50px; }
    .issue-date { margin-top: 20px; font-size: 12px; }
    .footer-note { text-align: center; font-size: 9px; margin-top: 40px; color: #555; }
</style>

<table>
    <tr>
        <td width="20%">
            
        </td>
        <td width="60%" style="text-align:center;">
            <div class="header-title">REPUBLIC OF THE PHILIPPINES</div>
            <div class="header-title" style="color:red;">BARANGAY WEST KAMIAS</div>
            <div class="sub-header">TANGGAPAN NG PUNONG BARANGAY</div>
            <div class="sub-header">#2 K-10<sup>th</sup> Street, West Kamias, Diliman III Area 14, Quezon City 1102</div>
            <div class="sub-header">Tel. no: 8350-66-55</div>
        </td>
        <td width="20%" align="right">
            
        </td>
    </tr>
</table>

<div class="cert-title">' . $certTitle . '</div>

<p class="content">' . $bodyContent . '</p>

<p class="issue-date">
    Requested on <strong>' . $formattedDate . '</strong><br/>
    Issued this <strong> _______ </strong> day of <strong>____________</strong> 
    at Barangay West Kamias, Quezon City.
</p>

<div class="signature">
    <strong>____________________</strong><br/>
    Punong Barangay
</div>

<div class="footer-note">
    Valid for 6 months only<br/>
    Not valid without official seal
</div>
';

$pdf->writeHTML($html, true, false, true, false, '');

// Save PDF and redirect
$pdfPath = __DIR__ . "/../temp/barangay_{$type}_$id.pdf";
$pdf->Output($pdfPath, 'F');

// Redirect to viewer
header("Location: /capstone/Capstone-DIT3-2/admin/adminPrint{$type}.php?id={$type}_{$id}");
exit;
?>
