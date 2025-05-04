<?php
$conn = new mysqli("localhost", "root", "", "reqwest");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize and validate input
$id = $_POST['requestId'] ?? '';
$purpose = $_POST['purpose'] ?? '';
$removeFile = isset($_POST['removeFile']) && $_POST['removeFile'] === '1';

if (empty($id) || empty($purpose)) {
    echo "Invalid request. Missing required fields.";
    exit();
}

// Fetch existing document
$stmt = $conn->prepare("SELECT supporting_document FROM indigency WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existingRow = $result->fetch_assoc();
$existingFile = $existingRow['supporting_document'] ?? '';
$stmt->close();

$supporting_document = $existingFile;

// Handle file upload if a new file is submitted
if (isset($_FILES['supportingDocument']) && $_FILES['supportingDocument']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    $filename = basename($_FILES['supportingDocument']['name']);
    $uploadPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['supportingDocument']['tmp_name'], $uploadPath)) {
        // Delete old file
        if (!empty($existingFile) && file_exists($existingFile)) {
            unlink($existingFile);
        }
        $supporting_document = $uploadPath;
    } else {
        echo "Error uploading the new supporting document.";
        exit();
    }
}
// Handle file removal if selected and no new file is uploaded
elseif ($removeFile) {
    if (!empty($existingFile) && file_exists($existingFile)) {
        unlink($existingFile);
    }
    $supporting_document = '';
}

// Update query
$updateStmt = $conn->prepare("UPDATE indigency SET purpose = ?, supporting_document = ? WHERE id = ?");
$updateStmt->bind_param("ssi", $purpose, $supporting_document, $id);

if ($updateStmt->execute()) {
    echo "Request updated successfully.";
} else {
    echo "Error updating request: " . $conn->error;
}

$updateStmt->close();
$conn->close();
?>
