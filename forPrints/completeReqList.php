<?php
require_once('libs/tcpdf/tcpdf.php');
include "../database/connect_db_reqwest.php";

// Get the year input if provided
$year = isset($_GET['year']) && !empty($_GET['year']) ? intval($_GET['year']) : null;

// Build the SQL with UNION ALL and wrap it in a subquery for ordering
if ($year) {
    $sql = "
    SELECT * FROM (
        SELECT
            first_name COLLATE utf8mb4_unicode_ci AS first_name,
            middle_name COLLATE utf8mb4_unicode_ci AS middle_name,
            last_name COLLATE utf8mb4_unicode_ci AS last_name,
            suffix COLLATE utf8mb4_unicode_ci AS suffix,
            date_requested,
            'Indigency' AS document_type,
            purpose COLLATE utf8mb4_unicode_ci AS purpose
        FROM indigency
        WHERE status = 'Completed' AND YEAR(date_requested) = {$year}

        UNION ALL

        SELECT
            first_name COLLATE utf8mb4_unicode_ci,
            middle_name COLLATE utf8mb4_unicode_ci,
            last_name COLLATE utf8mb4_unicode_ci,
            suffix COLLATE utf8mb4_unicode_ci,
            date_requested,
            'Residency' AS document_type,
            purpose COLLATE utf8mb4_unicode_ci
        FROM certresidency
        WHERE status = 'Completed' AND YEAR(date_requested) = {$year}

        UNION ALL

        SELECT
            first_name COLLATE utf8mb4_unicode_ci,
            middle_name COLLATE utf8mb4_unicode_ci,
            last_name COLLATE utf8mb4_unicode_ci,
            suffix COLLATE utf8mb4_unicode_ci,
            date_requested,
            'Good Moral' AS document_type,
            purpose COLLATE utf8mb4_unicode_ci
        FROM good_moral
        WHERE status = 'Completed' AND YEAR(date_requested) = {$year}

        UNION ALL

        SELECT
            first_name COLLATE utf8mb4_unicode_ci,
            middle_name COLLATE utf8mb4_unicode_ci,
            last_name COLLATE utf8mb4_unicode_ci,
            suffix COLLATE utf8mb4_unicode_ci,
            date_requested,
            'Barangay Permit' AS document_type,
            purpose COLLATE utf8mb4_unicode_ci
        FROM permit
        WHERE status = 'Completed' AND YEAR(date_requested) = {$year}
    ) AS combined
    ORDER BY date_requested DESC
    ";
} else {
    $sql = "
    SELECT * FROM (
        SELECT
            first_name COLLATE utf8mb4_unicode_ci AS first_name,
            middle_name COLLATE utf8mb4_unicode_ci AS middle_name,
            last_name COLLATE utf8mb4_unicode_ci AS last_name,
            suffix COLLATE utf8mb4_unicode_ci AS suffix,
            date_requested,
            'Indigency' AS document_type,
            purpose COLLATE utf8mb4_unicode_ci AS purpose
        FROM indigency
        WHERE status = 'Completed'

        UNION ALL

        SELECT
            first_name COLLATE utf8mb4_unicode_ci,
            middle_name COLLATE utf8mb4_unicode_ci,
            last_name COLLATE utf8mb4_unicode_ci,
            suffix COLLATE utf8mb4_unicode_ci,
            date_requested,
            'Residency' AS document_type,
            purpose COLLATE utf8mb4_unicode_ci
        FROM certresidency
        WHERE status = 'Completed'

        UNION ALL

        SELECT
            first_name COLLATE utf8mb4_unicode_ci,
            middle_name COLLATE utf8mb4_unicode_ci,
            last_name COLLATE utf8mb4_unicode_ci,
            suffix COLLATE utf8mb4_unicode_ci,
            date_requested,
            'Good Moral' AS document_type,
            purpose COLLATE utf8mb4_unicode_ci
        FROM good_moral
        WHERE status = 'Completed'

        UNION ALL

        SELECT
            first_name COLLATE utf8mb4_unicode_ci,
            middle_name COLLATE utf8mb4_unicode_ci,
            last_name COLLATE utf8mb4_unicode_ci,
            suffix COLLATE utf8mb4_unicode_ci,
            date_requested,
            'Barangay Permit' AS document_type,
            purpose COLLATE utf8mb4_unicode_ci
        FROM permit
        WHERE status = 'Completed'
    ) AS combined
    ORDER BY date_requested DESC
    ";
}

// Execute the query
$result = $conn->query($sql);

if (!$result) {
    die("Database query failed: " . $conn->error);
}

if ($result->num_rows == 0) {
    header("Location: /capstone/Capstone-DIT3-2/alertModals/modal_noList.php");
    exit;
}

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Barangay Office');
$pdf->SetTitle('Completed Barangay Requests');
$pdf->SetHeaderData('', 0, 'Completed Barangay Requests', '');
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 14));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->SetFont('times', '', 12);
$pdf->AddPage();

// Optional watermark / seal
$watermark = __DIR__ . '/../assets/brgy-logo-watermark.jpg';
if (file_exists($watermark)) {
    $pdf->SetAlpha(0.4); // Set transparency to 10%
    $pdf->Image($watermark, 60, 120, 90, 90, 'JPG', '', '', false, 300, '', false, false, 0);
    $pdf->SetAlpha(1); // Reset to fully opaque for subsequent content
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

$html = '<style>
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

<h2 style="text-align:center;">List of Completed Barangay Requests</h2>
<table border="1" cellspacing="0" cellpadding="7">
    <thead>
        <tr style="font-weight:bold; background-color:#f0f0f0;">
            <th width="25%">Name</th>
            <th width="25%">Date Requested</th>
            <th width="25%">Document Type</th>
            <th width="25%">Purpose</th>
        </tr>
    </thead>
    <tbody>
';

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
