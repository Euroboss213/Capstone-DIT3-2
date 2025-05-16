<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection
include "../database/connect_db_reqwest.php"; 

if (!isset($_SESSION['id'])) {
    http_response_code(403);
    echo "Not authenticated";
    exit;
}

$userId = $_SESSION['id'];

// Debug the connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE sent_to = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$stmt->close();
$conn->close();
echo "Notifications marked as read";
?>
