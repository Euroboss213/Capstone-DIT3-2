<?php
session_start();
include "../database/connect_db_reqwest.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../pages/newlogin.php");
    exit();
}

$userId = $_SESSION['id'];

// Fetch current username from DB
$sql = "SELECT username FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    session_unset();
    session_destroy();
    header("Location: ../pages/newlogin.php");
    exit();
}

$currentUsername = $row['username'];

// Get form data and sanitize
$newUsername = trim($_POST['new_username']);
$newPassword = trim($_POST['new_password']);
$confirmPassword = trim($_POST['confirm_password']);
$currentPassword = trim($_POST['current_password'] ?? '');

// If both username and password fields are empty, no change
if (empty($newUsername) && empty($newPassword)) {
    echo "<script>alert('No changes made.'); window.history.back();</script>";
    exit();
}

// If password is given but confirmation doesn't match
if (!empty($newPassword) && $newPassword !== $confirmPassword) {
    echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
    exit();
}

$updateFields = [];
$params = [];
$types = "";

// If username is empty, reuse the current one (so username change is optional)
if (empty($newUsername)) {
    $newUsername = $currentUsername;
}

// If the username is different, add to update list
if ($newUsername !== $currentUsername) {
    $updateFields[] = "username = ?";
    $params[] = $newUsername;
    $types .= "s";
}

// Password change handling
if (strlen($newPassword) > 0) {
    // Require current password only if changing password
    if (empty($currentPassword)) {
        echo "<script>alert('Please enter your current password to change password.'); window.history.back();</script>";
        exit();
    }

    // Password requirement checks ONLY if changing password:
    if (strlen($newPassword) < 8) {
        echo "<script>alert('New password must be at least 8 characters long.'); window.history.back();</script>";
        exit();
    }

    // Verify current password in DB
    $sql = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if (!$row || !password_verify($currentPassword, $row['password'])) {
        echo "<script>alert('Current password is incorrect.'); window.history.back();</script>";
        exit();
    }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateFields[] = "password = ?";
    $params[] = $hashedPassword;
    $types .= "s";
}

// If there is something to update
if (count($updateFields) > 0) {
    $params[] = $userId;
    $types .= "i";

    $sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Dynamic binding for parameters
    $bind_names = [];
    $bind_names[] = &$types;
    foreach ($params as $key => $value) {
        $bind_names[] = &$params[$key];
    }

    call_user_func_array([$stmt, 'bind_param'], $bind_names);

    if ($stmt->execute()) {
        // Update session username if changed (optional, since you destroy session anyway)
        if ($newUsername !== $currentUsername) {
            $_SESSION['userName'] = $newUsername;
        }

        // Destroy session to force re-login after update
        session_unset();
        session_destroy();

        echo "<script>alert('Account updated successfully! Please log in again.'); window.location.href='../pages/newlogin.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update account. Please try again later.'); window.history.back();</script>";
        exit();
    }
} else {
    // No updates made
    echo "<script>alert('No changes made.'); window.history.back();</script>";
    exit();
}
?>
