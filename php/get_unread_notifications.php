<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include "../database/connect_db_reqwest.php"; 

$user_id = $_SESSION['id'];

$hasUnread = false;

// Debugging: Check if the database connection is successful
// if ($conn->connect_error) {
//     echo "Error: Could not connect to the database.";
//     exit();  // Exit the script if there is a connection error
// } else {
//     echo "Connected to the database successfully.";  // Debugging: Confirm the connection
// }

$stmt = $conn->prepare("SELECT COUNT(*) FROM notifications WHERE sent_to = ? AND is_read = 0");
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    $stmt->bind_result($count);
    $stmt->fetch();
    // echo "Unread notifications: " . $count;  // Debugging output
    
    if ($count > 0) {
        $hasUnread = true;
    } else {
        $hasUnread = false;
    }
} else {
    echo "Query failed: " . $stmt->error;  // Debugging query error
}

$stmt->close();
$conn->close();
?>
