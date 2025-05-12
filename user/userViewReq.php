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
  <!--STYLES-->
  <link rel="stylesheet" href="../styles/userTemplate.css" />
  <link rel="stylesheet" href="../styles/chatBot.css" />
  <link rel="stylesheet" href="../styles/autoChat.css">
  <link rel="stylesheet" href="../styles/userViewReq_style.css">
  <link rel="stylesheet" href="../styles/notifModal.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-ZzzA..." crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!--SCRIPTS-->
  <script src="../js/userHome_script.js" defer></script>
  <script src="../js/chatBot.js" defer></script>
  <script src="../js/autoChat.js" defer></script>
  <script src="../js/displayChats.js" defer></script>
  <script src="../js/unread_to_read_notif.js" defer></script>
</head>
<body>
 <!-- Navbar -->
 <?php include '../components/user_nav.php'; ?>
<!-- Notification Modal -->
  <?php include 'userNotif.php'; ?>
  <div class="flex-container">
  <!-- Sidebar -->
  <?php include '../components/user_side.php'; ?>

    <!-- Main Content -->
    <main class="main-content">
  <div class="document-buttons-container">
  <div class="document-button">
    <?php if ($hasUnread): ?>
      <span class="notif-dot" id="notifDot"></span>
    <?php endif; ?>
    <i class="fa-solid fa-file document-icon"></i>
    <span class="cert-text">Certificate of Indigency</span>
    <button class="view-requests-button" id="notifButton-unread" onclick="window.location.href='userViewReq_indigency.php'">View My Requests</button>
  </div>

  <div class="document-button">
    <i class="fa-solid fa-clipboard-check document-icon"></i>
    <span class="cert-text">Barangay Permit</span>
    <button class="view-requests-button" onclick="window.location.href=''">View My Requests</button>
  </div>

  <div class="document-button">
    <i class="fa-solid fa-home document-icon"></i>
    <span class="cert-text">Certificate of Residency</span>
    <button class="view-requests-button" onclick="window.location.href='userViewReq_certResidency.php'">View My Requests</button>
  </div>

  <div class="document-button">
    <i class="fa-solid fa-briefcase document-icon"></i>
    <span class="cert-text">Barangay Business Clearance</span>
    <button class="view-requests-button" onclick="window.location.href=''">View My Requests</button>
  </div>

</div>
 <!-- Chat Container -->
 <?php include '../components/user_chat.php'; ?>
</main>
  </div>
</body>
</html>
