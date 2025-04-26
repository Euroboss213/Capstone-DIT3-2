<?php
$conn = new mysqli("localhost", "root", "", "reqwest");
if ($conn->connect_error) {
  die("connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM indigency";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "
    <table class='documents-table'>
      <thead>
        <tr>
          <th>Full Name</th>
          <th>Purpose</th>
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
    $fullname = $row["first_name"] . " " . ($row["middle_name"] ? $row["middle_name"] . " " : "") . $row["last_name"] . ($row["suffix"] ? ", " . $row["suffix"] : "");

    echo "
      <tr>
          <td>{$fullname}</td>
          <td>{$row['purpose']}</td>
          <td>" . (!empty($row['supporting_document']) ? $row['supporting_document'] : 'No attached file') . "</td>
          <td>{$row['status']}</td>
          <td>{$row['comment']}</td>
          <td>{$row['date_requested']}</td>
          <td>
            <button class='more-info-btn' onclick='openModal(" . json_encode($row) . ")'>View and Edit</button>
          </td>
      </tr>
    ";
  }

  echo "
      </tbody>
    </table>
  ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Barangay Document Request</title>
  <link rel="stylesheet" href="../styles/adminTemplate.css" />
  <link rel="stylesheet" href="../styles/adminResidents_style.css" />
  <script src="../js/adminDocReq_script.js" defer></script>
  <script src="../js/adminNav.js" defer></script>
</head>
<body>
    <!-- Modal part -->
    <div id="infoModal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h2>Request Information</h2>
            <form id="residentForm" method="POST" action="../php/update_comments_status.php">
            <input type="hidden" id="id" name="id" />
            <div class="form-grid">
                <label>First Name: <input type="text" id="first_name" name="first_name" readonly /></label>
                <label>Middle Name: <input type="text" id="middle_name" name="middle_name" readonly /></label>
                <label>Last Name: <input type="text" id="last_name" name="last_name" readonly /></label>
                <label>Suffix: <input type="text" id="suffix" name="suffix" readonly /></label>

                <label>Supporting Document:</label>
                <div id="supporting_document_preview" style="margin-bottom: 10px;">
                    No document uploaded.
                </div>

                <label>Status: 
                <select id="status" name="status">
                    <option value="Ongoing">Ongoing</option>
                    <option value="Returned">Returned</option>
                    <option value="For Pickup">For Pickup</option>
                </select>
                </label>

                <label>Comment: <input type="text" id="comment" name="comment" /></label>
            </div>

            <div class="modal-footer">
                <button type="submit" class="save-btn">Save Changes</button>
                <button type="button" class="delete-btn" onclick="deleteIndigency()">Delete</button>
            </div>
            </form>
        </div>
    </div>
</body>
</html>
