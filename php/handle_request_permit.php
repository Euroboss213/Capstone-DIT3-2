<?php
include "../php/auth_check.php";
include "../database/connect_db_reqwest.php";

$user_id = $_SESSION['id'];
$lastName = $_SESSION['last_name'] ?? '';
$firstName = $_SESSION['first_name'] ?? '';
$middleName = $_SESSION['middle_name'] ?? '';
$suffix = $_SESSION['suffix'] ?? '';

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get user information from session
    $contactNumber = $_POST['contact_number'] ?? '';
    $permitType = $_POST['permit-type'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $supportingDocument = '';
    $documentType = $_POST['document_type'] ?? 'Certificate of Barangay Permit';

    // Check if a file was uploaded
    $supportingDocument = null;
    if (isset($_FILES['supporting_document']) && $_FILES['supporting_document']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../uploads/";
        $fileName = basename($_FILES['supporting_document']['name']);
        $targetFile = $targetDir . uniqid() . "_" . $fileName;

        // Check if directory exists, if not, create it
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES['supporting_document']['tmp_name'], $targetFile)) {
            $supportingDocument = $targetFile;
        } else {
            echo "Error uploading file.";
            exit;
        }
    }

    // Check for ongoing requests
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM permit WHERE user_id = ? AND status = 'Ongoing'");
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkStmt->bind_result($existingCount);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($existingCount > 0) {
        echo "<script>alert('You already have an ongoing request. Please wait for it to be completed before submitting a new one.'); window.location.href='../user/userHome.php';</script>";
        exit();
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare(" INSERT INTO permit (user_id, last_name, first_name, middle_name, suffix, contact_number, permit_type, purpose, supporting_document, document_type) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters and execute
    $stmt->bind_param("isssssssss", $user_id, $lastName, $firstName, $middleName, $suffix, $contactNumber, $permitType, $purpose, $supportingDocument, $documentType);

    if ($stmt->execute()) {
        $request_id = $stmt->insert_id;

        $adminQuery = $conn->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        if($adminRow = $adminQuery->fetch_assoc()) {
            $admin_id = $adminRow['id'];

            $notifMsg = "$firstName $lastName (USER ID NO.({$user_id})) have submitted a request for Certificate of Barangay Permit.";
            $notifStmt = $conn->prepare("INSERT INTO notifications (request_id, document_type, actor_id, actor_role, message, sent_to, is_read) VALUES (?, ?, ?, ?, ?, ?, 0)");
            $role = 'user';
            $notifStmt->bind_param("isissi", $request_id, $documentType, $user_id, $role, $notifMsg, $admin_id);
            $notifStmt->execute();
            $notifStmt->close();
        }

        echo "<script>alert('Request submitted successfully!'); window.location.href='../user/userHome.php';</script>";
    } else {
        echo "Error submitting request: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
