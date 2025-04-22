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
$id_type = $_POST['id_type'];  // Not needed anymore for comparison but still can be stored
$selected_id = $_POST['selected_id'];

// Password match check
if ($password !== $confirm_password) {
    echo "Passwords do not match!";
    exit();
}

// Fetch the entire row from the 'residences' table
$query = "SELECT * FROM residences WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error preparing SELECT query: " . $conn->error);
}
$stmt->bind_param('ssss', $first_name, $middle_name, $last_name, $suffix);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $residence_data = $result->fetch_assoc();
    
    // Check if the selected_id matches any of the ID columns in the residences table
    $id_columns = ['national_id_no', 'philhealth_no', 'sss_no', 'tin_no', 'voters_id_no'];
    $id_match_found = false;

    foreach ($id_columns as $id_column) {
        if ($residence_data[$id_column] === $selected_id) {
            $id_match_found = true;
            break;
        }
    }

    if (!$id_match_found) {
        echo "No matching ID found in residences!";
        exit();
    }

    // Check if user already exists in 'users'
    $check_user_query = "SELECT * FROM users WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ?";
    $check_user_stmt = $conn->prepare($check_user_query);
    if ($check_user_stmt === false) {
        die("Error preparing check user query: " . $conn->error);
    }
    $check_user_stmt->bind_param('ssss', $first_name, $middle_name, $last_name, $suffix);
    $check_user_stmt->execute();
    $check_user_result = $check_user_stmt->get_result();

    if ($check_user_result->num_rows > 0) {
        echo "A user with this name already has an account!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $residence_id = $residence_data['id'];

        // Insert the new user into the 'users' table
        $insert_query = "INSERT INTO users (username, password, first_name, middle_name, last_name, suffix, residence_id, id_options, id_selected)
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        if ($insert_stmt === false) {
            die("Error preparing INSERT query: " . $conn->error);
        }

        $insert_stmt->bind_param(
            'ssssssiss',
            $username, $hashed_password, $first_name, $middle_name, $last_name, $suffix, $residence_id, $id_type, $selected_id
        );

        if ($insert_stmt->execute()) {
            header("Location: ../pages/newlogin.php");
            exit();
        } else {
            echo "Error: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    }

    $check_user_stmt->close();
} else {
    echo "No matching residence data with that ID found!";
}

$stmt->close();
$conn->close();
?>
