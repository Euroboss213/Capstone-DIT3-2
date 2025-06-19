<?php
include "../php/auth_check.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Not an admin, redirect or show access denied
    header('Location: ../pages/newlogin.php');
    exit();
}

// Get the user's name from session
$userName = $_SESSION['user_name'];

?>

<?php include '../php/get_unread_notifications.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>

  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/formModal_style.css" />
  <link rel="stylesheet" href="../styles/status.css" />
  <link rel="stylesheet" href="../styles/notifModal.css" />
  <link rel="stylesheet" href="../styles/adminDocReq_goodMoral_style.css" />
  <link rel="stylesheet" href="../styles/history.css" />
  
  <script src="../js/adminNav.js" defer></script>
  <script src="../js/adminDocReq_goodMoral_script.js" defer></script>
  <script src="../js/status.js" defer></script>
  <script src="../js/unread_to_read_notif.js" defer></script>
  <script src="../js/history_modal.js" defer></script>
  
</head>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
    <input type="text" id="searchInput" placeholder="Search indigency requests..." class="search-bar" onkeyup="filterTable()" />
    <select id="statusFilter" class="filter-dropdown" onchange="filterByStatus()">
    <option value="">All Statuses</option>
    <option value="Ongoing">Ongoing</option>
    <option value="Approved">Approved</option>
    <option value="Returned">Returned</option>
    <option value="For Pickup">For Pickup</option>
    <option value="Completed">Completed</option>
  </select>
  <button class="back-btn" onclick="window.location.href='adminDocReq.php'">Go Back</button>
</div>

      <div id="indigency" class="table-container" style="display: block;">
        <?php include '../docsModals/goodMoralDocModal.php'; ?>
      </div>

</main>
  </div>
</body>
</html>
