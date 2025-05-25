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

    $checkStmt=$conn->prepare('SELECT COUNT(*) from certresidency WHERE user_id = ? AND status = "ongoing"');
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkStmt->bind_result($existingCount);
    $checkStmt->fetch();
    $checkStmt->close();

    if($existingCount > 0) {
        echo "<script>alert('You already have an ongoing request. Please wait for it to be completed before submitting a new one.'); window.location.href='../user/userHome.php';</script>";
        exit();
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
        $request_id = $stmt->insert_id;

        //inserting a notif to the admin
        $adminQuery = $conn->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        if($adminRow = $adminQuery->fetch_assoc()) {
            $admin_id = $adminRow['id'];

            $notifMsg = "$firstName $lastName (USER ID NO.({$user_id})) have submitted a request for Certificate of Residency.";
            $notifStmt = $conn->prepare("INSERT INTO notifications (request_id, document_type, actor_id, actor_role, message, sent_to, is_read) VALUES (?, ?, ?, ?, ?, ?, 0)");
            $role = 'user';
            $notifStmt->bind_param("isissi", $request_id, $documentType, $user_id, $role, $notifMsg, $admin_id);
            $notifStmt->execute();
            $notifStmt->close();
        }

           $_SESSION['show_success_modal'] = true;
                header("Location: ../user/userHome.php");
                 exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../user/userRequest_certResidency.php");
    exit();
}
?>
