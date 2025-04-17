<?php
header('Content-Type: application/json');

// Enable error reporting (for development only — disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Helper function for consistent JSON response and exit
function respond($success, $message) {
    echo json_encode(["success" => $success, "message" => $message]);
    exit;
}

// Capture and sanitize input
$fields = [
    'first_name', 'middle_name', 'last_name', 'suffix', 'birth_date', 'birth_place',
    'age', 'sex', 'civil_status', 'nationality', 'religion', 'occupation',
    'contact_number', 'address', 'pwd', 'pwd_id_no', 'indigent', 'solo_parent',
    'solo_parent_id_no', 'member_4ps', 'family_monthly_income', 'national_id_no',
    'philhealth_no', 'sss_no', 'pagibig_no', 'tin_no', 'voters_id_no',
    'covid_status', 'vaccinated'
];

$data = [];
foreach ($fields as $field) {
    // Use ternary operator for undefined POST data
    $data[$field] = isset($_POST[$field]) ? $_POST[$field] : '';
}

$data['age'] = is_numeric($data['age']) ? (int)$data['age'] : 0;
$data['family_monthly_income'] = is_numeric($data['family_monthly_income']) ? (float)$data['family_monthly_income'] : 0.0;
$data['date_of_registration'] = date("Y-m-d H:i:s");

// Debug: log raw POST data to a file (for troubleshooting)
file_put_contents('debug_post.txt', json_encode($_POST, JSON_PRETTY_PRINT) . PHP_EOL, FILE_APPEND);

// Connect to MySQL using MySQLi
$mysqli = new mysqli("localhost", "username", "password", "admin");
if ($mysqli->connect_error) {
    respond(false, "Database connection failed: " . $mysqli->connect_error);
}

// Prepare SQL statement
$stmt = $mysqli->prepare("
    INSERT INTO residents (
        first_name, middle_name, last_name, suffix, birth_date, birth_place, age, sex,
        civil_status, nationality, religion, occupation, contact_number, address,
        pwd, pwd_id_no, indigent, solo_parent, solo_parent_id_no, member_4ps,
        family_monthly_income, national_id_no, philhealth_no, sss_no, pagibig_no,
        tin_no, voters_id_no, covid_status, vaccinated, date_of_registration
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )
");

if (!$stmt) {
    respond(false, "Prepare failed: " . $mysqli->error);
}

// Bind parameters (30 fields, types matched accordingly)
$stmt->bind_param(
    "sssssssissssssssssssdsssssssssss",
    $data['first_name'],
    $data['middle_name'],
    $data['last_name'],
    $data['suffix'],
    $data['birth_date'],
    $data['birth_place'],
    $data['age'],
    $data['sex'],
    $data['civil_status'],
    $data['nationality'],
    $data['religion'],
    $data['occupation'],
    $data['contact_number'],
    $data['address'],
    $data['pwd'],
    $data['pwd_id_no'],
    $data['indigent'],
    $data['solo_parent'],
    $data['solo_parent_id_no'],
    $data['member_4ps'],
    $data['family_monthly_income'],
    $data['national_id_no'],
    $data['philhealth_no'],
    $data['sss_no'],
    $data['pagibig_no'],
    $data['tin_no'],
    $data['voters_id_no'],
    $data['covid_status'],
    $data['vaccinated'],
    $data['date_of_registration']
);

// Execute and respond
if ($stmt->execute()) {
    respond(true, "Resident added successfully.");
} else {
    respond(false, "Execution error: " . $stmt->error);
}

$stmt->close();
$mysqli->close();
?>
