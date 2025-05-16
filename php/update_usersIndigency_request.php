<?php
session_start();
include "../database/connect_db_reqwest.php";

// Sanitize and validate input
$userName = $_SESSION['user_name'];
$userId = $_SESSION['id'];

$id = $_POST['requestId'] ?? '';
$is_read = (int)$_POST['is_read'];
$purpose = $_POST['purpose'] ?? '';
$removeFile = isset($_POST['removeFile']) && $_POST['removeFile'] === '1';
$form_origin = $_POST['form_origin']; // form name: 'admin_updateIndigency' or 'update_usersIndigency'
$actor_id = $_POST['actor_id']; // passed via hidden input
$actor_role = 'user';

$stmtRole = $conn->prepare("SELECT role FROM users WHERE id = ?");
$stmtRole->bind_param("i", $userId);
$stmtRole->execute();
$resultRole = $stmtRole->get_result();
if ($row = $resultRole->fetch_assoc()) {
    $actor_role = $row['role']; // Fetch actual role
}
$stmtRole->close();

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
$updateStmt = $conn->prepare("UPDATE indigency SET purpose = ?, supporting_document = ?, status = 'ongoing' WHERE id = ?");
$updateStmt->bind_param("ssi", $purpose, $supporting_document, $id);


if ($updateStmt->execute()) {
    include '../php/handle-notification.php';
    sendNotificationToTarget($id, $actor_id, $actor_role, $userName, $is_read);
    echo "Request updated successfully.";
} else {
    echo "Error updating request: " . $conn->error;
}

$updateStmt->close();
$conn->close();
?>
