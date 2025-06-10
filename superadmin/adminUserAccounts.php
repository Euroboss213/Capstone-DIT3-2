<?php
include "../php/auth_check.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'superadmin') {
    // Not an admin, redirect or show access denied
    header('Location: ../pages/newlogin.php');
    exit();
}

// Get the user's name from session
$userName = $_SESSION['user_name'];
?>
<?php include '../php/get_unread_notifications.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/adminUserAccounts_style.css" />
  <link rel="stylesheet" href="../styles/notifModal.css" />
  <link rel="stylesheet" href="../styles/adminResidents_style.css" />

  <script src="../js/adminUserAccounts.js" defer></script>
  <script src="../js/adminResidents_script.js" defer></script>
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
    <div class="top-bar">
    <input type="text" id="searchInput" placeholder="Search residents..." class="search-bar" onkeyup="filterTable()" />
    </div>
    <?php
      $conn = new mysqli("localhost", "root", "", "reqwest");
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM users WHERE role IN ('user', 'admin')";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        echo "<table class='user-table'>
                <thead>
                  <tr>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>";
        while($row = $result->fetch_assoc()) {
          $fullName = $row["first_name"] . " " . ($row["middle_name"] ? $row["middle_name"] . " " : "") . $row["last_name"] . ($row["suffix"] ? ", " . $row["suffix"] : "");
          echo "<tr>
                  <td>{$fullName}</td>
                   <td>{$row['username']}</td>
                   <td>{$row['role']}</td>
                   <td style='display: flex; justify-content: space-evenly; align-items: center;'>
                      
                      " . ($row['role'] !== 'admin' ?
                      "
                      <p>active status</p>
                      <label class='switch'>
                        <input type='checkbox' class='acc-toggle' data-user-id='" . $row['id'] . "' " . ($row['acc_status'] === 'active' ? 'checked' : '') . ">
                        <span class='slider round'></span>
                      </label>
                      " : 
                      "<button class ='save-btn' onclick='openEditAccModal(" . json_encode($row) . ")'>edit account</button>") . "
                      <button class ='delete-btn'>delete account</button>
                    </td>
                </tr>";
        }
        echo "</tbody></table>";
      } else {
        echo "No records found.";
      }
      $conn->close();
      ?>
      <button class="add-btn" onclick='openAccModal()'>add an account</button>
    </main>
    <div>
       <!-- add new account -->
      <div class="modal" id="accModal">
        <div class="modal-content">
        <span class="close-btn" onclick="closeAccModal()">&times;</span>
        <h2>Add New Resident</h2>
        <form id="addAccount" action="../php/add_account.php" method="POST">
          <div class="form-grid">
            <label><span style="color: red">*</span>First Name: <input type="text" name="first_name" required /></label>
            <label><span style="color: red">*</span>Middle Name: <input type="text" name="middle_name" required /></label>
            <label><span style="color: red">*</span>Last Name: <input type="text" name="last_name" required /></label>
            <label>Suffix: <input type="text" name="suffix" /></label> 
            <label>Username: <input type="text" name="username" required/></label> 
            <label>Password: <input type="password" name="password" required/></label>
            <label>Role: 
              <select name="role" required>
                <option value ="Select an option" disabled selected hidden>Select an option</option>
                <option value="admin">admin</option>
                <option value="user">user</option>
              </select>
            </label>
            <div class="modal-footer">
              <button type="submit" class="save-btn">Create new account</button>
            </div>
        </form> 
        </div>
      </div>
    </div>
   
    <div>
      <!-- edit existing account -->
      <div class="modal" id="editAccModal">
        <div class="modal-content">
        <span class="close-btn" onclick="closeEditAccModal()">&times;</span>
        <h2>Edit Existing Resident</h2>
        <form id="editAccount" action="../php/edit_account.php" method="POST">
          <div class="form-grid">
            <input type="hidden" id="account_id" name="id">
            <label><span style="color: red">*</span>First Name: <input type="text" id="first_name" name="first_name" required  /></label>
            <label><span style="color: red">*</span>Middle Name: <input type="text" id="middle_name" name="middle_name" required /></label>
            <label><span style="color: red">*</span>Last Name: <input type="text" id="last_name" name="last_name" required /></label>
            <label>Suffix: <input type="text" id="suffix" name="suffix" /></label>
            <div class="modal-footer">
              <button type="submit" class="save-btn">Update Account</button>
            </div>
        </form> 
        </div>
      </div>
    </div>
      
  </div>
</body>
</html>
