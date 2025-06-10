<?php
include "../database/connect_db_reqwest.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // hidden input
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $suffix = $_POST['suffix'];

    // Hash password if you're storing hashed passwords
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("UPDATE users SET 
    first_name = ?, middle_name = ?, last_name = ?, suffix = ?
    WHERE id = ?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $first_name, $middle_name, $last_name, $suffix, $id);

    if ($stmt->execute()) {
        header("Location: ../superadmin/adminUserAccounts.php?update=success"); // or wherever you want
        exit();
    } else {
        echo "Error updating account: " . $conn->error;
    }
}
?>
