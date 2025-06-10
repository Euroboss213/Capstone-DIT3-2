<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "reqwest");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$id = $_POST['id'] ?? '';

if (empty($id)) {
    echo json_encode(["success" => false, "message" => "Missing resident ID."]);
    exit;
}

// Combine address parts from form
$house_no = $_POST['house_no'] ?? '';
$street_name = $_POST['street_name'] ?? '';
$municipality = $_POST['municipality'] ?? '';
$province = $_POST['province'] ?? '';

// Compose full address string WITHOUT barangay (since not in form)
$full_address = trim("$house_no $street_name, $municipality, $province");

// Fields to update in the database (including individual address columns)
$fields = [
    'first_name', 'middle_name', 'last_name', 'suffix', 'birth_date', 'birth_place',
    'sex', 'civil_status', 'nationality', 'religion', 'occupation', 'contact_number',
    'address', // combined address
    'house_no', 'street_name', 'municipality', 'province', // individual address parts
    'pwd', 'pwd_id_no', 'indigent', 'solo_parent', 'solo_parent_id_no', 'member_4ps',
    'family_monthly_income', 'voters_id_no',
    'covid_status', 'vaccinated', 'date_of_registration'
];

$uniqueIdFields = ['voters_id_no', 'pwd_id_no', 'solo_parent_id_no'];

foreach ($uniqueIdFields as $field) {
    if (!empty($_POST[$field])) {
        $value = $_POST[$field];
        $checkSql = "SELECT id FROM residences WHERE $field = ? AND id != ?";
        $checkStmt = $conn->prepare($checkSql);
        if ($checkStmt) {
            $checkStmt->bind_param("si", $value, $id);
            $checkStmt->execute();
            $checkStmt->store_result();
            if ($checkStmt->num_rows > 0) {
                $checkStmt->close();
                echo json_encode([
                    "success" => false,
                    "message" => "This " . ucwords(str_replace("_", " ", $field)) . " is already used by another resident."
                ]);
                exit;
            }
            $checkStmt->close();
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Error checking for duplicate $field: " . $conn->error
            ]);
            exit;
        }
    }
}

$placeholders = [];
$values = [];

foreach ($fields as $field) {
    $placeholders[] = "`$field` = ?";
    
    if ($field === 'address') {
        $values[] = $full_address; // Use combined address string
    } elseif (in_array($field, ['house_no', 'street_name', 'municipality', 'province'])) {
        // Use individual address parts variables
        $values[] = $$field ?? null;
    } else {
        $values[] = $_POST[$field] ?? null;
    }
}

// Append ID for WHERE clause
$values[] = $id;

// Build the SQL query string
$sql = "UPDATE residences SET " . implode(", ", $placeholders) . " WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "SQL prepare error: " . $conn->error]);
    exit;
}

// Bind parameters — assuming all string types here (adjust if you know the exact types)
$types = str_repeat('s', count($values));

if (!$stmt->bind_param($types, ...$values)) {
    echo json_encode(["success" => false, "message" => "Parameter binding failed: " . $stmt->error]);
    exit;
}

// Execute the statement
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Execution error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
