<?php
include "../php/auth_check.php";
include "../database/connect_db_reqwest.php"; 

// Get the user's name from session
$userName = $_SESSION['user_name'];
$userId = $_SESSION['id'];

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
  <link rel="stylesheet" href="../styles/notifModal.css">
  <link rel="stylesheet" href="../styles/manageAcc_style.css">
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
  <section class="user-credentials-form">
    <form action="update_credentials.php" method="POST">
      <h2 class="form-title">Manage Account</h2>

      <div class="form-group">
        <label for="existing_username">Existing Username</label>
        <input type="text" id="existing_username" name="existing_username" class="form-input" value="alen@gmail.com" readonly />
      </div>

      <div class="form-group">
        <label for="new_username">New Username</label>
        <input type="text" id="new_username" name="new_username" class="form-input" placeholder="Enter new Username" />
      </div>

      <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" id="new_password" name="new_password" class="form-input" placeholder="Enter new Password" />
      </div>

      <div class="form-group">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" class="form-input" placeholder="Confirm new Password" />
      </div>

      <div class="form-group">
        <button type="submit" class="form-button">Save Changes</button>
      </div>
    </form>
  </section>
</main>
  </div>
</body>
</html>
