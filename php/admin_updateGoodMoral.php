<?php
session_start();
include "../database/connect_db_reqwest.php";

$userName = $_SESSION['user_name'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['requestId'] ?? null;
    $status = $_POST['status'] ?? '';
    $comment = $_POST['comment'] ?? '';
    $form_origin = $_POST['form_origin'];
    $actor_id = $_POST['actor_id']; // the one who made the update
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
        echo "Error: Unknown document type in form_origin";
        exit;
    }

    if (!$id) {
        echo "Invalid request ID.";
        exit;
    }

    // 1. Fetch existing data for history logging
    $fetchStmt = $conn->prepare("SELECT g.*, u.first_name, u.middle_name, u.last_name, u.suffix 
                                 FROM good_moral g 
                                 JOIN users u ON g.user_id = u.id 
                                 WHERE g.id = ?");
    $fetchStmt->bind_param("i", $id);
    $fetchStmt->execute();
    $result = $fetchStmt->get_result();
    $existingRow = $result->fetch_assoc();
    $fetchStmt->close();

    if (!$existingRow) {
        echo "Request not found.";
        exit;
    }

    $replyVal = $existingRow['reply'] ?? '';
    $supporting_document = $existingRow['supporting_document'] ?? '';

    // 2. Perform the update
    $stmt = $conn->prepare("UPDATE good_moral SET status = ?, comment = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ssi", $status, $comment, $id);

        if ($stmt->execute()) {
            echo "Good Moral request updated successfully.";

            // Send notification
            include '../php/handle-notification.php';
            sendNotificationToTarget($status, $id, $actor_id, $actor_role, $userName, $documentType);

            // 3. Log to request_history including actor and actor_role
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
            echo "Failed to update Good Moral request.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
