<?php
session_start();
include "../database/connect_db_reqwest.php";

$userName = $_SESSION['user_name'] ?? '';
$userId = $_SESSION['id'] ?? '';

$id = $_POST['id'] ?? '';
$status = $_POST['status'] ?? 'Ongoing';
$comment = trim($_POST['comment'] ?? '');

if (empty($id)) {
    echo "Invalid request. Missing ID.";
    exit();
}

// Get existing supporting document path
$stmt = $conn->prepare("SELECT supporting_document FROM certresidency WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$existingRow = $result->fetch_assoc();
$supporting_document = $existingRow['supporting_document'] ?? '';
$stmt->close();

// Only update status and comment
$updateStmt = $conn->prepare("UPDATE certresidency SET status = ?, comment = ? WHERE id = ?");
$updateStmt->bind_param("ssi", $status, $comment, $id);

if ($updateStmt->execute()) {
    echo "Request updated successfully.";
} else {
    echo "Error updating request: " . $conn->error;
}

$updateStmt->close();
$conn->close();
?>
