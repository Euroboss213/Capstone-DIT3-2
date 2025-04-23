<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminResidents_style.css" />
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <script src="../js/adminResidents_script.js" defer></script>
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
        <a href="#" class="dropdown-item">Logout</a>
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
      <button id="admin-accounts" class="side-button" onclick="window.location.href='adminAdAccounts.php'">Admin Accounts</button>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
    <div class="top-bar">
  <input type="text" id="searchInput" placeholder="Search residents..." class="search-bar" onkeyup="filterTable()" />
  <button class="add-btn" onclick="openNewResidentModal()">+ Add New Resident</button>
  <form action="../php/upload_residents.php" method="POST" enctype="multipart/form-data" style="display:inline-block;">
    <input type="file" name="csv_file" accept=".csv" required />
    <button type="submit" name="import_csv" class="upload-btn">Upload CSV</button>
  </form>
</div>

      <?php
      $conn = new mysqli("localhost", "root", "", "reqwest");
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      $sql = "SELECT * FROM residences";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        echo "<table class='residents-table'>
                <thead>
                  <tr>
                    <th>Full Name</th>
                    <th>Sex</th>
                    <th>Civil Status</th>
                    <th>Contact Number</th>
                    <th>Address</th>
                    <th>Date Registered</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>";
        while($row = $result->fetch_assoc()) {
          $fullName = $row["first_name"] . " " . ($row["middle_name"] ? $row["middle_name"] . " " : "") . $row["last_name"] . ($row["suffix"] ? ", " . $row["suffix"] : "");
          echo "<tr>
                  <td>{$fullName}</td>
                  <td>{$row['sex']}</td>
                  <td>{$row['civil_status']}</td>
                  <td>{$row['contact_number']}</td>
                  <td>{$row['address']}</td>
                  <td>{$row['date_of_registration']}</td>
                  <td><button class='more-info-btn' onclick='openModal(" . json_encode($row) . ")'>View and Edit</button></td>
                </tr>";
        }
        echo "</tbody></table>";
      } else {
        echo "No records found.";
      }
      $conn->close();
      ?>

<!-- Edit Modal -->
<div id="infoModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2>Resident Information</h2>
    <form id="residentForm">
      <input type="hidden" id="id" name="id" />
      <div class="form-grid">
        <label>First Name: <input type="text" id="first_name" name="first_name" required /></label>
        <label>Middle Name: <input type="text" id="middle_name" name="middle_name" required /></label>
        <label>Last Name: <input type="text" id="last_name" name="last_name" required /></label>
        <label>Suffix: <input type="text" id="suffix" name="suffix" /></label>
        <label>Birth Date: <input type="date" id="birth_date" name="birth_date" required /></label>
        <label>Birth Place: <input type="text" id="birth_place" name="birth_place" required /></label>
        <label>Sex: 
          <select id="sex" name="sex" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </label>
        <label>Civil Status: <input type="text" id="civil_status" name="civil_status" required /></label>
        <label>Nationality: <input type="text" id="nationality" name="nationality" required /></label>
        <label>Religion: <input type="text" id="religion" name="religion" required /></label>
        <label>Occupation: <input type="text" id="occupation" name="occupation" required /></label>
        <label>Contact Number: <input type="text" id="contact_number" name="contact_number" required /></label>
        <label>Address: <input type="text" id="address" name="address" required /></label>
        <label>PWD: 
          <select id="pwd" name="pwd">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>PWD ID No: <input type="text" id="pwd_id_no" name="pwd_id_no" pattern="PWD-\d{4}-\d{4}" title="Format: PWD-XXXX-XXXX" /></label>
        <label>Indigent: 
          <select id="indigent" name="indigent" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Solo Parent: 
          <select id="solo_parent" name="solo_parent" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Solo Parent ID No: <input type="text" id="solo_parent_id_no" name="solo_parent_id_no" pattern="SP-\d{4}-\d{4}" title="Format: SP-XXXX-XXXX" /></label>
        <label>Member of 4Ps: 
          <select id="member_4ps" name="member_4ps" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Family Monthly Income: <input type="number" step="0.01" id="family_monthly_income" name="family_monthly_income" required /></label>
        <label>National ID No: <input type="text" id="national_id_no" name="national_id_no" pattern="\d{4} \d{4} \d{4}" title="Format: 1234 5678 9012" /></label>
        <label>PhilHealth No: <input type="text" id="philhealth_no" name="philhealth_no" pattern="\d{2}-\d{4}-\d{4}" title="Format: 12-3456-7890" /></label>
        <label>SSS No: <input type="text" id="sss_no" name="sss_no" pattern="\d{2}-\d{7}-\d{1}" title="Format: 12-3456789-0" /></label>
        <label>Pag-IBIG No: <input type="text" id="pagibig_no" name="pagibig_no" pattern="\d{4}-\d{4}-\d{4}" title="Format: 1234-5678-9012" /></label>
        <label>TIN No: <input type="text" id="tin_no" name="tin_no" pattern="\d{3}-\d{3}-\d{3}" title="Format: 123-456-789" /></label>
        <label>Voter's ID No: <input type="text" id="voters_id_no" name="voters_id_no" pattern="VIN-\d{4}-\d{4}" title="Format: VIN-XXXX-XXXX" required /></label>
        <label>COVID Status: <input type="text" id="covid_status" name="covid_status" required /></label>
        <label>Vaccinated: 
          <select id="vaccinated" name="vaccinated" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Date of Registration: <input type="text" id="date_of_registration" name="date_of_registration" readonly /></label>
      </div>
      <div class="modal-footer">
        <button type="submit" class="save-btn">Save Changes</button>
        <button type="button" class="delete-btn" onclick="deleteResident()">Delete</button>
      </div>
    </form>
  </div>
