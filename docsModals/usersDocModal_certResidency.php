<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['id'])) {
    echo "Session user_id is not set. Please check your login process.";
    exit;
}

$user_id = $_SESSION['id'];
$lastName = $_SESSION['last_name'] ?? '';
$firstName = $_SESSION['first_name'] ?? '';
$middleName = $_SESSION['middle_name'] ?? '';
$suffix = $_SESSION['suffix'] ?? '';

$conn = new mysqli("localhost", "root", "", "reqwest");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM certresidency WHERE user_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table class='certresidency-table'>
            <thead>
              <tr>
                <th>User ID</th>
                <th>Full Name</th>
                <th>Purpose</th>
                <th>Status</th>
                <th>Date Requested</th>
                <th>Document Type</th>
                <th>Comment</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>";
    while ($row = $result->fetch_assoc()) {
        $fullName = $row["first_name"] . " " . 
                    ($row["middle_name"] ? $row["middle_name"] . " " : "") . 
                    $row["last_name"] . 
                    ($row["suffix"] ? ", " . $row["suffix"] : "");
        $disableEdit = in_array($row['status'], ['For Pickup', 'Completed']) ? 'disabled' : '';
        echo "<tr>
                <td>{$row['user_id']}</td>
                <td>{$fullName}</td>
                <td>{$row['purpose']}</td>
                <td class='status'>{$row['status']}</td>
                <td>{$row['date_requested']}</td>
                <td>{$row['document_type']}</td>
                <td>{$row['comment']}</td>
                <td>
                    <button class='action-btn' onclick='openReviewModal(" . json_encode($row) . ")' $disableEdit>Edit Request</button>
                    <button class='action-btn delete-btn' onclick='deleteFromRow({$row['id']})'>Cancel</button>
                </td>
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Certificate of Residency Request</title>
  <link rel="stylesheet" href="../styles/formModal_style.css" />
  <script src="../js/users_openCertResidencyModal.js" defer></script>
</head>
<body>
  <div id="reviewModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 class="modal-title">Review Request</h2>
      <form id="reviewResidencyForm" class="form" name="update_usersCertResidency">
        <input type="hidden" name="form_origin" value="update_usersCertResidency">
        <input type="hidden" name="actor_id" value="<?= $user_id ?>">
        <input type="hidden" name="is_read" value=0>
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
          <label>Address:</label>
          <input type="text" id="address" name="address" readonly>
        </div>

        <div class="form-group">
          <label>Contact Number:</label>
          <input type="text" id="contactNumber" name="contact_number">
        </div>

        <div class="form-group">
          <label>Purpose:</label>
          <textarea id="purpose" name="purpose"></textarea>
        </div>

        <div class="file-upload-container">
          <label class="file-upload-label">Supporting Document:</label>
          <div id="existingFileLink"></div>

          <div class="file-upload-wrapper">
            <button type="button" id="removeFileBtn" class="btn remvfile-btn">Remove File</button>
            <label class="file-upload-custom" id="fileLabel">
              <span id="fileLabelText">Choose File</span>
              <input type="file" id="supportingDocument" name="supportingDocument" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
              <div id="newFilePreview" style="margin-top: 10px;"></div>
            </label>
          </div>

          <input type="hidden" name="removeFile" id="removeFile" value="0">
        </div>

        <div class="form-group">
          <label>Document Type:</label>
          <input type="text" id="documentType" name="document_type" readonly>
        </div>

        <div class="form-group">
          <label>Date Requested:</label>
          <input type="text" id="dateRequested" name="date_requested" readonly>
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
          <textarea id="comment" name="comment" rows="4" placeholder="The Brgy. Official Will comment here..." readonly></textarea>
        </div>

        <div class="modal-buttons">
          <button type="button" id="deleteBtn" class="btn btn-delete">Cancel</button>
          <button type="submit" id="saveBtn" class="btn btn-save">Submit</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
