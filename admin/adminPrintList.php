<?php
include "../php/auth_check.php";

// Get the user's name from session
$userName = $_SESSION['user_name'];

$pdfPath = "../temp/complete_requests.pdf";

// Check if file exists
if (!file_exists($pdfPath)) {
    die("The complete requests PDF does not exist.");
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
                <button class="back-btn" onclick="window.location.href='adminDocReq.php'">Go Back</button>
            </div>
            <!-- Embed complete_requests.pdf -->
            <div id="pdf-container">
                <object data="<?= $pdfPath ?>" type="application/pdf" width="100%" height="600px">
                    <p>Your browser does not support PDFs. <a href="<?= $pdfPath ?>">Download the PDF</a>.</p>
                </object>
            </div>
           
    </main>
  </div>
</body>
</html>
