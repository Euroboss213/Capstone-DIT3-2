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
    'sex', 'civil_status', 'nationality', 'religion', 'occupation',
    'contact_number', 'address', 'pwd', 'pwd_id_no', 'indigent', 'solo_parent',
    'solo_parent_id_no', 'member_4ps', 'family_monthly_income', 'national_id_no',
    'philhealth_no', 'sss_no', 'pagibig_no', 'tin_no', 'voters_id_no',
    'covid_status', 'vaccinated'
];

$data = [];
foreach ($fields as $field) {
    $data[$field] = isset($_POST[$field]) ? $_POST[$field] : '';
}

$data['family_monthly_income'] = is_numeric($data['family_monthly_income']) ? (float)$data['family_monthly_income'] : 0.0;
$data['date_of_registration'] = date("Y-m-d H:i:s");

// Connect to MySQL using MySQLi
$mysqli = new mysqli("localhost", "root", "", "admin");
if ($mysqli->connect_error) {
    respond(false, "Database connection failed: " . $mysqli->connect_error);
}

// List of ID fields that must be unique
$uniqueIdFields = [
    'national_id_no', 'philhealth_no', 'sss_no',
    'pagibig_no', 'tin_no', 'voters_id_no'
];

// Check for duplicate ID fields
foreach ($uniqueIdFields as $field) {
    if (!empty($data[$field])) {
        $query = "SELECT id FROM residences WHERE $field = ?";
        $checkStmt = $mysqli->prepare($query);
        if ($checkStmt) {
            $checkStmt->bind_param("s", $data[$field]);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $fieldNameFormatted = ucwords(str_replace("_", " ", $field));
                respond(false, "This $fieldNameFormatted is already existing from another Resident.");
            }

            $checkStmt->close();
        } else {
            respond(false, "Error checking for duplicate $field: " . $mysqli->error);
        }
    }
}

// Prepare SQL statement
$stmt = $mysqli->prepare("
    INSERT INTO residences (
        first_name, middle_name, last_name, suffix, birth_date, birth_place, sex,
        civil_status, nationality, religion, occupation, contact_number, address,
        pwd, pwd_id_no, indigent, solo_parent, solo_parent_id_no, member_4ps,
        family_monthly_income, national_id_no, philhealth_no, sss_no, pagibig_no,
        tin_no, voters_id_no, covid_status, vaccinated, date_of_registration
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )
");

if (!$stmt) {
    respond(false, "Prepare failed: " . $mysqli->error);
}

// Bind parameters
$stmt->bind_param(
    "sssssssssssssssssssdsssssssss",
    $data['first_name'],
    $data['middle_name'],
    $data['last_name'],
    $data['suffix'],
    $data['birth_date'],
    $data['birth_place'],
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
