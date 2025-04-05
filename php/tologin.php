<?php
include "../database/connect_db.php";

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT id, password FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['id'] = $id;
        echo "Login successfully!";
    } else {
        echo "invalid password";
    }
} else {
    echo "The username or password must be wrong";
}

$stmt->close();
$conn->close();

?>