<?php
$conn = new mysqli("localhost", "root", "", "reqwest");
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$fields = ['first_name', 'middle_name', 'last_name', 'suffix', 'username', 'password', 'role'];
$data = [];

foreach ($fields as $field) {
    $data[$field] = isset($_POST[$field]) ? trim($_POST[$field]) : '';
}

// Validate required fields
$requiredFields = ['first_name', 'middle_name', 'last_name', 'username', 'password', 'role'];
foreach ($requiredFields as $field) {
    if (empty($data[$field])) {
        // Redirect back with an error
        header("Location: ../superadmin/adminUserAccounts.php?error=" . urlencode(ucfirst(str_replace('_', ' ', $field)) . " is required."));
        exit;
    }
}

// Hash the password
$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

// Check if username already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $data['username']);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    header("Location: ../superadmin/adminUserAccounts.php?error=" . urlencode("This Username already exists."));
    exit;
}
$stmt->close();

// Insert the new user
$stmt = $conn->prepare("INSERT INTO users (username, password, first_name, middle_name, last_name, suffix, role) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "sssssss",
    $data['username'],
    $data['password'],
    $data['first_name'],
    $data['middle_name'],
    $data['last_name'],
    $data['suffix'],
    $data['role']
);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../superadmin/adminUserAccounts.php?success=" . urlencode("Account successfully created."));
    exit;
} else {
    $stmt->close();
    $conn->close();
    header("Location: ../superadmin/adminUserAccounts.php?error=" . urlencode("Execution error: " . $stmt->error));
    exit;
}
?>
