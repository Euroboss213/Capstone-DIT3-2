<?php
include "../database/connect_db_reqwest.php"; // your DB connection

if (isset($_POST['user_id']) && isset($_POST['acc_status'])) {
    $userId = intval($_POST['user_id']);
    $accStatus = $_POST['acc_status'] === 'active' ? 'active' : 'inactive';

    $stmt = $conn->prepare("UPDATE users SET acc_status = ? WHERE id = ?");
    $stmt->bind_param("si", $accStatus, $userId);
    if ($stmt->execute()) {
        echo "Status updated to $accStatus.";
    } else {
        echo "Error updating status.";
    }
    $stmt->close();
} else {
    echo "Invalid request.";
}
?>
