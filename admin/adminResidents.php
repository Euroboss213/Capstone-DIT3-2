<?php
include "../php/auth_check.php";
include "../database/connect_db_reqwest.php"; 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // Not an admin, redirect or show access denied
    header('Location: ../pages/newlogin.php');
    exit();
}

// Get the user's name from session
$userName = $_SESSION['user_name'];
$userId = $_SESSION['id'];
?>

<?php include '../php/get_unread_notifications.php' ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminResidents_style.css" />
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/notifModal.css" />
  <script src="../js/adminResidents_script.js" defer></script>
  <script src="../js/uploadCV.js" defer></script>
  <script src="../js/adminNav.js" defer></script>
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
  <button class="add-btn" onclick="openNewResidentModal()">+ Add New Resident</button>
  <button id="openCsvModalBtn" class="upload-csv-btn">Upload CSV File</button>
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
                  <td><button class='more-info-btn' onclick='openModal(" . json_encode($row) . ")'>View or Edit</button></td>
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
        <label><span style="color: red">*</span> First Name: <input type="text" id="first_name" name="first_name" required /></label>
        <label><span style="color: red">*</span> Middle Name: <input type="text" id="middle_name" name="middle_name" required /></label>
        <label><span style="color: red">*</span> Last Name: <input type="text" id="last_name" name="last_name" required /></label>
        <label>Suffix: <input type="text" id="suffix" name="suffix" /></label>
        <label><span style="color: red">*</span> Birth Date: <input type="date" name="birth_date" id="birth_date"  required /></label>
        <label><span style="color: red">*</span> Birth Place: <input type="text"  name="birth_place" id="birth_place" required /></label>
        <label><span style="color: red">*</span> Sex: 
          <select id="sex" name="sex" required>
            <option value ="Select an option" disabled selected hidden>Select an option</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Civil Status: 
          <select id="civil_status" name="civil_status" required>
              <option value ="Select an option" disabled selected hidden>Select an option</option>
              <option value ="Single">Single</option>
              <option value ="Married">Married</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Nationality: <input type="text" id="nationality" name="nationality" required /></label>
        <label><span style="color: red">*</span> Religion: 
          <select id="religion" name="religion" required id="religion">
            <option value ="Select an option" disabled selected hidden>Select an option</option>
            <option value ="Roman Catholic">Roman Catholic</option>
            <option value ="Christian">Christian</option>
            <option value ="Iglesia ni Cristo">Iglesia ni Cristo</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Occupation: <input type="text" id="occupation" name="occupation" required /></label>
        <label><span style="color: red">*</span> Contact Number: <input type="number" id="contact_number" name="contact_number" required /></label>
        <label><span style="color: red">*</span> Address:</br> <hr>
                  <!-- House Number -->
          <label>
            <span style="color: red">*</span> House No.:
            <input type="text" id="house_no" name="house_no" required />
          </label>      
        </label>
        <label></br> <hr>
          <label>
            <span style="color: red">*</span> Street Name:
            <input type="text" id="street_name" name="street_name" required />
          </label>
        </label>
          <label>
            <span style="color: red">*</span> Municipality:
            <input type="text" id="municipality" name="municipality" required />
          </label>
          <label>
            <span style="color: red">*</span> Province:
            <input type="text" id="province" name="province" required />
          </label>

        <label><hr>
        <label><span style="color: red">*</span> PWD: 
          <select name="pwd" required id="pwd" onchange="togglePwdIdField()">
            <option value ="Select an option" disabled selected hidden>Select an option</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        </label>
        <label><hr>
        <label>PWD ID No: <input type="text" id="pwd_id_no" name="pwd_id_no" pattern="PWD-\d{4}-\d{4}" title="Format: PWD-XXXX-XXXX"/></label>
        </label>        
        <label><span style="color: red">*</span>Indigent: 
          <select name="indigent" required>
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Solo Parent: 
          <select name="solo_parent" required id="solo_parent" onchange="togglePwdIdField()">
            <option value ="Select an option" disabled selected hidden>Select an option</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
          </select>
        </label>
        <label>Solo Parent ID No: <input type="text" name="solo_parent_id_no" id="solo_parent_id_no" pattern="SP-\d{4}-\d{4}" title="Format: SP-XXXX-XXXX"/></label>
        <label><span style="color: red">*</span> Member of 4Ps: 
          <select id="member_4ps" name="member_4ps" required>
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Family Monthly Income: <input type="number" step="0.01" id="family_monthly_income" name="family_monthly_income" required /></label>
        <!-- 
        <label>National ID No: <input type="text" name="national_id_no" pattern="\d{4} \d{4} \d{4}" title="Format: 1234 5678 9012" /></label>
        <label>PhilHealth No: <input type="text" name="philhealth_no" pattern="\d{2}-\d{4}-\d{4}" title="Format: 12-3456-7890" /></label>
        <label>SSS No: <input type="text" name="sss_no" pattern="\d{2}-\d{7}-\d{1}" title="Format: 12-3456789-0" /></label>
        <label>Pag-IBIG No: <input type="text" name="pagibig_no" pattern="\d{4}-\d{4}-\d{4}" title="Format: 1234-5678-9012" /></label>
        <label>TIN No: <input type="text" name="tin_no" pattern="\d{3}-\d{3}-\d{3}" title="Format: 123-456-789" /></label> 
        -->
        <label><span style="color: red">*</span> Voter's ID No: <input type="text" id="voters_id_no" name="voters_id_no" pattern="VIN-\d{4}-\d{4}" title="Format: VIN-XXXX-XXXX" required /></label>
        <label><span style="color: red">*</span> COVID Status: 
          <select type="text" id="covid_status" name="covid_status" required>
            <option value="Negative">Negative</option>
            <option value="Positive">Positive</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Vaccinated: 
          <select id="vaccinated" name="vaccinated" required>
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </label>
        <label>Date of Registration: <input type="text" id="date_of_registration" name="date_of_registration" readonly /></label>
      </div>
      <div class="modal-footer">
      <button type="button" class="delete-btn" onclick="deleteResident()">Delete Resident</button>
        <button type="submit" class="save-btn">Save Changes</button>
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
        <label><span style="color: red">*</span> First Name: <input type="text" name="first_name" required /></label>
        <label><span style="color: red">*</span> Middle Name: <input type="text" name="middle_name" required /></label>
        <label><span style="color: red">*</span> Last Name: <input type="text" name="last_name" required /></label>
        <label>Suffix: <input type="text" name="suffix" /></label>
        <label><span style="color: red">*</span> Birth Date: <input type="date" name="birth_date" id="birth_date" required /></label>
        <label><span style="color: red">*</span> Birth Place: <input type="text" name="birth_place" required /></label>
        <label><span style="color: red">*</span> Sex: 
          <select name="sex" required>
            <option value ="Select an option" disabled selected hidden>Select an option</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Civil Status: 
          <select id="civil_status" name="civil_status" required>
              <option value ="Select an option" disabled selected hidden>Select an option</option>
              <option value ="Single">Single</option>
              <option value ="Married">Married</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Nationality: <input type="text" name="nationality" required /></label>
        <label><span style="color: red">*</span> Religion: 
          <select id="religion" name="religion" required>
            <option value ="Select an option" disabled selected hidden>Select an option</option>
            <option value ="Roman Catholic">Roman Catholic</option>
            <option value ="Christian">Christian</option>
            <option value ="Iglesia ni Cristo">Iglesia ni Cristo</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Occupation: <input type="text" name="occupation" required /></label>
        <label><span style="color: red">*</span> Contact Number: <input type="number" name="contact_number" required /></label>
        <label><span style="color: red">*</span> Address:</br> <hr>
                  <!-- House Number -->
          <label>
            <span style="color: red">*</span> House No.:
            <input type="text" name="house_no" required />
          </label>      
        </label>
        <label></br> <hr>
          <label>
            <span style="color: red">*</span> Street Name:
            <input type="text" name="street_name" required />
          </label>
        </label>
          <label>
            <span style="color: red">*</span> Municipality:
            <input type="text" name="municipality" required />
          </label>
          <label>
            <span style="color: red">*</span> Province:
            <input type="text" name="province" required />
          </label>

        <label><hr>
        <label><span style="color: red">*</span> PWD: 
          <select name="pwd" required id="pwdSelect" onchange="togglePwdIdField()">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </label>
        </label>
        <label><hr>
        <label>PWD ID No: <input type="text" id="pwdIdField" name="pwd_id_no" pattern="PWD-\d{4}-\d{4}" title="Format: PWD-XXXX-XXXX"/></label>
        </label>
        <label><span style="color: red">*</span> Indigent: 
          <select name="indigent" required>
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Solo Parent: 
          <select name="solo_parent" required id="spSelect" onchange="togglePwdIdField()">
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </label>
        <label>Solo Parent ID No: <input type="text" name="solo_parent_id_no" id="spIdField" pattern="SP-\d{4}-\d{4}" title="Format: SP-XXXX-XXXX" /></label>
        <label><span style="color: red">*</span> Member of 4Ps: 
          <select name="member_4ps" required>
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Family Monthly Income: <input type="number" step="0.01" name="family_monthly_income" required /></label>
        <!-- 
        <label>National ID No: <input type="text" name="national_id_no" pattern="\d{4} \d{4} \d{4}" title="Format: 1234 5678 9012" /></label>
        <label>PhilHealth No: <input type="text" name="philhealth_no" pattern="\d{2}-\d{4}-\d{4}" title="Format: 12-3456-7890" /></label>
        <label>SSS No: <input type="text" name="sss_no" pattern="\d{2}-\d{7}-\d{1}" title="Format: 12-3456789-0" /></label>
        <label>Pag-IBIG No: <input type="text" name="pagibig_no" pattern="\d{4}-\d{4}-\d{4}" title="Format: 1234-5678-9012" /></label>
        <label>TIN No: <input type="text" name="tin_no" pattern="\d{3}-\d{3}-\d{3}" title="Format: 123-456-789" /></label> 
        -->
        <label><span style="color: red">*</span> Voter's ID No: <input type="text" name="voters_id_no" pattern="VIN-\d{4}-\d{4}" title="Format: VIN-XXXX-XXXX" required /></label>
        <label><span style="color: red">*</span> COVID Status: 
          <select name="covid_status"  required>
            <option value="Negative">Negative</option>
            <option value="Positive">Positive</option>
          </select>
        </label>
        <label><span style="color: red">*</span> Vaccinated: 
        <label>TIN No: <input type="text" name="tin_no" pattern="\d{3}-\d{3}-\d{3}" title="Format: 123-456-789" /></label>
        <label>Voter's ID No: <input type="text" name="voters_id_no" pattern="VIN-\d{4}-\d{4}" title="Format: VIN-XXXX-XXXX" required /></label>
        <label>COVID Status: <select type="text" name="covid_status" required>
          <option value="Yes">Positive</option>
            <option value="No">Negative</option>
            <option value="Recovered">Recovered</option>
              <option value="Not Checked Up">Not Checked Up</option>
            </select>
        </label>
        <label>Vaccinated: 
          <select name="vaccinated" required>
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </label>
      </div>
      <div class="modal-footer">
        <button type="submit" class="save-btn">Add Resident</button>
      </div>
    </form>
  </div>
