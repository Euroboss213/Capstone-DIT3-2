<?php
$servername = "localhost";
$username = "root";
$password = ""; // Change this if needed
$dbname = "reqwest"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection error
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
