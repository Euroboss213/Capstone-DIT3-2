<?php
include "../php/auth_check.php";
include "../database/connect_db_reqwest.php"; 

// Get the user's name from session
$userName = $_SESSION['user_name'];
$userId = $_SESSION['id'];


// Check for existing indigency request with Ongoing or For Pickup status
$hasPendingIndigency = false;
$query = "SELECT COUNT(*) as count FROM indigency WHERE user_id = ? AND status IN ('Ongoing', 'For Pickup')";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    $hasPendingIndigency = true;
}
?>

<?php include '../php/get_unread_notifications.php' ?>
<?php include "../alertModals/alertModal_Home.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <!--STYLES-->
  <link rel="stylesheet" href="../styles/userHome_style.css" />
  <link rel="stylesheet" href="../styles/userTemplate.css" />
  <link rel="stylesheet" href="../styles/chatBot.css" />
  <link rel="stylesheet" href="../styles/autoChat.css">
  <link rel="stylesheet" href="../styles/alertModal_style.css">
  <link rel="stylesheet" href="../styles/notifModal.css">
  <!--SCRIPTS-->
  <script src="../js/userHome_script.js" defer></script>
  <script src="../js/chatBot.js" defer></script>
  <script src="../js/autoChat.js" defer></script>
  <script src="../js/displayChats.js" defer></script>
  <script src="../js/alerts.js" defer></script>
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
    <a 
    <?php if ($hasPendingIndigency): ?>
    href="#"
    onclick="showRequestAlert(); return false;"
    <?php else: ?>
    href="userRequest_Indigency.php"
    <?php endif; ?>
    class="action-button"
    >
    Request Certificate of Indigency
    </a>

    <a href="request_residency.php" class="action-button">Request Certificate of Residency</a>
    <a href="request_permit.php" class="action-button">Request Barangay Permit</a>
    <a href="request_clearance.php" class="action-button">Request Barangay Business Clearance</a>
</div>

      <!-- Image Container -->
      <div class="image-container">
        <img src="../assets/step.png" alt="Your Image" class="image" />
      </div>
      <!-- Chat Container -->
      <?php include '../components/user_chat.php'; ?>
    </main>
  </div>
</body>
</html>
