<?php
include "../php/auth_check.php";
include "../database/connect_db_reqwest.php";

// Get the user's data from session
$lastName = $_SESSION['last_name'];
$firstName = $_SESSION['first_name'];
$middleName = $_SESSION['middle_name'];
$suffix = $_SESSION['suffix'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purpose = $_POST['purpose'];
    $supportingDocument = '';

    // File upload logic
    if (isset($_FILES['supporting_document']) && $_FILES['supporting_document']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $fileName = basename($_FILES['supporting_document']['name']);
        $targetFile = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($_FILES['supporting_document']['tmp_name'], $targetFile)) {
            $supportingDocument = $targetFile;
        }
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO indigency (last_name, first_name, middle_name, suffix, purpose, supporting_document) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $lastName, $firstName, $middleName, $suffix, $purpose, $supportingDocument);

    if ($stmt->execute()) {
        echo "<script>alert('Request submitted successfully!'); window.location.href='userHome.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Request Barangay Indigency</title>
  <link rel="stylesheet" href="../styles/request_form.css" />
</head>
<body>
  <div class="form-container">
    <h2>Barangay Indigency Request Form</h2>
    <form method="POST" enctype="multipart/form-data">
      <label>Last Name:</label>
      <input type="text" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>" readonly>

      <label>First Name:</label>
      <input type="text" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>" readonly>

      <label>Middle Name:</label>
      <input type="text" name="middle_name" value="<?php echo htmlspecialchars($middleName); ?>" readonly>

      <label>Suffix:</label>
      <input type="text" name="suffix" value="<?php echo htmlspecialchars($suffix); ?>" readonly>

      <label>Purpose of Request:</label>
      <textarea name="purpose" required></textarea>

      <label>Supporting Document (optional):</label>
      <input type="file" name="supporting_document" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">

      <button type="submit">Submit Request</button>
    </form>
  </div>
</body>
</html>