</div>

<!--Upload Modal-->
<div id="uploadCsvModal" class="modal-upload">
  <div class="modal-upload-content">
    <span class="close">&times;</span>
    <h2>REQUIRED CSV HEADER</h2>
    <table class="template-table">
      <thead>
        <tr><th>Required Headers</th></tr>
      </thead>
      <tbody>
        <tr><td>first_name</td></tr>
        <tr><td>middle_name</td></tr>
        <tr><td>last_name</td></tr>
        <tr><td>suffix</td></tr>
        <tr><td>birth_date</td></tr>
        <tr><td>birth_place</td></tr>
        <tr><td>sex</td></tr>
        <tr><td>civil_status</td></tr>
        <tr><td>nationality</td></tr>
        <tr><td>religion</td></tr>
        <tr><td>occupation</td></tr>
        <tr><td>contact_number</td></tr>
        <tr><td>address</td></tr>
        <tr><td>pwd</td></tr>
        <tr><td>pwd_id_no</td></tr>
        <tr><td>indigent</td></tr>
        <tr><td>solo_parent</td></tr>
        <tr><td>solo_parent_id_no</td></tr>
        <tr><td>member_4ps</td></tr>
        <tr><td>family_monthly_income</td></tr>
        <tr><td>voters_id_no</td></tr>
        <tr><td>covid_status</td></tr>
        <tr><td>vaccinated</td></tr>
      </tbody>
    </table>
    <p>Or download this template:</p>
    <a href="../required_csv/csv_template.csv" download style="color: green; text-decoration: underline;">Download CSV Template</a>


    <form action="../php/upload_residentS.php" method="POST" enctype="multipart/form-data" style="margin-top: 20px;">
      <input type="file" name="csv_file" accept=".csv" required />
      <button type="submit" name="import_csv" class="upload-btn">Upload CSV</button>
    </form>
  </div>
</div>

    </main>
  </div>
</body>
</html>
