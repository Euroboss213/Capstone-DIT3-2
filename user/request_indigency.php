<?php
include "../php/auth_check.php"; 

$lastName = $_SESSION['last_name'] ?? '';
$firstName = $_SESSION['first_name'] ?? '';
$middleName = $_SESSION['middle_name'] ?? '';
$suffix = $_SESSION['suffix'] ?? '';
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
    <form method="POST" action="../php/handle_request_indigency.php" enctype="multipart/form-data">
      <input type="hidden" name="document_type" value="indigency">

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
