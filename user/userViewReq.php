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
  <!--STYLES-->
  <link rel="stylesheet" href="../styles/userTemplate.css" />
  <link rel="stylesheet" href="../styles/chatBot.css" />
  <link rel="stylesheet" href="../styles/autoChat.css">
  <link rel="stylesheet" href="../styles/userViewReq_style.css">
  <!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!--SCRIPTS-->
  <script src="../js/userHome_script.js" defer></script>
  <script src="../js/chatBot.js" defer></script>
  <script src="../js/autoChat.js" defer></script>
  <script src="../js/displayChats.js" defer></script>
</head>
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
      <button id="chatButton" class="chat-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v7z" />
        </svg>
      </button>
      <button id="profileButton" class="profile-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </button>
      <div id="acc-dropdownMenu" class="acc-dropdown-menu">
        <a href="#" class="acc-dropdown-item">Change Password</a>
        <form action="../php/tologout.php" method="post">
            <button type="submit" class="acc-dropdown-item-btn">Logout</button>
        </form>
      </div>
      <div id="chat-dropdownMenu" class="chat-dropdown-menu">
          <button type="submit" class="chat-dropdown-item-btn" id="chatBot-btn">AI Assisstant</button>
          <button type="submit" class="chat-dropdown-item-btn" id="autoChat-btn">Chat Bot</button>
      </div>
    </div>
  </nav>

  <div class="flex-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="user-name"><?php echo htmlspecialchars($userName); ?></h2>
      <button class="side-button" onclick="window.location.href='userHome.php'">Home</button>
      <button class="side-button-active" onclick="window.location.href='userViewReq.php'">View My Requests</button>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
  <div class="document-buttons-container">
    <button class="document-button" onclick="window.location.href='userViewReq_indigency.php'">
      <i class="fas fa-hand-holding-heart document-icon"></i>
      <span>Barangay Indigency</span>
    </button>

    <button class="document-button">
      <i class="fas fa-file-signature document-icon"></i>
      <span>Barangay Permit</span>
    </button>

    <button class="document-button">
      <i class="fas fa-home document-icon"></i>
      <span>Barangay Residency</span>
    </button>

    <button class="document-button">
      <i class="fas fa-id-badge document-icon"></i>
      <span>Barangay Clearance</span>
    </button>
  </div>
</main>
  </div>
</body>
</html>
