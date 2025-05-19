<?php
$conn = new mysqli("localhost", "root", "", "reqwest");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

// delete also from the notifications
$notifSql = "DELETE FROM notifications WHERE request_id = ?";
$notifStmt = $conn->prepare($notifSql);
$notifStmt->bind_param("i", $id);
$notifStmt->execute();
$notifStmt->close();

$sql = "DELETE FROM permit WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Barangay permit request deleted successfully.";
} else {
    echo "Error deleting request: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>