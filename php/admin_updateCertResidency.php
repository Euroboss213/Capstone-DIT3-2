<?php
session_start();
include "../database/connect_db_reqwest.php";

$userName = $_SESSION['user_name'] ?? '';
$userId = $_SESSION['id'] ?? '';

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? 'Ongoing';
$comment = trim($_POST['comment'] ?? '');
$form_origin = $_POST['form_origin'];
$actor_id = $_POST['actor_id'];
$actor_role = (stripos($form_origin, 'admin') !== false) ? 'admin' : 'user';

$docTypes = ['indigency', 'certresidency', 'good_moral', 'permit'];
$documentType = null;

foreach ($docTypes as $type) {
    if (stripos($form_origin, $type) !== false) {
        $documentType = $type;
        break;
    }
}

if ($documentType === null) {
    echo "Error: Unknown document type in form_origin.";
    exit;
}

if (empty($id)) {
    echo "Invalid request. Missing ID.";
    exit;
}

$tableName = $documentType;

// 1. Fetch existing data for history
$stmt = $conn->prepare("SELECT r.*, u.first_name, u.middle_name, u.last_name, u.suffix 
                        FROM $tableName r 
                        JOIN users u ON r.user_id = u.id 
                        WHERE r.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existingRow = $result->fetch_assoc();
$stmt->close();

if (!$existingRow) {
    echo "Request not found.";
    exit;
}

$replyVal = $existingRow['reply'] ?? '';
$supporting_document = $existingRow['supporting_document'] ?? '';

// 2. Perform the update
$updateStmt = $conn->prepare("UPDATE $tableName SET status = ?, comment = ? WHERE id = ?");
$updateStmt->bind_param("ssi", $status, $comment, $id);

if ($updateStmt->execute()) {
    include '../php/handle-notification.php';
    sendNotificationToTarget($status, $id, $actor_id, $actor_role, $userName, $documentType);
    echo "Request updated successfully.";

    // 3. Insert into request_history including actor info
    $historyStmt = $conn->prepare("INSERT INTO request_history (
        request_id, user_id, first_name, middle_name, last_name, suffix,
        purpose, date_requested, document_type, status, comment, reply, supporting_document,
        actor, actor_role
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $historyStmt->bind_param(
        "iisssssssssssis",
        $existingRow['id'],
        $existingRow['user_id'],
        $existingRow['first_name'],
        $existingRow['middle_name'],
        $existingRow['last_name'],
        $existingRow['suffix'],
        $existingRow['purpose'],
        $existingRow['date_requested'],
        $existingRow['document_type'],
        $status,
        $comment,
        $replyVal,
        $supporting_document,
        $actor_id,
        $actor_role
    );

    $historyStmt->execute();
    $historyStmt->close();

} else {
    echo "Error updating request: " . $conn->error;
}

$updateStmt->close();
$conn->close();
?>
