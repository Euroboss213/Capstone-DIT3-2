
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminResidents_style.css" />
  <script src="../js/adminResidents_script.js" defer></script>
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
      <button class="side-button">Dashboard</button>
      <button class="side-button">Document Requests</button>
      <button id="registered-residents" class="side-button">Registered Residents</button>
      <button class="side-button">User Accounts</button>
      <button class="side-button">Admin Accounts</button>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
    <div class="top-bar">
  <input type="text" id="searchInput" placeholder="Search residents..." class="search-bar" onkeyup="filterTable()" />
  <button class="add-btn" onclick="openNewResidentModal()">+ Add New Resident</button>
  </div>

      <?php
      $conn = new mysqli("localhost", "root", "", "admin");
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
                    <th>Age</th>
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
                  <td>{$row['age']}</td>
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

      <div id="infoModal" class="modal">
        <div class="modal-content">
          <span class="close-btn" onclick="closeModal()">&times;</span>
          <h2>Resident Information</h2>
          <form id="residentForm">
          <input type="hidden" id="id" name="id" />
            <div class="form-grid">
            <label>First Name: <input type="text" id="first_name" name="first_name" required /></label>
<label>Middle Name: <input type="text" id="middle_name" name="middle_name" /></label>
<label>Last Name: <input type="text" id="last_name" name="last_name" required /></label>
<label>Suffix: <input type="text" id="suffix" name="suffix" /></label>
<label>Birth Date: <input type="date" id="birth_date" name="birth_date" /></label>
<label>Birth Place: <input type="text" id="birth_place" name="birth_place" /></label>
<label>Age: <input type="number" id="age" name="age" /></label>
<label>Sex: 
    <select id="sex" name="sex">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>
</label>
<label>Civil Status: <input type="text" id="civil_status" name="civil_status" /></label>
<label>Nationality: <input type="text" id="nationality" name="nationality" /></label>
<label>Religion: <input type="text" id="religion" name="religion" /></label>
<label>Occupation: <input type="text" id="occupation" name="occupation" /></label>
<label>Contact Number: <input type="text" id="contact_number" name="contact_number" /></label>
<label>Address: <input type="text" id="address" name="address" /></label>
<label>PWD: 
    <select id="pwd" name="pwd">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</label>
<label>PWD ID No: <input type="text" id="pwd_id_no" name="pwd_id_no" /></label>
<label>Indigent: 
    <select id="indigent" name="indigent">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</label>
<label>Solo Parent: 
    <select id="solo_parent" name="solo_parent">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</label>
<label>Solo Parent ID No: <input type="text" id="solo_parent_id_no" name="solo_parent_id_no" /></label>
<label>Member of 4Ps: 
    <select id="member_4ps" name="member_4ps">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</label>
<label>Family Monthly Income: <input type="number" step="0.01" id="family_monthly_income" name="family_monthly_income" /></label>
<label>Registered Voter: 
    <select id="registered_voter" name="registered_voter">
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</label>
<label>National ID No: <input type="text" id="national_id_no" name="national_id_no" /></label>
<label>PhilHealth No: <input type="text" id="philhealth_no" name="philhealth_no" /></label>
<label>SSS No: <input type="text" id="sss_no" name="sss_no" /></label>
<label>Pag-IBIG No: <input type="text" id="pagibig_no" name="pagibig_no" /></label>
<label>TIN No: <input type="text" id="tin_no" name="tin_no" /></label>
<label>Voter's ID No: <input type="text" id="voters_id_no" name="voters_id_no" /></label>
<label>COVID Status: <input type="text" id="covid_status" name="covid_status" /></label>
<label>Vaccinated: 
    <select id="vaccinated" name="vaccinated">
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

      <div id="addModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeAddModal()">&times;</span>
    <h2>Add New Resident</h2>
    <form id="addResidentForm">
      <div class="form-grid">
        <!-- Use same input structure as edit modal but with unique IDs if needed -->
        <label>First Name: <input type="text" name="first_name" required /></label>
        <label>Middle Name: <input type="text" name="middle_name" /></label>
        <label>Last Name: <input type="text" name="last_name" required /></label>
        <label>Suffix: <input type="text" name="suffix" /></label>
        <label>Birth Date: <input type="date" name="birth_date" /></label>
        <label>Birth Place: <input type="text" name="birth_place" /></label>
        <label>Age: <input type="number" name="age" /></label>
        <label>Sex: 
          <select name="sex">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </label>
        <label>Civil Status: <input type="text" name="civil_status" /></label>
        <label>Nationality: <input type="text" name="nationality" /></label>
        <label>Religion: <input type="text" name="religion" /></label>
        <label>Occupation: <input type="text" name="occupation" /></label>
        <label>Contact Number: <input type="text" name="contact_number" /></label>
        <label>Address: <input type="text" name="address" /></label>
        <label>PWD: 
          <select name="pwd">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>PWD ID No: <input type="text" name="pwd_id_no" /></label>
        <label>Indigent: 
          <select name="indigent">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Solo Parent: 
          <select name="solo_parent">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Solo Parent ID No: <input type="text" name="solo_parent_id_no" /></label>
        <label>Member of 4Ps: 
          <select name="member_4ps">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Family Monthly Income: <input type="number" step="0.01" name="family_monthly_income" /></label>
        <label>Registered Voter: 
          <select name="registered_voter">
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>National ID No: <input type="text" name="national_id_no" /></label>
        <label>PhilHealth No: <input type="text" name="philhealth_no" /></label>
        <label>SSS No: <input type="text" name="sss_no" /></label>
        <label>Pag-IBIG No: <input type="text" name="pagibig_no" /></label>
        <label>TIN No: <input type="text" name="tin_no" /></label>
        <label>Voter's ID No: <input type="text" name="voters_id_no" /></label>
        <label>COVID Status: <input type="text" name="covid_status" /></label>
        <label>Vaccinated: 
          <select name="vaccinated">
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
