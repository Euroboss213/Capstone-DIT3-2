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
  <link rel="stylesheet" href="../styles/adminDocReq_style.css" />
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/adminDocReqLanding.css" />

  <script src="../js/admindDocReq_indigency_script.js"></script>
  <script src="../js/adminNav.js" defer></script>
  <script src="../js/unread_to_read_notif.js" defer></script>
</head>
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo-container">
      <img src="../assets/logo.png" alt="REQWEST Logo" class="logo-img" />
      <div class="barangay-name">
        <span class="barangay">Barangay West Kamias</span>
        <span class="city">Quezon City</span>
      </div>
    </div>
    <div class="profile-menu">
      <button id="profileButton" class="profile-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </button>
      <div id="dropdownMenu" class="dropdown-menu">
        <a href="#" class="dropdown-item">Change Password</a>
        <a href="../pages/newlogin.php" class="dropdown-item">Logout</a>
      </div>
    </div>
  </nav>

  <div class="flex-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="user-name">Admin Account</h2>
      <button id="dashboard" class="side-button" onclick="window.location.href='adminDashboard.php'">Dashboard</button>
      <button id="doc-req" class="side-button" onclick="window.location.href='adminDocReq.php'">Document Requests</button>
      <button id="registered-residents" class="side-button" onclick="window.location.href='adminResidents.php'">Registered Residents</button>
      <button id="user-accounts" class="side-button" onclick="window.location.href='adminUserAccounts.php'">User Accounts</button>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
    <div class="top-bar">
  <label for="yearInput" class="top-bar-label">Year:</label>
  <form method="GET" action="../forPrints/completeReqList.php">
    <input type="number" id="yearInput" name="year" class="top-bar-input" placeholder="e.g. 2025" min="2000" max="2099" />
    <button type="submit" class="generate-button">Generate PDF</button>

    <!-- <button type="button" class="generate-button" onclick="printCompleteList()">
    Generate List
    </button> -->
  </form>

</div>
<div class="document-buttons-container">
  <div class="document-button">
    <?php if ($hasUnread): ?>
      <span class="notif-dot" id="notifDot"></span>
    <?php endif; ?>
    <i class="fas fa-hand-holding-heart document-icon"></i>
    <span>Certificate of Indigency</span>
    <button class="view-requests-button" id="notifButton" onclick="window.location.href='adminDocReq_indigency.php'">View Requests</button>
  </div>

  <div class="document-button">
    <i class="fas fa-file-signature document-icon"></i>
    <span>Barangay Permit</span>
    <button class="view-requests-button" onclick="window.location.href=''">View Requests</button>
  </div>

  <div class="document-button">
    <i class="fas fa-home document-icon"></i>
    <span>Certificate of Residency</span>
    <button class="view-requests-button" onclick="window.location.href=''">View Requests</button>
  </div>

  <div class="document-button">
    <i class="fas fa-id-badge document-icon"></i>
    <span>Barangay Business Clearance</span>
    <button class="view-requests-button" onclick="window.location.href=''">View Requests</button>
  </div>
</div>

</main>
  </div>
</body>
</html>
