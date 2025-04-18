<?php
session_start();
require_once '../database/connect_db_admin.php';

$message = "";

if (isset($_POST['import_csv'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $file = fopen($_FILES['csv_file']['tmp_name'], 'r');
        $header = fgetcsv($file);

        $expectedHeaders = [
            'First Name','Middle Name','Last Name','Suffix','Birth Date','Birth Place','Age','Sex','Civil Status',
            'Nationality','Religion','Occupation','Contact Number','Address','PWD','PWD ID No','Indigent',
            'Solo Parent','Solo Parent ID No','Member 4Ps','Family Monthly Income','National ID No','PhilHealth No',
            'SSS No','Pag-IBIG No','TIN No','Voter\'s ID No','Covid Status','Vaccinated'
        ];

        if ($header !== $expectedHeaders) {
            $message = "<p style='color:red;'>The CSV file headers do not match the required format. Please use the correct template.</p>";
        } else {
            $insertCount = 0;
            $errorRows = [];

            while (($data = fgetcsv($file)) !== false) {
                if (count($data) < count($expectedHeaders)) {
                    $errorRows[] = implode(", ", $data) . " - Incomplete data row.";
                    continue;
                }

                list($first_name, $middle_name, $last_name, $suffix, $birth_date, $birth_place, $age, $sex, $civil_status,
                    $nationality, $religion, $occupation, $contact_number, $address, $pwd, $pwd_id_no, $indigent,
                    $solo_parent, $solo_parent_id_no, $member_4ps, $family_monthly_income, $national_id_no, $philhealth_no,
                    $sss_no, $pagibig_no, $tin_no, $voters_id_no, $covid_status, $vaccinated) = $data;

                // Skip if required fields are missing
                if (empty($first_name) || empty($last_name) || empty($birth_date) || empty($sex) || empty($civil_status)) {
                    $errorRows[] = implode(", ", $data) . " - Missing required fields.";
                    continue;
                }

                $idPatterns = [
                    'PWD ID No' => '/^PWD-\d{4}-\d{4}$/',
                    'Solo Parent ID No' => '/^SP-\d{4}-\d{4}$/',
                    'National ID No' => '/^\d{4} \d{4} \d{4}$/',
                    'PhilHealth No' => '/^\d{2}-\d{4}-\d{4}$/',
                    'SSS No' => '/^\d{2}-\d{7}-\d{1}$/',
                    'Pag-IBIG No' => '/^\d{4}-\d{4}-\d{4}$/',
                    'TIN No' => '/^\d{3}-\d{3}-\d{3}$/',
                    'Voter\'s ID No' => '/^VIN-\d{4}-\d{4}$/'
                ];

                $idValues = [
                    'PWD ID No' => $pwd_id_no,
                    'Solo Parent ID No' => $solo_parent_id_no,
                    'National ID No' => $national_id_no,
                    'PhilHealth No' => $philhealth_no,
                    'SSS No' => $sss_no,
                    'Pag-IBIG No' => $pagibig_no,
                    'TIN No' => $tin_no,
                    'Voter\'s ID No' => $voters_id_no
                ];

                $invalidId = false;
                foreach ($idValues as $label => $value) {
                    if (!empty($value) && !preg_match($idPatterns[$label], $value)) {
                        $errorRows[] = implode(", ", $data) . " - Invalid format for $label.";
                        $invalidId = true;
                        break;
                    }
                }

                if ($invalidId) continue;

                // Check for existing National ID
                $checkStmt = $conn->prepare("SELECT id FROM residences WHERE national_id_no = ?");
                $checkStmt->bind_param("s", $national_id_no);
                $checkStmt->execute();
                $checkStmt->store_result();

                if ($checkStmt->num_rows > 0) {
                    $errorRows[] = implode(", ", $data) . " - National ID already exists.";
                    $checkStmt->close();
                    continue;
                }
                $checkStmt->close();

                $stmt = $conn->prepare("INSERT INTO residences (
                    first_name, middle_name, last_name, suffix, birth_date, birth_place, age, sex, civil_status,
                    nationality, religion, occupation, contact_number, address, pwd, pwd_id_no, indigent,
                    solo_parent, solo_parent_id_no, member_4ps, family_monthly_income, national_id_no,
                    philhealth_no, sss_no, pagibig_no, tin_no, voters_id_no, covid_status, vaccinated, date_of_registration
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

                if ($stmt) {
                    $stmt->bind_param(
                        'ssssssissssssssssssdsssssssss',
                        $first_name, $middle_name, $last_name, $suffix, $birth_date, $birth_place, $age, $sex, $civil_status,
                        $nationality, $religion, $occupation, $contact_number, $address, $pwd, $pwd_id_no, $indigent,
                        $solo_parent, $solo_parent_id_no, $member_4ps, $family_monthly_income, $national_id_no,
                        $philhealth_no, $sss_no, $pagibig_no, $tin_no, $voters_id_no, $covid_status, $vaccinated
                    );

                    if ($stmt->execute()) {
                        $insertCount++;
                    } else {
                        $errorRows[] = implode(", ", $data) . " - DB insert error: " . $stmt->error;
                    }

                    $stmt->close();
                } else {
                    $errorRows[] = implode(", ", $data) . " - Statement preparation error: " . $conn->error;
                }
            }

            fclose($file);

            $message = "<p style='color:green;'>CSV import completed.<br>Inserted: $insertCount<br>";
            if (!empty($errorRows)) {
                $message .= "<strong>Failed Rows:</strong><br><pre style='color:red; font-size:12px;'>" . implode("\n", $errorRows) . "</pre>";
            }
            $message .= "</p>";
        }
    } else {
        $message = "<p style='color:red;'>Error uploading the file.</p>";
    }
} else {
    $message = "<p style='color:red;'>No file submitted for import.</p>";
}

$_SESSION['upload_message'] = $message;
header("Location: ../admin/adminResidents.php");
exit();
