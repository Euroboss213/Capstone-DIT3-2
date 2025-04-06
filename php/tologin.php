<?php
session_start();
include "../database/connect_db.php";



$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT id, password, first_name, middle_name, last_name, suffix FROM users WHERE username = ?";
$stmt = $conn->prepare($query);

$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $hashed_password, $first_name, $middle_name, $last_name, $suffix);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $middle_initial = $middle_name ? strtoupper(substr($middle_name, 0, 1)) . '.' : '';
        $suffix_part = $suffix ? ', ' . $suffix : '';
        $full_name = "{$first_name} {$middle_initial} {$last_name} {$suffix}";

        $_SESSION['id'] = $id;
        $_SESSION['user_name'] = $full_name;

        header("Location: ../user/userHome.php");
        exit();
    } else {
        header("Location: ../pages/login.php");
    }
} else {
    echo "The username or password must be wrong";
}

$stmt->close();
$conn->close();
?>
