<?php
$conn = new mysqli("localhost", "root", "", "reqwest");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];

$sql = "DELETE FROM indigency WHERE id='$id'";

if ($conn->query($sql) === TRUE) {
  echo "Request deleted successfully.";
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
