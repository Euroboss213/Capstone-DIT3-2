<?php
session_start();

// Connect to the "reqwest" database
include "../database/connect_db_reqwest.php";

// Getting user input from the signup form
$first_name = $_POST['first-name'];
$middle_name = $_POST['middle-name'];
$last_name = $_POST['last-name'];
$suffix = $_POST['suffix'];
$username = $_POST['username'];
$password = $_POST['password']; // Plain password will be hashed

// Check if the user exists in the 'residences' table
$query = "SELECT * FROM residences WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error preparing SELECT query: " . $conn->error);
}
$stmt->bind_param('ssss', $first_name, $middle_name, $last_name, $suffix);
$stmt->execute();
$result = $stmt->get_result();

// Proceed if residence data exists
if ($result->num_rows > 0) {
    $residence_data = $result->fetch_assoc();

    // Check if user already exists in the 'users' table
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
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the user into the 'users' table
        $insert_query = "INSERT INTO users (username, password, first_name, middle_name, last_name, suffix, residence_id)
                         VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_query);
        if ($insert_stmt === false) {
            die("Error preparing INSERT query: " . $conn->error);
        }

        // Bind residence ID from matched residence data
        $residence_id = $residence_data['id']; // assuming the primary key is 'id'
        $insert_stmt->bind_param(
            'ssssssi',
            $username, $hashed_password, $first_name, $middle_name, $last_name, $suffix, $residence_id
        );

        if ($insert_stmt->execute()) {
            echo "User registered successfully!";
            header("Location: ../pages/login.php");
            exit();
        } else {
            echo "Error: " . $insert_stmt->error;
        }

        $insert_stmt->close();
    }

    $check_user_stmt->close();
} else {
    echo "No matching residence data found!";
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
