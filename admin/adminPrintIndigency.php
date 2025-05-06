<?php
include "../php/auth_check.php";

// Get the user's name from session
$userName = $_SESSION['user_name'];

// Check if the 'id' query parameter is set
if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $pdfPath = "../temp/barangay_{$id}.pdf";  // Construct the PDF path
} else {
  // If no 'id' parameter is provided, show an error or redirect
  die("No ID specified.");
}

// Ensure the file exists
if (!file_exists($pdfPath)) {
  die("The requested PDF does not exist.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/adminDocReq_style.css" />
  <link rel="stylesheet" href="../styles/notifModal.css" />
  <script src="../js/" defer></script>
  <script src="../js/adminNav.js" defer></script>
</head>
<body>
  <!-- Navbar -->
  <?php include '../components/admin_nav.php'; ?>
<!-- Notification Modal -->
<?php include 'adminNotif.php'; ?>
 
  <div class="flex-container">
    <!-- Sidebar -->
    <?php include '../components/admin_side.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
    <div class="top-bar">
    <button class="back-btn" onclick="history.back()">Go Back</button>
            </div>

            <h2>Viewing PDF Document</h2>

            <!-- Embed the PDF in the page -->
            <div id="pdf-container">
                <?php if ($pdfPath): ?>
                    <object data="<?= $pdfPath ?>" type="application/pdf" width="100%" height="600px">
                        <p>Your browser does not support PDFs. <a href="<?= $pdfPath ?>">Download the PDF</a>.</p>
                    </object>
                <?php else: ?>
                    <p>PDF not found for this request.</p>
                <?php endif; ?>
            </div>
    </main>
  </div>
</body>
</html>
