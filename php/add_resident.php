<?php
include '../database/connect_db_admin.php';

header('Content-Type: application/json');

// Collect all form inputs
$first_name = $_POST['first_name'] ?? '';
$middle_name = $_POST['middle_name'] ?? null;
$last_name = $_POST['last_name'] ?? '';
$suffix = $_POST['suffix'] ?? null;
$birth_date = $_POST['birth_date'] ?? null;
$birth_place = $_POST['birth_place'] ?? null;
$age = $_POST['age'] ?? null;
$sex = $_POST['sex'] ?? null;
$civil_status = $_POST['civil_status'] ?? null;
$nationality = $_POST['nationality'] ?? null;
$religion = $_POST['religion'] ?? null;
$occupation = $_POST['occupation'] ?? null;
$contact_number = $_POST['contact_number'] ?? null;
$address = $_POST['address'] ?? null;
$pwd = $_POST['pwd'] ?? null;
$pwd_id_no = $_POST['pwd_id_no'] ?? null;
$indigent = $_POST['indigent'] ?? null;
$solo_parent = $_POST['solo_parent'] ?? null;
$solo_parent_id_no = $_POST['solo_parent_id_no'] ?? null;
$member_4ps = $_POST['member_4ps'] ?? null;
$family_monthly_income = $_POST['family_monthly_income'] ?? null;
$registered_voter = $_POST['registered_voter'] ?? null;
$national_id_no = $_POST['national_id_no'] ?? null;
$philhealth_no = $_POST['philhealth_no'] ?? null;
$sss_no = $_POST['sss_no'] ?? null;
$pagibig_no = $_POST['pagibig_no'] ?? null;
$tin_no = $_POST['tin_no'] ?? null;
$voters_id_no = $_POST['voters_id_no'] ?? null;
$covid_status = $_POST['covid_status'] ?? null;
$vaccinated = $_POST['vaccinated'] ?? null;
$date_of_registration = date("Y-m-d H:i:s"); // now

$sql = "INSERT INTO residences (
  first_name, middle_name, last_name, suffix, birth_date, birth_place, age, sex, civil_status,
  nationality, religion, occupation, contact_number, address, pwd, pwd_id_no, indigent, solo_parent, 
  solo_parent_id_no, member_4ps, family_monthly_income, registered_voter, national_id_no, 
  philhealth_no, sss_no, pagibig_no, tin_no, voters_id_no, covid_status, vaccinated, date_of_registration
) VALUES (
  ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
  echo json_encode(["success" => false, "error" => $conn->error]);
  exit;
}

$stmt->bind_param(
    "ssssssisssssssssssssds" . str_repeat("s", 9),
    $first_name, $middle_name, $last_name, $suffix, $birth_date, $birth_place,
    $age, $sex, $civil_status, $nationality, $religion, $occupation, $contact_number,
    $address, $pwd, $pwd_id_no, $indigent, $solo_parent, $solo_parent_id_no, $member_4ps,
    $family_monthly_income, $registered_voter, $national_id_no, $philhealth_no,
    $sss_no, $pagibig_no, $tin_no, $voters_id_no, $covid_status, $vaccinated, $date_of_registration
  );

if ($stmt->execute()) {
  echo json_encode(["success" => true]);
} else {
  echo json_encode(["success" => false, "error" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
