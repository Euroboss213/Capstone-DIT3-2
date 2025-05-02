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
  <link rel="stylesheet" href="../styles/adminDocReq_style.css" />
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/adminDocReq_indigency_style.css" />
  <link rel="stylesheet" href="../styles/formModal_style.css" />
  <link rel="stylesheet" href="../styles/status.css" />
  <script src="../js/adminNav.js" defer></script>
  <script src="../js/admindDocReq_indigency_script.js" defer></script>
  <script src="../js/status.js" defer></script>
  
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
    <input type="text" id="searchInput" placeholder="Search indigency requests..." class="search-bar" onkeyup="filterTable()" />
    <select id="statusFilter" class="filter-dropdown" onchange="filterByStatus()">
    <option value="">All Statuses</option>
    <option value="Ongoing">Ongoing</option>
    <option value="Approved">Approved</option>
    <option value="Returned">Returned</option>
    <option value="For Pickup">For Pickup</option>
    <option value="Completed">Completed</option>
  </select>
  <button class="back-btn" onclick="window.location.href='adminDocReq.php'">Go Back</button>
</div>

      <div id="indigency" class="table-container" style="display: block;">
        <?php include '../docsModals/indigencyDocModal.php'; ?>
      </div>

</main>
  </div>
</body>
</html>
