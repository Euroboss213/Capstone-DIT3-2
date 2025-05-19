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
    if (strpos($message, 'Indigency') !== false || strpos($message, 'indigency') !== false) {
        $documentType = 'indigency';
    } elseif (strpos($message, 'Permit') !== false || strpos($message, 'permit') !== false) {
        $documentType = 'permit';
    } elseif (strpos($message, 'Residency') !== false || strpos($message, 'residency') !== false) {
        $documentType = 'residency';
    } elseif (strpos($message, 'Good Moral') !== false || strpos($message, 'good moral') !== false) {
        $documentType = 'good_moral';
    }

    // Determine which base path to use
    $pagePrefix = ($role === 'user') ? 'userViewReq_' : 'adminDocReq_';
    $targetPage = $pagePrefix . $documentType . '.php';

    echo '<div class="notification-item" id="notif-' . htmlspecialchars($row['id']) . '">';
    echo '<p class="notif-message">' . htmlspecialchars($message) . '</p>';
    echo '<p class="notif-date">' . htmlspecialchars($row['created_at']) . '</p>';
    echo '<div class="button-wrapper">';
    echo '<button class="view-button" id="notifButton-unread" onclick="window.location.href=\'' . $targetPage . '\'">View</button>';
    echo '<button class="delete-button" onclick="deleteNotification(' . htmlspecialchars($row['id']) . ')">Delete</button>';
    echo '</div>';
    echo '</div>';

}
?>
