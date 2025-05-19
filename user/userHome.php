<?php
include "../php/auth_check.php";
include "../database/connect_db_reqwest.php"; 

// Get the user's name from session
$userName = $_SESSION['user_name'];
$userId = $_SESSION['id'];

// Function to check pending requests
function hasPendingRequest($conn, $userId, $table) {
    $query = "SELECT COUNT(*) as count FROM $table WHERE user_id = ? AND status IN ('Ongoing', 'For Pickup')";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['count'] > 0;
}

// Checking for pending requests using the function
$hasPendingIndigency = hasPendingRequest($conn, $userId, 'indigency');
$hasPendingResidency = hasPendingRequest($conn, $userId, 'certResidency');
$hasPendingPermit = hasPendingRequest($conn, $userId, 'permit');
$hasPendingGoodMoral = hasPendingRequest($conn, $userId, 'good_moral');
?>


<?php include '../php/get_unread_notifications.php'; ?>
<?php include "../alertModals/alertModal_Home.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <!-- STYLES -->
  <link rel="stylesheet" href="../styles/userHome_style.css" />
  <link rel="stylesheet" href="../styles/userTemplate.css" />
  <link rel="stylesheet" href="../styles/chatBot.css" />
  <link rel="stylesheet" href="../styles/autoChat.css">
  <link rel="stylesheet" href="../styles/alertModal_style.css">
  <link rel="stylesheet" href="../styles/notifModal.css">
  <link rel="stylesheet" href="../styles/helpModal.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />
  <script src="../js/userHome_script.js" defer></script>
  <script src="../js/chatBot.js" defer></script>
  <script src="../js/autoChat.js" defer></script>
  <script src="../js/displayChats.js" defer></script>
  <script src="../js/alerts.js" defer></script>
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
  <div class="button-grid">
    <!-- Certificate of Indigency -->
    <div class="request-card">
      <div class="request-card-header">
        <div class="icon-box">
          <i class="fa-solid fa-file"></i>
        </div>
        <h3>Certificate of Indigency</h3>
      </div>
       <button class="question-icon" onclick="openHelpModal('helpIndigency')">?</button>
      <div class="request-card-actions">
        <?php if ($hasPendingIndigency): ?>
          <button onclick="showRequestAlertIndigency()">Request</button>
        <?php else: ?>
          <a href="userRequest_Indigency.php" class="btn">Request</a>
        <?php endif; ?>
        <a href="userViewReq_Indigency.php" class="btn">View My Request</a>
      </div>
    </div>

    <!-- Certificate of Residency -->
    <div class="request-card">
      <div class="request-card-header">
        <div class="icon-box">
          <i class="fa-solid fa-home"></i>
        </div>
        <h3>Certificate of Residency</h3>
      </div>
       <button class="question-icon" onclick="openHelpModal('helpResidency')">?</button>
      <div class="request-card-actions">
        <?php if ($hasPendingResidency): ?>
          <button onclick="showRequestAlertResidency()">Request</button>
        <?php else: ?>
          <a href="userRequest_residency.php" class="btn">Request</a>
        <?php endif; ?>
        <a href="userViewReq_residency.php" class="btn">View My Request</a>
      </div>
    </div>

    <!-- Barangay Permit -->
    <div class="request-card">
      <div class="request-card-header">
        <div class="icon-box">
          <i class="fa-solid fa-clipboard-check"></i>
        </div>
        <h3>Barangay Permit</h3>
      </div>
       <button class="question-icon" onclick="openHelpModal('helpPermit')">?</button>
      <div class="request-card-actions">
        <?php if ($hasPendingPermit): ?>
          <button onclick="showRequestAlertPermit()">Request</button>
        <?php else: ?>
          <a href="userRequest_permit.php" class="btn">Request</a>
        <?php endif; ?>
        <a href="userViewReq_permit.php" class="btn">View My Request</a>
      </div>
    </div>

    <!-- Good Moral Certificate -->
    <div class="request-card">
      <div class="request-card-header">
        <div class="icon-box">
          <i class="fa-solid fa-user-check"></i>
        </div>
        <h3>Barangay Good Moral Certificate</h3>
      </div>
       <button class="question-icon" onclick="openHelpModal('helpGoodMoral')">?</button>
      <div class="request-card-actions">
        <?php if ($hasPendingGoodMoral): ?>
          <button onclick="showRequestAlertGoodMoral()">Request</button>
        <?php else: ?>
          <a href="userRequest_good_moral.php" class="btn">Request</a>
        <?php endif; ?>
        <a href="userViewReq_good_moral.php" class="btn">View My Request</a>
      </div>
    </div>
  </div>
<?php include "usersHelpModal.php"; ?>
  <!-- Chat Container -->
  <?php include '../components/user_chat.php'; ?>
</main>

  </div>
</body>
</html>
