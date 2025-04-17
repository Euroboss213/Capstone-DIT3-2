<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "admin");

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed."]);
    exit;
}

$id = $_POST['id'] ?? '';

if (empty($id)) {
    echo json_encode(["success" => false, "message" => "Missing resident ID."]);
    exit;
}

$fields = [
    'first_name', 'middle_name', 'last_name', 'suffix', 'birth_date', 'birth_place', 'age',
    'sex', 'civil_status', 'nationality', 'religion', 'occupation', 'contact_number', 'address',
    'pwd', 'pwd_id_no', 'indigent', 'solo_parent', 'solo_parent_id_no', 'member_4ps',
    'family_monthly_income', 'national_id_no', 'philhealth_no', 'sss_no', 'pagibig_no', 'tin_no', 'voters_id_no',
    'covid_status', 'vaccinated', 'date_of_registration'];

$placeholders = [];
$values = [];

foreach ($fields as $field) {
    $placeholders[] = "`$field` = ?";
    $values[] = $_POST[$field] ?? null;
}

$values[] = $id; // for WHERE clause

$sql = "UPDATE residences SET " . implode(", ", $placeholders) . " WHERE id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(["success" => false, "message" => "SQL prepare error: " . $conn->error]);
    exit;
}

// Dynamically bind parameters
$types = str_repeat('s', count($values)); // assuming all string-type fields
$stmt->bind_param($types, ...$values);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Execution error: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
