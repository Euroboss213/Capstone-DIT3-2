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
  <link rel="stylesheet" href="userHome_style.css" />
  <script src="userHome_script.js" defer></script>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo-container">
      <img src="logo.png" alt="REQWEST Logo" class="logo-img" />
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
      <div id="dropdownMenu" class="dropdown-menu">
        <a href="#" class="dropdown-item">Change Password</a>
        <form action="../php/tologout.php" method="post">
            <button type="submit" class="dropdown-item-btn">Logout</button>
        </form>
      </div>
    </div>
  </nav>

  <div class="flex-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h2 class="user-name"><?php echo htmlspecialchars($userName); ?></h2>
      <button class="side-button">View My Requests</button>
      <button class="side-button">Verify My Account</button>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
      <div class="button-grid">
        <button class="action-button bg-green-500">Request Barangay Indigency</button>
        <button class="action-button bg-yellow-500">Request Barangay Permit</button>
        <button class="action-button bg-blue-500">Request Barangay Residency</button>
        <button class="action-button bg-purple-500">Request Barangay Clearance</button>
      </div>

      <!-- Image Container -->
      <div class="image-container">
        <img src="step.png" alt="Your Image" class="image" />
      </div>
    </main>
  </div>
</body>
</html>
