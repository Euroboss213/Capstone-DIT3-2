<?php
session_start();
include "../database/connect_db_reqwest.php";

$userName = $_SESSION['user_name'] ?? '';
$userId = $_SESSION['id'] ?? '';

$id = $_POST['requestId'] ?? '';
$purpose = $_POST['purpose'] ?? '';
$contact_number = $_POST['contact_number'] ?? '';
$reply = $_POST['reply'] ?? '';
$removeFile = isset($_POST['removeFile']) && $_POST['removeFile'] === '1';
$form_origin = $_POST['form_origin'];
$actor_id = $_POST['actor_id'];
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

// ✅ Update DB with reply
$updateStmt = $conn->prepare("UPDATE certresidency SET purpose = ?, contact_number = ?, supporting_document = ?, reply = ?, status = 'Ongoing' WHERE id = ?");
$updateStmt->bind_param("ssssi", $purpose, $contact_number, $supporting_document, $reply, $id);

if ($updateStmt->execute()) {
    include '../php/handle-notification.php';
    sendNotificationToTarget($documentType, $id, $actor_id, $actor_role, $userName, $type);

    // 📝 Save snapshot to request_history
    $fetchStmt = $conn->prepare("
        SELECT r.*, u.first_name, u.middle_name, u.last_name, u.suffix
        FROM certresidency r
        JOIN users u ON r.user_id = u.id
        WHERE r.id = ?
    ");
    $fetchStmt->bind_param("i", $id);
    $fetchStmt->execute();
    $result = $fetchStmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $historyStmt = $conn->prepare("INSERT INTO request_history (
            request_id, user_id, first_name, middle_name, last_name, suffix,
            purpose, date_requested, document_type, status, comment, reply, supporting_document,
            actor, actor_role
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        $historyStmt->bind_param(
            "iisssssssssssis",
            $row['id'],
            $row['user_id'],
            $row['first_name'],
            $row['middle_name'],
            $row['last_name'],
            $row['suffix'],
            $row['purpose'],
            $row['date_requested'],
            $row['document_type'],
            $row['status'],
            $row['comment'],
            $row['reply'],
            $row['supporting_document'],
            $actor_id,
            $actor_role
        );

        $historyStmt->execute();
        $historyStmt->close();
    }

    $fetchStmt->close();

    echo "Request updated successfully.";
} else {
    echo "Error updating request: " . $conn->error;
}

$updateStmt->close();
$conn->close();
?>
