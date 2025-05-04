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
  <!--SCRIPTS-->
  <script src="../js/userHome_script.js" defer></script>
  <script src="../js/chatBot.js" defer></script>
  <script src="../js/autoChat.js" defer></script>
  <script src="../js/displayChats.js" defer></script>
  <script src="../js/alerts.js" defer></script>
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
      <button class="side-button-active" onclick="window.location.href='userHome.php'">Home</button>
      <button class="side-button" onclick="window.location.href='userViewReq.php'">My Requests</button>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
  <div class="form-container">
    <div class="form-header">
      <a href="javascript:history.back()" class="icon-back-button" aria-label="Go back">⮌</a>
      <h2>Barangay Indigency Request Form</h2>
    </div>

    <form method="POST" action="../php/handle_request_indigency.php" enctype="multipart/form-data">
      <input type="hidden" name="document_type" value="indigency">

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
        <label for="supporting_document">Supporting Document (optional):</label>
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
