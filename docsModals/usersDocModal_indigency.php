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
        $row['supporting_document'] = $row['supporting_document'] ?? '';
        $disableEdit = in_array($row['status'], ['For Pickup', 'Completed']) ? 'disabled' : '';
        $disableCancel = $row['status'] === 'Completed' ? 'disabled' : '';
        echo "<tr>
            <td>{$row['user_id']}</td> 
            <td>{$fullName}</td>
            <td class='status'>{$row['status']}</td>
            <td>{$row['date_requested']}</td>
            <td>{$row['document_type']}</td>
            <td>{$row['comment']}</td> <!-- 🆕 Added this -->
            <td>
               <button class='action-btn' onclick='openReviewModal(".json_encode($row).")' $disableEdit>Edit Request</button>
                <button class='action-btn delete-btn' onclick='deleteFromRow({$row['id']})' $disableCancel>Cancel</button>
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/formModal_style.css" />
  <script src="../js/users_openIndigencyModal.js" defer></script>
</head>
<body>
    <!-- Modal part -->
    <div id="reviewModal" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="modal-title">Review Request</h2>
            <form id="reviewForm" class="form" name="update_usersIndigency">
            <!-- hidden Inputs -->
            <input type="hidden" name="form_origin" value="update_usersIndigency"> <!-- or 'admin_updateIndigency' -->
            <input type="hidden" name="actor_id" value="<?= $user_id ?>">
            <input type="hidden" name="is_read" value=0>
                
            <input type="hidden" id="requestId" name="requestId">
            <!-- end of hidden Inputs -->

            <div class="form-group">
                <label>User ID:</label>
                <input type="text" id="userId" name="user_id" readonly>
            </div>

            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" id="fullName" readonly>
            </div>

               <div class="form-group">
                <label>Document Type:</label>
                <input type="text" id="documentType">
            </div>

            <div class="form-group">
                <label>Purpose:</label>
                <textarea id="purpose" name="purpose"></textarea required>
            </div>

                        <div class="file-upload-container">
                <label class="file-upload-label">Supporting Document:</label>
                <div id="existingFileLink"></div>

                <div class="file-upload-wrapper">
                <button type="button" id="removeFileBtn" class="btn remvfile-btn">Remove File</button>
                    <label class="file-upload-custom" id="fileLabel">
                        <span id="fileLabelText">Choose File</span>
                        <input type="file" id="supportingDocument" name="supportingDocument" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                        <div id="newFilePreview" style="margin-top: 10px;"></div>
                    </label>

                </div>

                <input type="hidden" name="removeFile" id="removeFile" value="0">
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
                <textarea id="comment" name="comment" rows="4" placeholder="The Brgy. Official Will comment here..." readonly></textarea>
            </div>

            <div class="form-group">
                    <label>Reply:</label>
                    <textarea id="reply" name="reply" rows="4" placeholder="Reply to the comment..." disabled></textarea>
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
