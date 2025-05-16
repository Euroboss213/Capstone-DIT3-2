<?php
session_start();
include "../database/connect_db_reqwest.php";

// Ensure user is authenticated
if (!isset($_SESSION['id'])) {
    header("Location: ../login.php");
    exit();
}

// Get user data from session
$user_id = $_SESSION['id'];
$lastName = $_SESSION['last_name'] ?? '';
$firstName = $_SESSION['first_name'] ?? '';
$middleName = $_SESSION['middle_name'] ?? '';
$suffix = $_SESSION['suffix'] ?? '';

// Only handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactNumber = $_POST['contact_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $documentType = $_POST['document_type'] ?? '';
    $status = 'Ongoing';
    $comment = null;
    $supportingDocument = '';

    // Handle file upload
    if (isset($_FILES['supporting_document']) && $_FILES['supporting_document']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . '_' . basename($_FILES['supporting_document']['name']);
        $targetPath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['supporting_document']['tmp_name'], $targetPath)) {
            $supportingDocument = 'uploads/' . $fileName;
        }
    }

    // Insert request
    $stmt = $conn->prepare("INSERT INTO certresidency (
        user_id, last_name, first_name, middle_name, suffix,
        contact_number, address, purpose, supporting_document,
        status, comment, document_type
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssssss",
        $user_id, $lastName, $firstName, $middleName, $suffix,
        $contactNumber, $address, $purpose, $supportingDocument,
        $status, $comment, $documentType
    );

    if ($stmt->execute()) {
        echo "<script>alert('Request submitted successfully!'); window.location.href='../user/userHome.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
