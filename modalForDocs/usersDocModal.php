<?php
// Start the session only if it's not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo "Session user_id is not set. Please check your login process.";
    exit; // Stop further execution if no user_id in session
}

$user_id = $_SESSION['id'];
$lastName = $_SESSION['last_name'] ?? '';
$firstName = $_SESSION['first_name'] ?? '';
$middleName = $_SESSION['middle_name'] ?? '';
$suffix = $_SESSION['suffix'] ?? '';

// Create connection to the database
$conn = new mysqli("localhost", "root", "", "reqwest");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch only the records belonging to the logged-in user
$sql = "SELECT * FROM indigency WHERE user_id = ?";
$stmt = $conn->prepare($sql);

// Ensure the prepared statement was created successfully
if (!$stmt) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "
    <table class='documents-table'>
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Purpose</th>
          <th>Document Type</th>
          <th>Supporting Document</th>
          <th>Status</th>
          <th>Comment</th>
          <th>Date Requested</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
    ";

    while ($row = $result->fetch_assoc()) {
        $fullname = htmlspecialchars($row["first_name"]) . " " . 
            ($row["middle_name"] ? htmlspecialchars($row["middle_name"]) . " " : "") . 
            htmlspecialchars($row["last_name"]) . 
            ($row["suffix"] ? ", " . htmlspecialchars($row["suffix"]) : "");

        $document_type = "Indigency";

        $supporting_document = !empty($row['supporting_document']) ? 
            "<a href='" . htmlspecialchars($row['supporting_document']) . "' target='_blank'>View Document</a>" : 
            'No attached file';

        echo "
          <tr>
              <td>{$fullname}</td>
              <td>" . htmlspecialchars($row['purpose']) . "</td>
              <td>{$document_type}</td>
              <td>{$supporting_document}</td>
              <td>" . htmlspecialchars($row['status']) . "</td>
              <td>" . (!empty($row['comment']) ? $row['comment'] : 'No comment yet') . "</td>
              <td>" . htmlspecialchars($row['date_requested']) . "</td>
              <td>
                <button class='more-info-btn' onclick='openModal(" . htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') . ")'>View and Edit</button>
              </td>
          </tr>
        ";
    }

    echo "
      </tbody>
    </table>
    ";
} else {
    echo "<p>No document requests found for the current user.</p>";
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminResidents_style.css" />
  <script src="../js/adminNav.js" defer></script>
  <script src="../js/users_openModal.js" defer></script>
  <script>
    function openModal(data) {
        document.getElementById('infoModal').style.display = 'block';
        
        // Set default fields
        document.querySelector('input[name="last_name"]').value = data.last_name || '';
        document.querySelector('input[name="first_name"]').value = data.first_name || '';
        document.querySelector('input[name="middle_name"]').value = data.middle_name || '';
        document.querySelector('input[name="suffix"]').value = data.suffix || '';
        document.querySelector('textarea[name="purpose"]').value = data.purpose || '';
        
        // NOW: Set the comment value from the database
        document.getElementById('comment').value = data.comment || '';
    }

    function closeModal() {
        document.getElementById('infoModal').style.display = 'none';
    }
  </script>
</head>
<body>
    <!-- Modal part -->
    <div id="infoModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Request Information</h2>
            <form id="residentForm" method="POST" action="../php/update_users_request.php" enctype="multipart/form-data">
                <input type="hidden" id="id" name="id" />

                <div class="form-grid">
                    <label>First Name: <input type="text" id="first_name" name="first_name" readonly /></label>
                    <label>Middle Name: <input type="text" id="middle_name" name="middle_name" readonly /></label>
                    <label>Last Name: <input type="text" id="last_name" name="last_name" readonly /></label>
                    <label>Suffix: <input type="text" id="suffix" name="suffix" readonly /></label>

                    <label>Purpose of Request:</label>
                    <textarea id="purpose" name="purpose"></textarea>

                    <label>Supporting Document (optional):</label>
                    <input type="file" name="supporting_document" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">

                    <label>Comment: 
                        <input type="text" id="comment" name="comment" readonly/>
                    </label>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="save-btn">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</body>
</html>
