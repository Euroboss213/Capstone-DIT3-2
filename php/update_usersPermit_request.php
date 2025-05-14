<?php
session_start();
include "../database/connect_db_reqwest.php";

// Sanitize and validate input
$userName = $_SESSION['user_name'];
$userId = $_SESSION['id'];

$id = $_POST['requestId'] ?? '';
$purpose = $_POST['purpose'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$permit_type = $_POST['permit_type'] ?? '';
$removeFile = isset($_POST['removeFile']) && $_POST['removeFile'] === '1';
$form_origin = $_POST['form_origin']; // form name: 'admin_updatePermit' or 'update_usersPermit'

// Ensure necessary data is available
if (empty($id) || empty($purpose) || empty($contact_number) || empty($permit_type)) {
    echo "Invalid request. Missing required fields.";
    exit();
}

// Fetch existing document
$stmt = $conn->prepare("SELECT supporting_document FROM permit WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existingRow = $result->fetch_assoc();
$existingFile = $existingRow['supporting_document'] ?? '';
$stmt->close();

$supporting_document = $existingFile; // Default to existing file if no new file is uploaded

// Handle file upload if a new file is submitted
if (isset($_FILES['supporting_document']) && $_FILES['supporting_document']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    $filename = basename($_FILES['supporting_document']['name']);
    $uploadPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['supporting_document']['tmp_name'], $uploadPath)) {
        // Delete old file if exists
        if (!empty($existingFile) && file_exists("../" . $existingFile)) {
            unlink("../" . $existingFile);
        }
        $supporting_document = $uploadPath;
    } else {
        echo "Error uploading the new supporting document.";
        exit();
    }
}
// Handle file removal if selected and no new file is uploaded
elseif ($removeFile) {
    if (!empty($existingFile) && file_exists("../" . $existingFile)) {
        unlink("../" . $existingFile);
    }
    $supporting_document = ''; // Set to empty as the file is removed
}

// Update query
$updateStmt = $conn->prepare("UPDATE permit SET purpose = ?, contact_number = ?, permit_type = ?, supporting_document = ?, status = 'ongoing' WHERE id = ?");
$updateStmt->bind_param("ssssi", $purpose, $contact_number, $permit_type, $supporting_document, $id);

if ($updateStmt->execute()) {
    echo "Request updated successfully.";
} else {
    echo "Error updating request: " . $conn->error;
}

$updateStmt->close();
$conn->close();
?>
