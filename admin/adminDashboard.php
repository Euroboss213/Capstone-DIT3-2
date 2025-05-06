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
  <link rel="stylesheet" href="../styles/adminDashboard_style.css" />
  <link rel="stylesheet" href="../styles/notifModal.css" />
  <script src="../js/" defer></script>
  <script src="../js/adminNav.js" defer></script>
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
   
    </main>
  </div>
</body>
</html>
