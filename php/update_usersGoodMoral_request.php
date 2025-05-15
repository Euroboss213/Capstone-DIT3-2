<?php
session_start();
include "../database/connect_db_reqwest.php";

// Sanitize and validate input
$userName = $_SESSION['user_name'] ?? '';
$userId = $_SESSION['id'] ?? '';

$id = $_POST['requestId'] ?? '';
$purpose = $_POST['purpose'] ?? '';
$removeFile = isset($_POST['removeFile']) && $_POST['removeFile'] === '1';

// Ensure required fields
if (empty($id) || empty($purpose)) {
    echo "Invalid request. Missing required fields.";
    exit();
}

// Fetch existing document
$stmt = $conn->prepare("SELECT supporting_document FROM good_moral WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existingRow = $result->fetch_assoc();
$existingFile = $existingRow['supporting_document'] ?? '';
$stmt->close();

$supporting_document = $existingFile; // Default to existing file if no new one is uploaded

// Handle file upload
if (isset($_FILES['supportingDocument']) && $_FILES['supportingDocument']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    $filename = time() . "_" . basename($_FILES['supportingDocument']['name']); // avoid filename collision
    $uploadPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['supportingDocument']['tmp_name'], $uploadPath)) {
        // Delete old file if it exists
        if (!empty($existingFile) && file_exists("../" . $existingFile)) {
            unlink("../" . $existingFile);
        }
        $supporting_document = $uploadPath;
    } else {
        echo "Error uploading the new supporting document.";
        exit();
    }
}
// Handle file removal
elseif ($removeFile) {
    if (!empty($existingFile) && file_exists("../" . $existingFile)) {
        unlink("../" . $existingFile);
    }
    $supporting_document = ''; // Set to empty because file is removed
}

// Update the record
$updateStmt = $conn->prepare("UPDATE good_moral SET purpose = ?, supporting_document = ?, status = 'Ongoing' WHERE id = ?");
$updateStmt->bind_param("ssi", $purpose, $supporting_document, $id);

if ($updateStmt->execute()) {
    echo "Request updated successfully.";
} else {
    echo "Error updating request: " . $conn->error;
}

$updateStmt->close();
$conn->close();
?>
