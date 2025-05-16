<?php
session_start();
include "../database/connect_db_reqwest.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['requestId'] ?? null;
    $status = $_POST['status'] ?? '';
    $comment = $_POST['comment'] ?? '';

    if (!$id) {
        echo "Invalid request ID.";
        exit;
    }

    $stmt = $conn->prepare("UPDATE permit SET status = ?, comment = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("ssi", $status, $comment, $id);

        if ($stmt->execute()) {
            echo "Permit request updated successfully.";
        } else {
            echo "Failed to update permit request.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
