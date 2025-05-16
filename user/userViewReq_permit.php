<?php
include "../php/auth_check.php";

// Get the user's name from session
$userName = $_SESSION['user_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <!--STYLES-->
  <link rel="stylesheet" href="../styles/userViewReq_permit_style.css" />
  <link rel="stylesheet" href="../styles/userTemplate.css" />
  <link rel="stylesheet" href="../styles/chatBot.css" />
  <link rel="stylesheet" href="../styles/autoChat.css">
  <link rel="stylesheet" href="../styles/status.css" />
  <link rel="stylesheet" href="../styles/notifModal.css">

  <!--SCRIPTS-->
  <script src="../js/status.js" defer></script>
  <script src="../js/userHome_script.js" defer></script>
  <script src="../js/chatBot.js" defer></script>
  <script src="../js/autoChat.js" defer></script>
  <script src="../js/displayChats.js" defer></script>
  <script src="../js/unread_to_read_notif.js" defer></script>
</head>
<body>
   <!-- Navbar -->
   <?php include '../components/user_nav.php'; ?>
<div class="flex-container">
   <!-- Notification Modal -->
   <?php include 'userNotif.php'; ?>
  <!-- Sidebar -->
  <?php include '../components/user_side.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
      <!-- Main Content -->
    <main class="main-content">
    <div class="top-bar">
    <select id="statusFilter" class="filter-dropdown" onchange="filterByStatus()">
    <option value="">All Statuses</option>
    <option value="Ongoing">Ongoing</option>
    <option value="Approved">Approved</option>
    <option value="Returned">Returned</option>
    <option value="For Pickup">For Pickup</option>
    <option value="Completed">Completed</option>
  </select>
  <button class="back-btn" onclick="history.back()">Go Back</button>
</div>

      <div id="indigency" class="table-container" style="display: block;">
        <?php include '../DocsModals/usersDocModal_permit.php'; ?>
      </div>
      <?php include '../components/user_chat.php'; ?>
</main>
  </div>
</body>
</html>
