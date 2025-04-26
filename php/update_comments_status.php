<?php
$conn = new mysqli("localhost", "root", "", "reqwest");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    
    // Check if updating
    if (isset($_POST['status']) && isset($_POST['comment'])) {
        $status = $conn->real_escape_string($_POST['status']);
        $comment = $conn->real_escape_string($_POST['comment']);

        $sql = "UPDATE indigency SET status='$status', comment='$comment' WHERE id=$id";

        if ($conn->query($sql) === TRUE) {
            header("Location: ../admin/adminDocReq.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
}

$conn->close();
?>
