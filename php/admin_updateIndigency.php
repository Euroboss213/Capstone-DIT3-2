<?php
session_start();
include "../database/connect_db_reqwest.php";

// Get session data
$userName = $_SESSION['user_name'];
$userId = $_SESSION['id'];

$id = $_POST['requestId'];
$status = $_POST['status'];
$is_read = (int)$_POST['is_read'];
$comment = $conn->real_escape_string($_POST['comment']);
$form_origin = $_POST['form_origin'];
$actor_id = $_POST['actor_id'];
$actor_role = (stripos($form_origin, 'admin') !== false) ? 'admin' : 'user';

// Detect document type
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

// 1. Fetch existing request info
$stmt = $conn->prepare("SELECT r.*, u.first_name, u.middle_name, u.last_name, u.suffix 
                        FROM `$documentType` r 
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

// 2. Update request status and comment
$sql = "UPDATE `$documentType` SET status='$status', comment='$comment' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Request Updated Successfully";

    // 3. Send notification
    include '../php/handle-notification.php';
    sendNotificationToTarget($status, $id, $actor_id, $actor_role, $userName, $documentType);

    // 4. Insert into request_history
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
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
