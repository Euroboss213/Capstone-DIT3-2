<?php
include "../php/auth_check.php";
include "../database/connect_db_reqwest.php"; 

$userName = $_SESSION['user_name'];
$lastName = $_SESSION['last_name'] ?? '';
$firstName = $_SESSION['first_name'] ?? '';
$middleName = $_SESSION['middle_name'] ?? '';
$suffix = $_SESSION['suffix'] ?? '';
?>

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
  <link rel="stylesheet" href="../styles/alertModal_style.css">
  <link rel="stylesheet" href="../styles/request_form.css">
  <link rel="stylesheet" href="../styles/notifModal.css">
  <!--SCRIPTS-->
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
  <div class="form-container">
    <div class="form-header">
      <a href="javascript:history.back()" class="icon-back-button" aria-label="Go back">⮌</a>
      <h2>Barangay Good Moral Certificate Request Form</h2>
    </div>

    <form method="POST" action="../php/handle_request_goodMoral.php" enctype="multipart/form-data">
      <input type="hidden" name="document_type" value="Good Moral">

      <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>" readonly>
      </div>

      <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>" readonly>
      </div>

      <div class="form-group">
        <label for="middle_name">Middle Name:</label>
        <input type="text" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($middleName); ?>" readonly>
      </div>

      <div class="form-group">
        <label for="suffix">Suffix:</label>
        <input type="text" id="suffix" name="suffix" value="<?php echo htmlspecialchars($suffix); ?>" readonly>
      </div>

      <div class="form-group">
        <label for="purpose">Purpose of Request:</label>
        <textarea id="purpose" name="purpose" rows="4" required></textarea>
      </div>

      <div class="form-group">
        <label for="supporting_document">Supporting Document (Optional):</label>
        <input type="file" id="supporting_document" name="supporting_document" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
      </div>

      <div class="form-group submit-button">
        <button type="submit">Submit Request</button>
      </div>
    </form>
  </div>
</main>
  </div>
</body>
</html>
