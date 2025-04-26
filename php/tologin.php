<?php
session_start();
include "../database/connect_db_reqwest.php";

// Sanitize input (optional but recommended)
$username = htmlspecialchars($_POST['username']);
$password = $_POST['password'];

// Prepare the query to fetch the user record, including the role
$query = "SELECT id, password, first_name, middle_name, last_name, suffix, role FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    // Fetch the results
    $stmt->bind_result($id, $hashed_password, $first_name, $middle_name, $last_name, $suffix, $role);
    $stmt->fetch();

    // Verify the password
    if (password_verify($password, $hashed_password)) {
        // Regenerate session ID to prevent session fixation
        session_regenerate_id();

        // Build the full name
        $middle_initial = $middle_name ? strtoupper(substr($middle_name, 0, 1)) . '.' : '';
        $suffix_part = $suffix ? ', ' . $suffix : '';
        $full_name = "{$first_name} {$middle_initial} {$last_name} {$suffix_part}";

        // Set session variables
        $_SESSION['id'] = $id;
        $_SESSION['user_name'] = $full_name;
        $_SESSION['role'] = $role;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['middle_name'] = $middle_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['suffix'] = $suffix;

        // Redirect based on the role
        if ($role === 'admin') {
            header("Location: ../admin/adminResidents.php"); // Redirect to admin page
        } else {
            header("Location: ../user/userHome.php"); // Redirect to user page
        }
        exit();
    } else {
        // Redirect to login page if the password is incorrect
        header("Location: ../pages/login.php?error=invalid_password");
        exit();
    }
} else {
    // Redirect to login page if the user is not found
    header("Location: ../pages/login.php?error=invalid_credentials");
    exit();
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
