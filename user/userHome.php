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
        <a 
            <?php if ($hasPendingIndigency): ?>
            href="#"
            onclick="showRequestAlertIndigency(); return false;"
            <?php else: ?>
            href="userRequest_Indigency.php"
            <?php endif; ?>
            class="action-button"
        >
            <i class="fa-solid fa-file"></i>
            Request Certificate of Indigency
        </a>

        <a 
            <?php if ($hasPendingResidency): ?>
            href="#"
            onclick="showRequestAlertResidency(); return false;"
            <?php else: ?>
            href="userRequest_certResidency.php"
            <?php endif; ?>
            class="action-button"
        >
            <i class="fa-solid fa-home"></i>
            Request Certificate of Residency
        </a>

        <a 
            <?php if ($hasPendingPermit): ?>
            href="#"
            onclick="showRequestAlertPermit(); return false;"
            <?php else: ?>
            href="userRequest_permit.php"
            <?php endif; ?>
            class="action-button"
        >
            <i class="fa-solid fa-clipboard-check"></i>
            Request Barangay Permit
        </a>

        <a href="request_clearance.php" class="action-button">
            <i class="fa-solid fa-briefcase"></i>
            Request Barangay Business Clearance
        </a>
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
