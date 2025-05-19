<?php
session_start();
include "../database/connect_db_reqwest.php";

$userName = $_SESSION['user_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['requestId'] ?? null;
    $status = $_POST['status'] ?? '';
    $comment = $_POST['comment'] ?? '';
    $form_origin = $_POST['form_origin']; // Form name: 'admin_updateIndigency' or 'update_usersIndigency'
    $actor_id = $_POST['actor_id']; // Actor ID (admin or user who made the update)
    $actor_role = ($form_origin === 'admin_updatePermit') ? 'admin' : 'user'; // Determine the role

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

    if (!$id) {
        echo "Invalid request ID.";
        exit;
    }

    $stmt = $conn->prepare("UPDATE permit SET status = ?, comment = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ssi", $status, $comment, $id);

        if ($stmt->execute()) {
            echo "Permit request updated successfully.";
            // Include the notification handler
            include '../php/handle-notification.php';

            // Prepare type (status becomes the notification type)
            $type = $status;

            // Send notification to target (user or admin)
            sendNotificationToTarget($type, $id, $actor_id, $actor_role, $userName, $documentType);
        } else {
            echo "Failed to update permit request.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
