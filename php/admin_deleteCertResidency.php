<?php
$conn = new mysqli("localhost", "root", "", "reqwest");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM certresidency WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Certificate request deleted successfully.";
} else {
    echo "Error deleting request: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
