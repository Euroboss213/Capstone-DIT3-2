<?php
session_start();
include "../database/connect_db_reqwest.php";

// Get session data
$userName = $_SESSION['user_name'];
$id = $_POST['requestId']; // The ID of the request to update
$status = $_POST['status']; // New status for the request
$is_read = (int)$_POST['is_read']; // Read status of the notification
$comment = $conn->real_escape_string($_POST['comment']); // Prevent SQL injection for comment
$form_origin = $_POST['form_origin']; // Form name: 'admin_updateIndigency' or 'update_usersIndigency'
$actor_id = $_POST['actor_id']; // Actor ID (admin or user who made the update)
$actor_role = ($form_origin === 'admin_updateIndigency') ? 'admin' : 'user'; // Determine the role

// SQL to update the status and comment of the request
$sql = "UPDATE indigency SET status='$status', comment='$comment' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
    echo "Request Updated Successfully";
    // Include the notification handler
    include '../php/handle-notification.php';

    // Send notification to target (user or admin)
    sendNotificationToTarget($id, $actor_id, $actor_role, $userName, $is_read);
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
