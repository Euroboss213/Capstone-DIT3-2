<?php
session_start();
include "../database/connect_db_reqwest.php";

$first_name = $_POST['first-name'];
$middle_name = $_POST['middle-name'];
$last_name = $_POST['last-name'];
$suffix = $_POST['suffix'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];
$id_type = $_POST['id_type'];
$selected_id = $_POST['selected_id'];

if ($password !== $confirm_password) {
    header("Location: ../pages/newlogin.php?signup_error=password_mismatch");
    exit();
}

$query = "SELECT * FROM residences WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    header("Location: ../pages/newlogin.php?signup_error=db_prepare_residence");
    exit();
}
$stmt->bind_param('ssss', $first_name, $middle_name, $last_name, $suffix);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $residence_data = $result->fetch_assoc();

    $id_columns = ['national_id_no', 'philhealth_no', 'sss_no', 'tin_no', 'voters_id_no'];
    $id_match_found = false;

    foreach ($id_columns as $id_column) {
        if ($residence_data[$id_column] === $selected_id) {
            $id_match_found = true;
            break;
        }
    }

    if (!$id_match_found) {
        header("Location: ../pages/newlogin.php?signup_error=id_not_found");
        exit();
    }

    $check_user_query = "SELECT * FROM users WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ?";
    $check_user_stmt = $conn->prepare($check_user_query);
    if ($check_user_stmt === false) {
        header("Location: ../pages/newlogin.php?signup_error=db_prepare_user_check");
        exit();
    }
    $check_user_stmt->bind_param('ssss', $first_name, $middle_name, $last_name, $suffix);
    $check_user_stmt->execute();
    $check_user_result = $check_user_stmt->get_result();

    if ($check_user_result->num_rows > 0) {
        header("Location: ../pages/newlogin.php?signup_error=duplicate_user");
        exit();
    } else {
        $password_requirements = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

        if (!preg_match($password_requirements, $password)) {
            header("Location: ../pages/newlogin.php?signup_error=weak_password");
            exit();
        }
        

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $residence_id = $residence_data['id'];

        $insert_query = "INSERT INTO users (username, password, first_name, middle_name, last_name, suffix, residence_id, id_options, id_selected)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        if ($insert_stmt === false) {
            header("Location: ../pages/newlogin.php?signup_error=db_prepare_insert");
            exit();
        }

        $insert_stmt->bind_param(
            'ssssssiss',
            $username, $hashed_password, $first_name, $middle_name, $last_name, $suffix, $residence_id, $id_type, $selected_id
        );

        if ($insert_stmt->execute()) {
            header("Location: ../pages/newlogin.php?signup_success=1");
            exit();
        } else {
            header("Location: ../pages/newlogin.php?signup_error=insert_failed");
            exit();
        }
    }
} else {
    header("Location: ../pages/newlogin.php?signup_error=no_residence");
    exit();
}
?>
