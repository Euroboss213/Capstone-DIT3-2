<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Ensure the user is logged in
if (!isset($_SESSION['id'])) {
    echo "Session user_id is not set. Please check your login process.";
    exit; // Stop further execution if no user_id in session
}

$user_id = $_SESSION['id'];
$request_id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$purpose = isset($_POST['purpose']) ? $_POST['purpose'] : '';
$comment = isset($_POST['comment']) ? $_POST['comment'] : '';

// Create connection to the database
$conn = new mysqli("localhost", "root", "", "reqwest");

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize file path variable
$supporting_document_path = '';

// Check if a file is uploaded
if (isset($_FILES['supporting_document']) && $_FILES['supporting_document']['error'] == 0) {
    $targetDir = "../uploads/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true); // create directory if not exist
    }

    $fileName = time() . "_" . basename($_FILES['supporting_document']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['supporting_document']['tmp_name'], $targetFilePath)) {
        $supporting_document_path = "uploads/" . $fileName;
    } else {
        die("Error uploading file.");
    }
}

// Build SQL update query
$sql = "UPDATE indigency SET purpose=?, comment=?";

if (!empty($supporting_document_path)) {
    $sql .= ", supporting_document=?";
}

// Only update the record for the current user and matching request ID
$sql .= " WHERE user_id = ? AND id = ?";

// Prepare statement
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Error preparing the statement: " . $conn->error);
}

// Bind parameters
if (!empty($supporting_document_path)) {
    $stmt->bind_param("ssssi", $purpose, $comment, $supporting_document_path, $user_id, $request_id);
} else {
    $stmt->bind_param("ssii", $purpose, $comment, $user_id, $request_id);
}

// Execute the query
if ($stmt->execute()) {
    // Redirect to view page after successful update
    header("Location: ../user/view_requests.php?update_success=true");
    exit();
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
