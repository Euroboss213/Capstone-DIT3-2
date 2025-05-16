<?php
$conn = new mysqli("localhost", "root", "", "reqwest");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

// First, delete related notifications
$notifSql = "DELETE FROM notifications WHERE request_id = ?";
$notifStmt = $conn->prepare($notifSql);
$notifStmt->bind_param("i", $id);
$notifStmt->execute();
$notifStmt->close();

// Then, delete the request from the indigency table
$sql = "DELETE FROM indigency WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo "Request deleted successfully.";
} else {
  echo "Error deleting record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
