<?php
function sendNotificationToTarget($requestId, $actorId, $actorRole, $actorName, $is_read = 0) {
    global $conn;

    // Message content
    $message = "$actorName updated a request (ID: $requestId).";

    // Determine recipient(s)
    $sentToUser = null;
    $sentToAdmin = null;

    // If admin made the action, notify the user
    if ($actorRole === 'admin') {
        // Get the user who owns the request
        $stmt = $conn->prepare("SELECT user_id FROM indigency WHERE id = ?");
        $stmt->bind_param("i", $requestId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $sentToUser = $row['user_id'] ?? null;
        $stmt->close();
    } else {
        // If user made the action, notify the admin
        // Fetch the admin (first admin in the users table)
        $stmt = $conn->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $sentToAdmin = $row['id'] ?? null;
        $stmt->close();
    }

    // Insert notification for user if exists
    if ($sentToUser !== null) {
        $notifStmt = $conn->prepare("INSERT INTO notifications (request_id, actor_id, actor_role, message, sent_to, is_read) VALUES (?, ?, ?, ?, ?, ?)");
        $notifStmt->bind_param("iissii", $requestId, $actorId, $actorRole, $message, $sentToUser, $is_read);
        $notifStmt->execute();
        $notifStmt->close();
    }

    // Insert notification for admin if exists
    if ($sentToAdmin !== null) {
        $notifStmt = $conn->prepare("INSERT INTO notifications (request_id, actor_id, actor_role, message, sent_to, is_read) VALUES (?, ?, ?, ?, ?, ?)");
        $notifStmt->bind_param("iissii", $requestId, $actorId, $actorRole, $message, $sentToAdmin, $is_read);
        $notifStmt->execute();
        $notifStmt->close();
    }
}


?>
