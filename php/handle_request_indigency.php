<?php
include "../php/auth_check.php"; 
include "../database/connect_db_reqwest.php";

// Get user data from session
$user_id = $_SESSION['id']; // Make sure this exists in your session
$lastName = $_SESSION['last_name'] ?? '';
$firstName = $_SESSION['first_name'] ?? '';
$middleName = $_SESSION['middle_name'] ?? '';
$suffix = $_SESSION['suffix'] ?? '';

// Only process POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $purpose = $_POST['purpose'] ?? '';
    $supportingDocument = '';
    $status = 'Ongoing'; // default

    // Handle file upload
    if (isset($_FILES['supporting_document']) && $_FILES['supporting_document']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory if not exists
        }

        $fileName = basename($_FILES['supporting_document']['name']);
        $targetFile = $uploadDir . time() . '_' . $fileName;

        if (move_uploaded_file($_FILES['supporting_document']['tmp_name'], $targetFile)) {
            $supportingDocument = $targetFile;
        }
    }

    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM indigency WHERE user_id = ? AND status = 'ongoing'");
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkStmt->bind_result($existingCount);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($existingCount > 0) {
        echo "<script>alert('You already have an ongoing request. Please wait for it to be completed before submitting a new one.'); window.location.href='../user/userHome.php';</script>";
        exit();
    }

    // Prepare and insert into indigency
    $stmt = $conn->prepare("INSERT INTO indigency (user_id, last_name, first_name, middle_name, suffix, purpose, supporting_document, status, date_requested) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("isssssss", $user_id, $lastName, $firstName, $middleName, $suffix, $purpose, $supportingDocument, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Request submitted successfully!'); window.location.href='../user/userHome.php';</script>";
    } else {
        echo "Error submitting request: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // If accessed without POST (security)
    header("Location: ../user/request_indigency.php");
    exit();
}
?>
