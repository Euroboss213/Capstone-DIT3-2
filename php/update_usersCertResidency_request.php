<?php
session_start();
include "../database/connect_db_reqwest.php";

$userName = $_SESSION['user_name'];
$userId = $_SESSION['id'];

$id = $_POST['requestId'] ?? '';
$purpose = $_POST['purpose'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$removeFile = isset($_POST['removeFile']) && $_POST['removeFile'] === '1';
$form_origin = $_POST['form_origin']; 
$actor_id = $_POST['actor_id']; // passed via hidden input
$actor_role = 'user';

$docTypes = ['indigency', 'certresidency', 'good_moral', 'permit'];
$documentType = null;

foreach ($docTypes as $type) {
    if (stripos($form_origin, $type) !== false) {
        $documentType = $type;
        break;
    }
}

if (empty($id) || empty($purpose) || empty($contact_number)) {
    echo "Invalid request. Missing required fields.";
    exit();
}

// Fetch existing file
$stmt = $conn->prepare("SELECT supporting_document FROM certresidency WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existingRow = $result->fetch_assoc();
$existingFile = $existingRow['supporting_document'] ?? '';
$stmt->close();

$supporting_document = $existingFile;

// Handle new upload
if (isset($_FILES['supportingDocument']) && $_FILES['supportingDocument']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/';
    $filename = uniqid('residency_') . "_" . basename($_FILES['supportingDocument']['name']);
    $uploadPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['supportingDocument']['tmp_name'], $uploadPath)) {
        if (!empty($existingFile) && file_exists("../" . $existingFile)) {
            unlink("../" . $existingFile);
        }
        $supporting_document = "uploads/" . $filename;
    } else {
        echo "Error uploading the new supporting document.";
        exit();
    }
} elseif ($removeFile) {
    if (!empty($existingFile) && file_exists("../" . $existingFile)) {
        unlink("../" . $existingFile);
    }
    $supporting_document = null;
}

// ✅ Update DB with contact_number
$updateStmt = $conn->prepare("UPDATE certresidency SET purpose = ?, contact_number = ?, supporting_document = ?, status = 'Ongoing' WHERE id = ?");
$updateStmt->bind_param("sssi", $purpose, $contact_number, $supporting_document, $id);

if ($updateStmt->execute()) {
    include '../php/handle-notification.php';

    sendNotificationToTarget($documentType, $id, $actor_id, $actor_role, $userName, $type);
    echo "Request updated successfully.";
} else {
    echo "Error updating request: " . $conn->error;
}

$updateStmt->close();
$conn->close();
?>
