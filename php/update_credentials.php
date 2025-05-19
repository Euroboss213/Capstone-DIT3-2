<?php
session_start();
include "../database/connect_db_reqwest.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../pages/newlogin.php");
    exit();
}

$userId = $_SESSION['id'];
$existingUsername = $_SESSION['userName'];

// Get form data and sanitize
$newUsername = trim($_POST['new_username']);
$newPassword = trim($_POST['new_password']);
$confirmPassword = trim($_POST['confirm_password']);

// If both username and password are empty, alert and exit
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

// If username is empty, reuse the existing one
if (empty($newUsername)) {
    $newUsername = $existingUsername;
}

// If the username is different, update it
if ($newUsername !== $existingUsername) {
    $updateFields[] = "username = ?";
    $params[] = $newUsername;
    $types .= "s";
}

// If new password is given, hash and update
if (!empty($newPassword)) {
    $currentPassword = $_POST['current_password'];

    if (empty($currentPassword)) {
    echo "<script>alert('Please enter your current password.'); window.history.back();</script>";
    exit();
    }

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

    // $password_requirements = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/";

    // if (!preg_match($password_requirements, $newPassword)) {
    //     exit();
    // }

    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateFields[] = "password = ?";
    $params[] = $hashedPassword;
    $types .= "s";
}

if (count($updateFields) > 0) {
    $params[] = $userId;
    $types .= "i";

    $sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Prepare dynamic binding
    $bind_names[] = $types;
    foreach ($params as $key => $value) {
        $bind_names[] = &$params[$key];
    }

    call_user_func_array([$stmt, 'bind_param'], $bind_names);
    $stmt->execute();

    // Destroy session after update to force re-login
    session_unset();
    session_destroy();

    echo "<script>alert('Account updated successfully! Please log in again.'); window.location.href='../pages/newlogin.php';</script>";
    } else {
        echo "<script>alert('No changes made.'); window.history.back();</script>";
    }
?>
