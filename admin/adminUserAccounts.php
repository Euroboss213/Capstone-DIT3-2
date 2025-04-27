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
  <link rel="stylesheet" href="../styles/adminUserAccounts_style.css" />
  <script src="../js/adminUserAccounts.js" defer></script>
  <script src="../js/adminNav.js" defer></script>
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
    
    <input type="text" id="searchInput" placeholder="Search residents..." class="search-bar" onkeyup="filterTable()" />
    
    <?php
      $conn = new mysqli("localhost", "root", "", "reqwest");
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM users WHERE role = 'user'";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        echo "<table class='user-table'>
                <thead>
                  <tr>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>";
        while($row = $result->fetch_assoc()) {
          $fullName = $row["first_name"] . " " . ($row["middle_name"] ? $row["middle_name"] . " " : "") . $row["last_name"] . ($row["suffix"] ? ", " . $row["suffix"] : "");
          echo "<tr>
                  <td>{$fullName}</td>
                   <td>{$row['username']}</td>
                  <td><button class ='delete-btn'>delete account</button></td>
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
