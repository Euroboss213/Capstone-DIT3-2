<?php
session_start();

// Database connection for both 'admin' and 'users' databases
$admin_db = new mysqli("localhost", "root", "", "admin");
$users_db = new mysqli("localhost", "root", "", "users");

// Check if the connections are successful
if ($admin_db->connect_error) {
    die("Connection failed to admin database: " . $admin_db->connect_error);
}
if ($users_db->connect_error) {
    die("Connection failed to users database: " . $users_db->connect_error);
}

// Getting user input from the signup form
$first_name = $_POST['first-name'];
$middle_name = $_POST['middle-name'];
$last_name = $_POST['last-name'];
$suffix = $_POST['suffix'];
$username = $_POST['username'];
$password = $_POST['password']; // Plain password will be hashed

// Query to check if the data matches a record in the 'residences' table in the 'admin' database
$query = "SELECT * FROM residences WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ?";
$stmt = $admin_db->prepare($query);
if ($stmt === false) {
    die("Error preparing SELECT query: " . $admin_db->error);
}

$stmt->bind_param('ssss', $first_name, $middle_name, $last_name, $suffix);
$stmt->execute();
$result = $stmt->get_result();

// Proceed if the residence data is found
if ($result->num_rows > 0) {
    $residence_data = $result->fetch_assoc(); // Fetch the matched residence data

    // Check if a user with the same name already exists in the 'users' database
    $check_user_query = "SELECT * FROM users WHERE first_name = ? AND middle_name = ? AND last_name = ? AND suffix = ?";
    $check_user_stmt = $users_db->prepare($check_user_query);
    if ($check_user_stmt === false) {
        die("Error preparing check user query: " . $users_db->error);
    }

    $check_user_stmt->bind_param('ssss', $first_name, $middle_name, $last_name, $suffix);
    $check_user_stmt->execute();
    $check_user_result = $check_user_stmt->get_result();

    if ($check_user_result->num_rows > 0) {
        echo "A user with this name already has an account!";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the INSERT query for the 'users' table
        $insert_query = "INSERT INTO users (
                            username, password, first_name, middle_name, last_name, suffix
                        ) VALUES (?, ?, ?, ?, ?, ?)";

        // Check if the insert query was prepared successfully
        $insert_stmt = $users_db->prepare($insert_query);
        if ($insert_stmt === false) {
            die("Error preparing INSERT query: " . $users_db->error);
        }

        // Bind all necessary parameters for the 'users' table insertion
        $insert_stmt->bind_param(
            'ssssss',
            $username, $hashed_password, $first_name, $middle_name, $last_name, $suffix
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

    // Close the check_user statement
    $check_user_stmt->close();

} else {
    // If no matching data is found in the 'residences' table
    echo "No matching residence data found!";
}

// Close the prepared statements and database connections
$stmt->close();
$admin_db->close();
$users_db->close();
?>
