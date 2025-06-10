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

// Fields to capture (excluding address parts and age for now)
$fields = [
    'first_name', 'middle_name', 'last_name', 'suffix', 'birth_date', 'birth_place',
    'sex', 'civil_status', 'nationality', 'religion', 'occupation',
    'contact_number', 'pwd', 'pwd_id_no', 'indigent', 'solo_parent',
    'solo_parent_id_no', 'member_4ps', 'family_monthly_income', 'voters_id_no',
    'covid_status', 'vaccinated'
];

// Collect standard fields
$data = [];
foreach ($fields as $field) {
    $data[$field] = isset($_POST[$field]) ? $_POST[$field] : '';
}

// Collect address parts separately
$house_no = isset($_POST['house_no']) ? trim($_POST['house_no']) : '';
$street_name = isset($_POST['street_name']) ? trim($_POST['street_name']) : '';
$municipality = isset($_POST['municipality']) ? trim($_POST['municipality']) : '';
$province = isset($_POST['province']) ? trim($_POST['province']) : '';

// Build combined address string
$address_parts = array_filter([$house_no, $street_name, $municipality, $province]);
$data['address'] = implode(', ', $address_parts);

// Convert income to float
$data['family_monthly_income'] = is_numeric($data['family_monthly_income']) ? (float)$data['family_monthly_income'] : 0.0;

// Set date of registration
$data['date_of_registration'] = date("Y-m-d H:i:s");

// Calculate age
$birthDate = DateTime::createFromFormat('Y-m-d', $data['birth_date']);
if (!$birthDate) {
    respond(false, "Invalid birth date format. Please use YYYY-MM-DD.");
}
$today = new DateTime();
$data['age'] = $today->diff($birthDate)->y;

if ($data['age'] < 18) {
    respond(false, "Resident must be at least 18 years old.");
}

// Connect to MySQL
$mysqli = new mysqli("localhost", "root", "", "reqwest");
if ($mysqli->connect_error) {
    respond(false, "Database connection failed: " . $mysqli->connect_error);
}

// Check for duplicates in multiple unique ID fields
$uniqueIdFields = ['voters_id_no', 'pwd_id_no', 'solo_parent_id_no'];
foreach ($uniqueIdFields as $field) {
    if (!empty($data[$field])) {
        $value = $data[$field];
        $query = "SELECT id FROM residences WHERE $field = ?";
        $checkStmt = $mysqli->prepare($query);
        if ($checkStmt) {
            $checkStmt->bind_param("s", $value);
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


// Prepare SQL statement with individual address parts AND combined address
$stmt = $mysqli->prepare("
    INSERT INTO residences (
        first_name, middle_name, last_name, suffix, birth_date, birth_place, age, sex,
        civil_status, nationality, religion, occupation, contact_number, address,
        house_no, street_name, municipality, province, 
        pwd, pwd_id_no, indigent, solo_parent, solo_parent_id_no, member_4ps,
        family_monthly_income, voters_id_no, covid_status, vaccinated, date_of_registration
    ) VALUES (
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?,
        ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
    )
");

if (!$stmt) {
    respond(false, "Prepare failed: " . $mysqli->error);
}

// Bind parameters
$stmt->bind_param(
    "ssssssisssssssssssssssssdssss",
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
    $data['address'],  // combined address string
    $house_no,
    $street_name,
    $municipality,
    $province,
    $data['pwd'],
    $data['pwd_id_no'],
    $data['indigent'],
    $data['solo_parent'],
    $data['solo_parent_id_no'],
    $data['member_4ps'],
    $data['family_monthly_income'],
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
