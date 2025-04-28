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
    echo "<table class='indigency-table'>
            <thead>
              <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Status</th>
                <th>Date Requested</th>
                <th>Document Type</th>
                <th>Comment</th> <!-- 🆕 Added this -->
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
            <td>{$row['comment']}</td> <!-- 🆕 Added this -->
            <td><button class='action-btn' onclick='openReviewModal(".json_encode($row).")'>Edit Request</button></td>
        </tr>";
    }
    echo "</tbody></table>";
} else {
    echo "No records found.";
}
      $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/adminResidents_style.css" />
  <link rel="stylesheet" href="../styles/adminDocReq_style.css" />
  <link rel="stylesheet" href="../styles/adminDocReq_indigency_style.css" />
  <link rel="stylesheet" href="../styles/adminDocReqModal_style.css" />
  
  <script src="../js/adminNav.js" defer></script>
  <script src="../js/users_openModal.js" defer></script>
  <script src="../js/admindDocReq_script.js" defer></script>
</head>
<body>
    <!-- Modal part -->
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
                <textarea id="purpose" name="purpose"></textarea>
            </div>

            <div class="form-group">
                <label>Upload Supporting Document:</label>
                <input type="file" id="supportingDocument" name="supportingDocument" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
            </div>

            <div class="form-group">
                <label>Document Type:</label>
                <input type="text" id="documentType">
            </div>

            <div class="form-group">
                <label>Date Requested:</label>
                <input type="text" id="dateRequested" readonly>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select id="status" name="status" disabled>
                <option value="Ongoing">Ongoing</option>
                <option value="Returned">Returned</option>
                <option value="For Pickup">For Pickup</option>
                <option value="Completed">Completed</option>
                </select>
            </div>

            <div class="form-group">
                <label>Comment:</label>
                <textarea id="comment" name="comment" rows="4" placeholder="Add a comment..." readonly></textarea>
            </div>

            <div class="modal-buttons">
                <button type="button" id="deleteBtn" class="btn btn-delete">Delete</button>
                <button type="submit" id="saveBtn" class="btn btn-save">Save</button>
            </div>
            </form>
        </div>
    </div>
</body>
</html>
