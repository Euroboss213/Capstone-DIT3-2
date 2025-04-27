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
  <link rel="stylesheet" href="../styles/userViewReq_indigency_style.css" />
  <link rel="stylesheet" href="../styles/userTemplate.css" />
  <link rel="stylesheet" href="../styles/chatBot.css" />
  <link rel="stylesheet" href="../styles/autoChat.css">

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
      <!-- Main Content -->
    <main class="main-content">
    <div class="top-bar">
  <button class="back-btn" onclick="window.location.href='userViewReq.php'">Go Back</button>
</div>

      <?php
      $conn = new mysqli("localhost", "root", "", "reqwest");
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }
if (isset($_SESSION['import_message'])) {
    echo $_SESSION['import_message'];
    unset($_SESSION['import_message']);
}
      $sql = "SELECT * FROM indigency";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        echo "<table class='indigency-table'>
                <thead>
                  <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Status</th>
                    <th>Date Requested</th>
                    <th>Document Type</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>";
        while($row = $result->fetch_assoc()) {
          $fullName = $row["first_name"] . " " . ($row["middle_name"] ? $row["middle_name"] . " " : "") . $row["last_name"] . ($row["suffix"] ? ", " . $row["suffix"] : "");
          echo "<tr>
                <td>{$row['user_id']}</td> 
                  <td>{$fullName}</td>
                  <td>{$row['status']}</td>
                  <td>{$row['date_requested']}</td>
                  <td>{$row['document_type']}</td>
                 <td><button class='action-btn' onclick=''>Edit Request</button></td>
                </tr>";
        }
        echo "</tbody></table>";
      } else {
        echo "No records found.";
      }

      $conn->close();
      ?>
</main>
  </div>
</body>
</html>
