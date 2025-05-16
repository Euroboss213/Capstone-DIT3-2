<?php
include '../database/connect_db_reqwest.php';

$userId = $_SESSION['id'];
$role = $_SESSION['role']; // 'admin' or 'user'

$sql = "SELECT * FROM notifications WHERE sent_to = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    // Extract message to determine the document type (for dynamic link)
    $message = $row['message'];
    $documentType = '';

    // Optional logic to determine document type from message text
    if (strpos($message, 'Indigency') !== false) {
        $documentType = 'indigency';
    } elseif (strpos($message, 'Permit') !== false) {
        $documentType = 'permit';
    } elseif (strpos($message, 'Residency') !== false) {
        $documentType = 'residency';
    } elseif (strpos($message, 'Business Clearance') !== false) {
        $documentType = 'business';
    }

    // Determine which base path to use
    $pagePrefix = ($role === 'admin') ? 'adminDocReq_indigency' : 'userViewReq_indigency';
    $targetPage = $pagePrefix . $documentType . '.php';

    echo '<div class="notification-item">';
    echo '<p class="notif-message">' . htmlspecialchars($message) . '</p>';
    echo '<p class="notif-date">' . htmlspecialchars($row['created_at']) . '</p>';
    echo '<div class="button-wrapper">';
    echo '<button id="notifButton-unread" class="view-button" onclick="window.location.href=\'' . $targetPage . '\'">View</button>';
    echo '</div>';
    echo '</div>';
}
?>
