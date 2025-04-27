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
  <link rel="stylesheet" href="../styles/adminDocReqModal_style.css" />
  <script src="../js/adminNav.js" defer></script>
  <script src="../js/admindDocReq_indigency_script.js" defer></script>
  <script src="../js/admindDocReq_script.js" defer></script>
  
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
  <input type="text" id="searchInput" placeholder="Search requests..." class="search-bar" onkeyup="filterTable()" />
  <button class="back-btn" onclick="window.location.href='adminDocReq.php'">Go Back</button>
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
                 <td><button class='action-btn' onclick='openReviewModal(".json_encode($row).")'>Review Request</button></td>
                </tr>";
        }
        echo "</tbody></table>";
      } else {
        echo "No records found.";
      }

      $conn->close();
      ?>

     <!-- Modal Structure -->
<div id="reviewModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2 class="modal-title">Review Request</h2>
    <form id="reviewForm" class="form">
      <input type="hidden" id="requestId" name="requestId">

      <div class="form-group">
        <label>User ID:</label>
        <input type="text" id="userId" name="user_id" readonly>
      </div>

      <div class="form-group">
        <label>Full Name:</label>
        <input type="text" id="fullName" readonly>
      </div>

      <div class="form-group">
        <label>Purpose:</label>
        <textarea id="purpose" readonly></textarea>
      </div>

      <div class="form-group">
        <label>Supporting Document:</label>
        <a id="supportingDocumentLink" href="#" target="_blank" class="link">View Document</a>
      </div>

      <div class="form-group">
        <label>Document Type:</label>
        <input type="text" id="documentType" readonly>
      </div>

      <div class="form-group">
        <label>Date Requested:</label>
        <input type="text" id="dateRequested" readonly>
      </div>

      <div class="form-group">
        <label>Status:</label>
        <select id="status" name="status">
          <option value="Ongoing">Ongoing</option>
          <option value="Returned">Returned</option>
          <option value="For Pickup">For Pickup</option>
          <option value="For Pickup">Completed</option>
        </select>
      </div>

      <div class="form-group">
        <label>Comment:</label>
        <textarea id="comment" name="comment" rows="4" placeholder="Add a comment..."></textarea>
      </div>

      <div class="modal-buttons">
        <button type="button" id="deleteBtn" class="btn btn-delete">Delete</button>
        <button type="submit" id="saveBtn" class="btn btn-save">Save</button>
      </div>
    </form>
  </div>
</div>


</main>
  </div>
</body>
</html>
