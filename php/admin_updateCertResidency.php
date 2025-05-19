<?php
session_start();
include "../database/connect_db_reqwest.php";

$userName = $_SESSION['user_name'] ?? '';
$userId = $_SESSION['id'] ?? '';

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? 'Ongoing';
$comment = trim($_POST['comment'] ?? '');
$form_origin = $_POST['form_origin']; // Form name: 'admin_updateIndigency' or 'update_usersIndigency'
$actor_id = $_POST['actor_id']; // Actor ID (admin or user who made the update)
$actor_role = ($form_origin === 'admin_updateCertResidency') ? 'admin' : 'user'; // Determine the role

// Detect the document type from the form_origin value
$docTypes = ['indigency', 'certresidency', 'good_moral', 'permit'];
$documentType = null;

foreach ($docTypes as $type) {
    if (stripos($form_origin, $type) !== false) {
        $documentType = $type;
        break;
    }
}

if ($documentType === null) {
    echo "Error: Unknown document type in form_origin";
    exit;
}


if (empty($id)) {
    echo "Invalid request. Missing ID.";
    exit();
}

// Get existing supporting document path
$stmt = $conn->prepare("SELECT supporting_document FROM certresidency WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existingRow = $result->fetch_assoc();
$supporting_document = $existingRow['supporting_document'] ?? '';
$stmt->close();

// Only update status and comment
$updateStmt = $conn->prepare("UPDATE certresidency SET status = ?, comment = ? WHERE id = ?");
$updateStmt->bind_param("ssi", $status, $comment, $id);

if ($updateStmt->execute()) {
    echo "Request updated successfully.";

     // Include the notification handler
    include '../php/handle-notification.php';

    // Prepare type (status becomes the notification type)
    $type = $status;

    // Send notification to target (user or admin)
    sendNotificationToTarget($type, $id, $actor_id, $actor_role, $userName, $documentType);
} else {
    echo "Error updating request: " . $conn->error;
}

$updateStmt->close();
$conn->close();
?>
