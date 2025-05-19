    <?php
    include "../php/auth_check.php";
    include "../database/connect_db_reqwest.php";
    include "../php/handle-notification.php";

    // Get user data from session
    $user_id = $_SESSION['id'];
    $lastName = $_SESSION['last_name'] ?? '';
    $firstName = $_SESSION['first_name'] ?? '';
    $middleName = $_SESSION['middle_name'] ?? '';
    $suffix = $_SESSION['suffix'] ?? '';

    // Only process POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $purpose = $_POST['purpose'] ?? '';
        $documentType = $_POST['document_type'] ?? '';
        $supportingDocument = '';
        $status = 'Ongoing';

        // Handle file upload
        if (isset($_FILES['supporting_document']) && $_FILES['supporting_document']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
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

        // Insert request
        $stmt = $conn->prepare("INSERT INTO indigency (user_id, last_name, first_name, middle_name, suffix, purpose, document_type, supporting_document, status, date_requested) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("issssssss", $user_id, $lastName, $firstName, $middleName, $suffix, $purpose, $documentType, $supportingDocument, $status);

        if ($stmt->execute()) {
            $request_id = $stmt->insert_id;

            // 🔔 INSERT NOTIFICATION TO ADMIN USING FUNCTION
            $adminQuery = $conn->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
        if($adminRow = $adminQuery->fetch_assoc()) {
            $admin_id = $adminRow['id'];

            $notifMsg = "$firstName $lastName (USER ID NO.({$user_id})) have submitted a request for Certificate of Indigency.";
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
        $conn->close();
    } else {
        header("Location: ../user/userRequest_indigency.php");
        exit();
    }
    ?>
    `