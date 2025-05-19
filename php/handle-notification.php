<?php
function sendNotificationToTarget($status, $requestId, $actorId, $actorRole, $actorName, $documentType, $is_read = 0) {
    global $conn;

    $allowedDocumentTypes = ['indigency', 'certresidency', 'good_moral', 'permit'];
    if (!in_array($documentType, $allowedDocumentTypes)) {
        error_log("Invalid document type: $documentType");
        return;
    }

    // $message = "$actorName submitted a request for Certificates of $documentType.";
    $docTypeName = [
        'indigency' => 'Indigency',
        'certresidency' => 'Residency',
        'good_moral' => 'Good Moral',
        'permit' => 'Barangay Permit'
    ];

    $displayType = $docTypeName[$documentType] ?? $documentType;

    if ($status === 'For Pickup' && $actorRole === 'admin') {
        $message = "Admin approved your request for Certificate of $displayType, make sure to read the comment before picking up";
    } else if ($status === 'Returned' && $actorRole === 'admin') {
        $message = "Admin returned your request for Certificate of $displayType, make sure to read the comment";
    } else if ($status === 'Completed' && $actorRole === 'admin') {
        $message = "Admin updated your request for Certificate of $displayType. Please check the status and comments.";   
    } else if ($actorRole === 'user'){
        $message = "{$actorName}updated his/her request for Certificate of $displayType.";
    } else {
        $message = "{$actorName}submitted a request for Certificate of $displayType.";
    }

    $sentToUser = null;
    $sentToAdmin = null;

    if ($actorRole === 'admin') {

        $stmt = $conn->prepare("SELECT user_id FROM `$documentType` WHERE id = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return;
        }
        $stmt->bind_param("i", $requestId);
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return;
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $sentToUser = $row['user_id'] ?? null;
        $stmt->close();
        error_log("sentToUser: " . var_export($sentToUser, true));
    } else {

        $stmt = $conn->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            return;
        }
        if (!$stmt->execute()) {
            error_log("Execute failed: " . $stmt->error);
            $stmt->close();
            return;
        }
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $sentToAdmin = $row['id'] ?? null;
        $stmt->close();
        error_log("sentToAdmin: " . var_export($sentToAdmin, true));
    }

    if ($sentToUser !== null) {
        $notifStmt = $conn->prepare("INSERT INTO notifications (request_id, document_type, actor_id, actor_role, message, sent_to, is_read) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$notifStmt) {
            error_log("Prepare failed: " . $conn->error);
            return;
        }
        if (!$notifStmt->bind_param("isissii", $requestId, $documentType, $actorId, $actorRole, $message, $sentToUser, $is_read)) {
            error_log("Bind failed: " . $notifStmt->error);
            return;
        }
        if (!$notifStmt->execute()) {
            error_log("Execute failed: " . $notifStmt->error);
        }
        $notifStmt->close();
    }

    if ($sentToAdmin !== null) {
        $notifStmt = $conn->prepare("INSERT INTO notifications (request_id, document_type, actor_id, actor_role, message, sent_to, is_read) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$notifStmt) {
            error_log("Prepare failed: " . $conn->error);
            return;
        }
        if (!$notifStmt->bind_param("isissii", $requestId, $documentType, $actorId, $actorRole, $message, $sentToAdmin, $is_read)) {
            error_log("Bind failed: " . $notifStmt->error);
            return;
        }
        if (!$notifStmt->execute()) {
            error_log("Execute failed: " . $notifStmt->error);
        }
        $notifStmt->close();
    }
}

?>
