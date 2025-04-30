<?php
session_start();
require_once '../database/connect_db_reqwest.php';

// Enable full error reporting during development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$logFile = '../logs/log.txt';
file_put_contents($logFile, "=== CSV Upload Script Started ===\n", FILE_APPEND);

$message = "";

if (isset($_POST['import_csv']) && isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
    file_put_contents($logFile, "CSV upload detected.\n", FILE_APPEND);

    $file = fopen($_FILES['csv_file']['tmp_name'], 'r');

    // Detect delimiter (comma vs tab)
    $firstLine = fgets($file);
    $delimiter = (substr_count($firstLine, "\t") > substr_count($firstLine, ",")) ? "\t" : ",";
    file_put_contents($logFile, "Detected delimiter: " . ($delimiter === "\t" ? "Tab" : "Comma") . "\n", FILE_APPEND);

    rewind($file);
    $header = fgetcsv($file, 10000, $delimiter);

    // Handle BOM in header
    if (substr($header[0], 0, 3) === "\xEF\xBB\xBF") {
        $header[0] = substr($header[0], 3);
        file_put_contents($logFile, "BOM removed from header.\n", FILE_APPEND);
    }

    // Normalize headers
    $header = array_map(fn($val) => strtolower(str_replace(' ', '_', trim($val))), $header);
    file_put_contents($logFile, "Parsed header: " . implode(',', $header) . "\n", FILE_APPEND);

    $expectedHeaders = [
        'first_name', 'middle_name', 'last_name', 'suffix', 'birth_date', 'birth_place', 'sex', 'civil_status',
    'nationality', 'religion', 'occupation', 'contact_number', 'address', 'pwd', 'pwd_id_no', 'indigent',
    'solo_parent', 'solo_parent_id_no', 'member_4ps', 'family_monthly_income', 'national_id_no', 'philhealth_no',
    'sss_no', 'pagibig_no', 'tin_no', 'voters_id_no', 'covid_status', 'vaccinated'
    ];

    if ($header !== $expectedHeaders) {
        $message = "<p style='color:red;'>CSV headers do not match the required template.</p>";
        file_put_contents($logFile, "Header mismatch.\nExpected: " . implode(', ', $expectedHeaders) . "\nGot: " . implode(', ', $header) . "\n", FILE_APPEND);
    } else {
        $insertCount = 0;
        $errorRows = [];

        while (($data = fgetcsv($file, 10000, $delimiter)) !== false) {
            if (count($data) < count($expectedHeaders)) {
                $errorRows[] = implode(", ", $data) . " - Incomplete data row.";
                continue;
            }

            [
                $first_name, $middle_name, $last_name, $suffix, $birth_date, $birth_place, $sex, $civil_status,
                $nationality, $religion, $occupation, $contact_number, $address, $pwd, $pwd_id_no, $indigent,
                $solo_parent, $solo_parent_id_no, $member_4ps, $family_monthly_income, $national_id_no,
                $philhealth_no, $sss_no, $pagibig_no, $tin_no, $voters_id_no, $covid_status, $vaccinated
            ] = $data;

            if (!empty($birth_date)) {
                $date_parts = explode('/', $birth_date);
                if (count($date_parts) === 3) {
                    $birth_date = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0];
                }
            }
            
            // Required fields check
            $requiredFields = [
                'first_name' => $first_name,
                'middle_name' => $middle_name,
                'last_name' => $last_name,
                'birth_date' => $birth_date,
                'birth_place' => $birth_place,
                'sex' => $sex,
                'civil_status' => $civil_status,
                'nationality' => $nationality,
                'religion' => $religion,
                'occupation' => $occupation,
                'contact_number' => $contact_number,
                'address' => $address,
                'pwd' => $pwd,
                'indigent' => $indigent,
                'solo_parent' => $solo_parent,
                'member_4ps' => $member_4ps,
                'family_monthly_income' => $family_monthly_income,
                'voters_id_no' => $voters_id_no,
                'covid_status' => $covid_status,
                'vaccinated' => $vaccinated
            ];
            
            foreach ($requiredFields as $fieldName => $fieldValue) {
                if (empty($fieldValue)) {
                    $formattedField = ucwords(str_replace('_', ' ', $fieldName)); // e.g., "first_name" -> "First Name"
                    $errorRows[] = "Missing data for required field: $formattedField";
                    continue 2; // Skip to next row immediately once a missing required field is found
                }
            }

            // ID format validation
            $idPatterns = [
                'pwd_id_no' => '/^PWD-\d{4}-\d{4}$/',
                'solo_parent_id_no' => '/^SP-\d{4}-\d{4}$/',
                'national_id_no' => '/^\d{4} \d{4} \d{4}$/',
                'philhealth_no' => '/^\d{2}-\d{4}-\d{4}$/',
                'sss_no' => '/^\d{2}-\d{7}-\d{1}$/',
                'pagibig_no' => '/^\d{4}-\d{4}-\d{4}$/',
                'tin_no' => '/^\d{3}-\d{3}-\d{3}$/',
                'voters_id_no' => '/^VIN-\d{4}-\d{4}$/'
            ];

            $invalidFormat = false;
            foreach ($idPatterns as $field => $pattern) {
                $value = $$field;
                if (!empty($value) && !preg_match($pattern, $value)) {
                    $errorRows[] = implode(", ", $data) . " - Invalid $field format.";
                    $invalidFormat = true;
                    break;
                }
            }

            if ($invalidFormat) continue;

            // Check for duplicate IDs
            $idFieldsToCheck = [
                'national_id_no',
                'pwd_id_no',
                'solo_parent_id_no',
                'philhealth_no',
                'sss_no',
                'pagibig_no',
                'tin_no',
                'voters_id_no'
            ];

            $duplicateFound = false;
            foreach ($idFieldsToCheck as $idField) {
                $value = $$idField;
                if (!empty($value)) {
                    $check = $conn->prepare("SELECT id FROM residences WHERE $idField = ?");
                    $check->bind_param("s", $value);
                    $check->execute();
                    $check->store_result();

                    if ($check->num_rows > 0) {
                        $errorRows[] = implode(", ", $data) . " - Upload unsuccessful: $idField ($value) already exists in the database.";
                        $check->close();
                        $duplicateFound = true;
                        break;
                    }
                    $check->close();
                }
            }

            if ($duplicateFound) continue;

            // Prepare insert
            $stmt = $conn->prepare("INSERT INTO residences (
                first_name, middle_name, last_name, suffix, birth_date, birth_place, sex, civil_status,
                nationality, religion, occupation, contact_number, address, pwd, pwd_id_no, indigent,
                solo_parent, solo_parent_id_no, member_4ps, family_monthly_income, national_id_no,
                philhealth_no, sss_no, pagibig_no, tin_no, voters_id_no, covid_status, vaccinated, date_of_registration
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

            if ($stmt) {
                $stmt->bind_param(
                    'ssssssssssssssssssdsssssssss',
                    $first_name, $middle_name, $last_name, $suffix, $birth_date, $birth_place, $sex, $civil_status,
                    $nationality, $religion, $occupation, $contact_number, $address, $pwd, $pwd_id_no, $indigent,
                    $solo_parent, $solo_parent_id_no, $member_4ps, $family_monthly_income, $national_id_no,
                    $philhealth_no, $sss_no, $pagibig_no, $tin_no, $voters_id_no, $covid_status, $vaccinated
                );
                

                try {
                    $stmt->execute();
                    $insertCount++;
                } catch (mysqli_sql_exception $e) {
                    $errorRows[] = implode(", ", $data) . " - Insert error: " . $e->getMessage();
                }
                $stmt->close();
            } else {
                $errorRows[] = implode(", ", $data) . " - Failed to prepare statement.";
            }
        }

        fclose($file);

        // Final feedback message
        if ($insertCount > 0) {
            $message = "<p style='color:green;'>$insertCount record(s) successfully imported.</p>";
        }
        if (!empty($errorRows)) {
            $message .= "<p style='color:red;'>Import Failed for the following reasons:</p><ul>";
            foreach ($errorRows as $err) {
                // Change: Only show the ID part of the error
                $idFieldsWithLabels = [
                    'national_id_no' => 'National ID No.',
                    'pwd_id_no' => 'PWD ID No.',
                    'solo_parent_id_no' => 'Solo Parent ID No.',
                    'philhealth_no' => 'PhilHealth No.',
                    'sss_no' => 'SSS No.',
                    'pagibig_no' => 'Pag-IBIG No.',
                    'tin_no' => 'TIN No.',
                    'voters_id_no' => 'Voter\'s ID No.'
                ];
                
                $matched = false;
                $fullName = trim("$first_name $middle_name $last_name" . (!empty($suffix) ? " $suffix" : ""));
                foreach ($idFieldsWithLabels as $field => $label) {
                 if (strpos($err, $field) !== false && preg_match("/$field\s*\((.*?)\)/", $err, $matches)) {
                // Assuming you have the full name stored in $fullName
                 $message .= "<li>" . htmlspecialchars($fullName) . " - $label (" . htmlspecialchars($matches[1]) . ") already exists in the database.</li>";
                 $matched = true;
                 break;
                 }
}
                
                if (!$matched) {
                    $message .= "<li>" . htmlspecialchars($err) . "</li>";
                }
            }
            $message .= "</ul>";
        }
    }
} else {
    $message = "<p style='color:red;'>No file uploaded or an error occurred during upload.</p>";
}

$_SESSION['import_message'] = $message;
header("Location: ../admin/adminResidents.php");
exit;
?>
