<?php
$servername = "localhost";
$username = "root";
$password = ""; // Change this if needed
$dbname = "users"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
