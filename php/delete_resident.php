<?php
$response = ['success' => false];

if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $conn = new mysqli("localhost", "root", "", "reqwest");

  if ($conn->connect_error) {
    $response['error'] = 'Database connection failed.';
  } else {
    $stmt = $conn->prepare("DELETE FROM residences WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
      $response['success'] = true;
    } else {
      $response['error'] = 'Failed to delete resident.';
    }

    $stmt->close();
    $conn->close();
  }
}

header('Content-Type: application/json');
echo json_encode($response);
?>
