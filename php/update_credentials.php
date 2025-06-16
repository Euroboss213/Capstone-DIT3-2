<?php
session_start();
include "../database/connect_db_reqwest.php";

if (!isset($_SESSION['id'])) {
    header("Location: ../pages/newlogin.php");
    exit();
}

$userId = $_SESSION['id'];

// Fetch current user data, including role
$sql = "SELECT username, role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    session_unset();
    session_destroy();
    header("Location: ../pages/newlogin.php");
}
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

$currentUsername = $row['username'];
$role = $row['role']; // Get user role

// Get form data
$newUsername = trim($_POST['new_username'] ?? '');
$newPassword = trim($_POST['new_password'] ?? '');
$confirmPassword = trim($_POST['confirm_password'] ?? '');
$currentPassword = trim($_POST['current_password'] ?? '');

// Initialize update fields
$updateFields = [];
$params = [];
$types = "";

// If both username and password are empty, and role is not admin or no admin-specific fields are present
if (empty($newUsername) && empty($newPassword) &&
    ($role !== 'admin' || (
        empty(trim($_POST['new_first_name'] ?? '')) &&
        empty(trim($_POST['new_middle_name'] ?? '')) &&
        empty(trim($_POST['new_last_name'] ?? '')) &&
        empty(trim($_POST['new_suffix'] ?? ''))
    ))
) {
    echo "<script>alert('No changes made.'); window.history.back();</script>";
    exit();
}

// Username processing
// If username is empty, reuse the current one (so username change is optional)
if (empty($newUsername)) {
    $newUsername = $currentUsername;
}

// If the username is different, add to update list
if ($newUsername !== $currentUsername) {
if ($newUsername !== $currentUsername) {
    $updateFields[] = "username = ?";
    $params[] = $newUsername;
    $types .= "s";
}
}
// Password processing
if (!empty($newPassword)) {
    if ($newPassword !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.'); window.history.back();</script>";
        exit();
    }

    if (strlen($newPassword) < 8) {
        echo "<script>alert('New password must be at least 8 characters long.'); window.history.back();</script>";
        exit();
    }

// Password change handling
if (strlen($newPassword) > 0) {
    // Require current password only if changing password
    if (empty($currentPassword)) {
        echo "<script>alert('Please enter your current password to change password.'); window.history.back();</script>";
        exit();
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

// Admin-only field updates
if ($role === 'admin') {
    $newFirstName = trim($_POST['new_first_name'] ?? '');
    $newMiddleName = trim($_POST['new_middle_name'] ?? '');
    $newLastName = trim($_POST['new_last_name'] ?? '');
    $newSuffix = trim($_POST['new_suffix'] ?? '');

    if (isset($_POST['new_first_name'])) {
        $updateFields[] = "first_name = ?";
        $params[] = $newFirstName;
        $types .= "s";
    }
    if (isset($_POST['new_middle_name'])) {
        $updateFields[] = "middle_name = ?";
        $params[] = $newMiddleName;
        $types .= "s";
    }
    if (isset($_POST['new_last_name'])) {
        $updateFields[] = "last_name = ?";
        $params[] = $newLastName;
        $types .= "s";
    }
    if (isset($_POST['new_suffix'])) {
    $updateFields[] = "suffix = ?";
    $params[] = $newSuffix; // could be ''
    $types .= "s";
    }

}

// If any field is to be updated
// If there is something to update
if (count($updateFields) > 0) {
    $params[] = $userId;
    $types .= "i";

    $sql = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
    $stmt = $conn->prepare($sql);

    $bind_names = [];
    $bind_names[] = &$types;
    // Dynamic binding for parameters
    $bind_names = [];
    $bind_names[] = &$types;
    foreach ($params as $key => $value) {
        $bind_names[] = &$params[$key];
    }

    call_user_func_array([$stmt, 'bind_param'], $bind_names);

    if ($stmt->execute()) {
        // Update session username if changed
        if ($newUsername !== $currentUsername) {
            $_SESSION['userName'] = $newUsername;
        }

        // Optionally update admin name fields in session
        if ($role === 'admin') {
            if (!empty($newFirstName)) $_SESSION['first_name'] = $newFirstName;
            if (!empty($newMiddleName)) $_SESSION['middle_name'] = $newMiddleName;
            if (!empty($newLastName)) $_SESSION['last_name'] = $newLastName;
            if (!empty($newSuffix)) $_SESSION['suffix'] = $newSuffix;
        }

        // Force re-login
        session_unset();
        session_destroy();

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
    echo "<script>alert('No changes made.'); window.history.back();</script>";
    exit();
}
        echo "<script>alert('Failed to update account. Please try again later.'); window.history.back();</script>";
        exit();
    }
} else {
    // No updates made
    echo "<script>alert('No changes made.'); window.history.back();</script>";
    exit();
}
?>
