<?php
include "../php/auth_check.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    // Not an admin, redirect or show access denied
    header('Location: ../pages/newlogin.php');
    exit();
}

// Get the 'id' parameter from URL, expected format: "{type}_{id}", e.g. "indigency_5"
if (isset($_GET['id'])) {
    $id = $_GET['id']; // e.g. indigency_5

    // Server path to the PDF file (for file_exists check)
    $pdfPath = __DIR__ . "/../temp/barangay_{$id}.pdf";

    // Public URL path for embedding in the <object> tag
    $pdfUrl = "/capstone/Capstone-DIT3-2/temp/barangay_{$id}.pdf";

} else {
    die("No ID specified.");
}

// Check if the PDF file actually exists on the server
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

        <!-- Embed the PDF in the page -->
      <div id="pdf-container">
        <object data="<?= htmlspecialchars($pdfUrl) ?>" type="application/pdf" width="100%" height="600px">
          <p>Your browser does not support PDFs. <a href="<?= htmlspecialchars($pdfUrl) ?>">Download the PDF</a>.</p>
        </object>
      </div>

    </main>
  </div>
</body>
</html>
