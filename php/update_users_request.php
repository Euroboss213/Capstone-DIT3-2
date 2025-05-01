<?php
$conn = new mysqli("localhost", "root", "", "reqwest");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['requestId'];
$purpose = $conn->real_escape_string($_POST['purpose']); // Prevent SQL injection

// Handle file upload for supporting_document
if (isset($_FILES['supportingDocument']) && $_FILES['supportingDocument']['error'] == 0) {
    $supporting_document_name = $_FILES['supportingDocument']['name'];
    $supporting_document_tmp_name = $_FILES['supportingDocument']['tmp_name'];
    $upload_directory = 'uploads/';  // Define where to save the uploaded file
    $upload_path = $upload_directory . basename($supporting_document_name);

    if (move_uploaded_file($supporting_document_tmp_name, $upload_path)) {
        $supporting_document = $conn->real_escape_string($upload_path); // Store the file path in the database
    } else {
        echo "Error uploading the supporting document.";
        exit();
    }
} else {
    // If no file is uploaded, you can decide whether to store a default value (e.g., NULL) or leave it empty
    $supporting_document = NULL;
}

$sql = "UPDATE indigency SET purpose='$purpose', supporting_document='$supporting_document' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
  echo "Request updated successfully.";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