</div>

<!-- Add Modal -->
<div id="addModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeAddModal()">&times;</span>
    <h2>Add New Resident</h2>
    <form id="addResidentForm">
      <div class="form-grid">
        <label>First Name: <input type="text" name="first_name" required /></label>
        <label>Middle Name: <input type="text" name="middle_name" required /></label>
        <label>Last Name: <input type="text" name="last_name" required /></label>
        <label>Suffix: <input type="text" name="suffix" /></label>
        <label>Birth Date: <input type="date" name="birth_date" id="birth_date" required /></label>
        <label>Birth Place: <input type="text" name="birth_place" required /></label>
        <label>Sex: 
          <select name="sex" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </label>
        <label>Civil Status: <input type="text" name="civil_status" required /></label>
        <label>Nationality: <input type="text" name="nationality" required /></label>
        <label>Religion: <input type="text" name="religion" required /></label>
        <label>Occupation: <input type="text" name="occupation" required /></label>
        <label>Contact Number: <input type="text" name="contact_number" required /></label>
        <label>Address: <input type="text" name="address" required /></label>
        <label>PWD: 
          <select name="pwd">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>PWD ID No: <input type="text" name="pwd_id_no" pattern="PWD-\d{4}-\d{4}" title="Format: PWD-XXXX-XXXX" /></label>
        <label>Indigent: 
          <select name="indigent" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Solo Parent: 
          <select name="solo_parent" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Solo Parent ID No: <input type="text" name="solo_parent_id_no" pattern="SP-\d{4}-\d{4}" title="Format: SP-XXXX-XXXX" /></label>
        <label>Member of 4Ps: 
          <select name="member_4ps" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Family Monthly Income: <input type="number" step="0.01" name="family_monthly_income" required /></label>
        <label>National ID No: <input type="text" name="national_id_no" pattern="\d{4} \d{4} \d{4}" title="Format: 1234 5678 9012" /></label>
        <label>PhilHealth No: <input type="text" name="philhealth_no" pattern="\d{2}-\d{4}-\d{4}" title="Format: 12-3456-7890" /></label>
        <label>SSS No: <input type="text" name="sss_no" pattern="\d{2}-\d{7}-\d{1}" title="Format: 12-3456789-0" /></label>
        <label>Pag-IBIG No: <input type="text" name="pagibig_no" pattern="\d{4}-\d{4}-\d{4}" title="Format: 1234-5678-9012" /></label>
        <label>TIN No: <input type="text" name="tin_no" pattern="\d{3}-\d{3}-\d{3}" title="Format: 123-456-789" /></label>
        <label>Voter's ID No: <input type="text" name="voters_id_no" pattern="VIN-\d{4}-\d{4}" title="Format: VIN-XXXX-XXXX" required /></label>
        <label>COVID Status: <input type="text" name="covid_status" required /></label>
        <label>Vaccinated: 
          <select name="vaccinated" required>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
      </div>
      <div class="modal-footer">
        <button type="submit" class="save-btn">Add Resident</button>
      </div>
    </form>
  </div>
</div>

    </main>
  </div>
</body>
</html>
