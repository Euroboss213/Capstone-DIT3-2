<?php
$conn = new mysqli("localhost", "root", "", "reqwest");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['requestId'];
$status = $_POST['status'];
$comment = $conn->real_escape_string($_POST['comment']); // Prevent SQL injection

$sql = "UPDATE indigency SET status='$status', comment='$comment' WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
  echo "Request updated successfully.";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
