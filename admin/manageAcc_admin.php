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
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/notifModal.css" />
  <link rel="stylesheet" href="../styles/manageAcc_style.css">

  <script src="../js/" defer></script>
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
    <section class="user-credentials-form">
    <form action="../php/update_credentials.php" method="POST">
      <h2 class="form-title">Manage Account</h2>

      <div class="form-group">
        <label for="existing_username">Existing Username</label>
        <input type="text" id="existing_username" name="existing_username" class="form-input" value="<?php echo htmlspecialchars($_SESSION['userName']); ?>" readonly />
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
