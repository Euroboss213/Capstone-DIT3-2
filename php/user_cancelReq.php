<?php
if (!isset($_GET['id'])) {
    echo "Invalid ID.";
    exit;
}

$id = intval($_GET['id']);

// DB connection
$conn = new mysqli("localhost", "root", "", "reqwest");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Soft delete or real delete
$sql = "DELETE FROM indigency WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Request cancelled successfully.";
} else {
    echo "Failed to cancel request.";
}

$stmt->close();
$conn->close();
?>
