<?php
session_start();
include "../database/connect_db_users.php";

// Get the input values
$username = $_POST['username'];
$password = $_POST['password'];

// Update the query to also fetch the role column
$query = "SELECT id, password, first_name, middle_name, last_name, suffix, role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);

$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $hashed_password, $first_name, $middle_name, $last_name, $suffix, $role);
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $hashed_password)) {
        // Build the full name
        $middle_initial = $middle_name ? strtoupper(substr($middle_name, 0, 1)) . '.' : '';
        $suffix_part = $suffix ? ', ' . $suffix : '';
        $full_name = "{$first_name} {$middle_initial} {$last_name} {$suffix_part}";

        // Set session variables
        $_SESSION['id'] = $id;
        $_SESSION['user_name'] = $full_name;
        $_SESSION['role'] = $role;

        // Redirect based on role
        if ($role === 'admin') {
            header("Location: ../admin/adminResidents.php"); // Redirect to admin page
        } else {
            header("Location: ../user/userHome.php"); // Redirect to user page
        }
        exit();
    } else {
        // Redirect to login page if password is incorrect
        header("Location: ../pages/login.php?error=invalid_password");
        exit();
    }
} else {
    // Redirect to login page if user not found
    header("Location: ../pages/login.php?error=invalid_credentials");
    exit();
}

$stmt->close();
$conn->close();
?>
