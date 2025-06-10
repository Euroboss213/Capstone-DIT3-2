<?php
$conn = new mysqli("localhost", "root", "", "reqwest");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$userId = $_SESSION['id'];

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
              <th>Purpose</th>
              <th>Status</th>
              <th>Date Requested</th>
              <th>Document Type</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>";
  while($row = $result->fetch_assoc()) {
    $fullName = $row["first_name"] . " " . 
                ($row["middle_name"] ? $row["middle_name"] . " " : "") . 
                $row["last_name"] . 
                ($row["suffix"] ? ", " . $row["suffix"] : "");
    echo "<tr>
            <td>{$row['user_id']}</td> 
            <td>{$fullName}</td>
            <td>{$row['purpose']}</td>
            <td class='status'>{$row['status']}</td>
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


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
</head>
<body>
    <!-- Modal part -->
    <div id="reviewModal" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="modal-title">Review Request</h2>
            <form id="reviewForm" class="form" name="admin_updateIndigency">
                <!-- hidden Inputs -->
                <input type="hidden" name="form_origin" value="admin_updateIndigency"> <!-- or 'update_usersIndigency' -->
                <input type="hidden" name="actor_id" value="<?= $userId ?>">
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
                    <option value="Completed">Completed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Comment:</label>
                    <textarea id="comment" name="comment" rows="4" placeholder="Add a comment..."  required></textarea>
                </div>

                <div class="modal-buttons">
                  <!-- <div class="left-buttons">
                    <button type="button" id="deleteBtn" class="btn btn-delete">Delete</button>
                  </div> -->
                  <div class="right-buttons">
                    <button type="button" class="btn btn-viewPdf" onclick="generateAndViewPDF(document.getElementById('requestId').value, 'indigency')">
                      View PDF
                    </button>
                    <button type="submit" id="saveBtn" class="btn btn-save">Save</button>
                  </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>