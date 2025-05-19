<?php
include "../php/auth_check.php";
include "../database/connect_db_reqwest.php"; 

// Get the user's name from session
$userName = $_SESSION['user_name'];
$userId = $_SESSION['id'];
?>

<?php include '../php/get_unread_notifications.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminDocReq_style.css" />
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/adminDocReqLanding.css" />
  <link rel="stylesheet" href="../styles/notifModal.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-ZzzA..." crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="../js/admindDocReq_indigency_script.js"></script>
  <script src="../js/adminNav.js" defer></script>
  <script src="../js/unread_to_read_notif.js" defer></script>
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
  <label for="yearInput" class="top-bar-label">Year:</label>
  <form method="GET" action="../forPrints/completeReqList.php">
    <input type="number" id="yearInput" name="year" class="top-bar-input" placeholder="e.g. 2025" min="2000" max="2099" />
    <button type="submit" class="generate-button">Generate List</button>

    <!-- <button type="button" class="generate-button" onclick="printCompleteList()">
    Generate List
    </button> -->
  </form>

</div>
<div class="document-buttons-container">
  <div class="document-button">
    <i class="fa-solid fa-file document-icon"></i>
    <span>Certificate of Indigency</span>
    <button class="view-requests-button" onclick="window.location.href='adminDocReq_indigency.php'">View Requests</button>
  </div>

  <div class="document-button">
    <i class="fa-solid fa-clipboard-check document-icon"></i>
    <span>Barangay Permit</span>
    <button class="view-requests-button" onclick="window.location.href='adminDocReq_permit.php'">View Requests</button>
  </div>

  <div class="document-button">
    <i class="fa-solid fa-home document-icon"></i>
    <span>Certificate of Residency</span>
    <button class="view-requests-button" onclick="window.location.href='adminDocReq_residency.php'">View Requests</button>
  </div>

  <div class="document-button">
    <i class="fa-solid fa-user-check document-icon"></i>
    <span>Barangay Good Moral Certificate</span>
    <button class="view-requests-button" onclick="window.location.href='adminDocReq_good_moral.php'">View Requests</button>
  </div>
</div>

</main>
  </div>
</body>
</html>
