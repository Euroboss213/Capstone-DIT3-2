<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'error' => 'User not authenticated']);
    exit;
}

if (!isset($_POST['notif_id'])) {
    echo json_encode(['success' => false, 'error' => 'Notification ID not provided']);
    exit;
}

require '../database/connect_db_reqwest.php'; // Adjust path as needed

$notifId = intval($_POST['notif_id']);
$userId = $_SESSION['id'];

// Only delete if the notification belongs to the user
$stmt = $conn->prepare("DELETE FROM notifications WHERE id = ? AND sent_to = ?");
$stmt->bind_param("ii", $notifId, $userId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Failed to delete notification']);
}

$stmt->close();
$conn->close();
