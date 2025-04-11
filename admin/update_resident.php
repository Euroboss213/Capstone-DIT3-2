<?php
// Assuming you have already established a database connection
// Replace these variables with actual database connection details
$servername = "localhost"; // your database server
$username = "username";   // your database username
$password = "";   // your database password
$dbname = "admin"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect data from the form
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $suffix = $_POST['suffix'];
    $birth_date = $_POST['birth_date'];
    $birth_place = $_POST['birth_place'];
    $age = $_POST['age'];
    $sex = $_POST['sex'];
    $civil_status = $_POST['civil_status'];
    $nationality = $_POST['nationality'];
    $religion = $_POST['religion'];
    $occupation = $_POST['occupation'];
    $contact_number = $_POST['contact_number'];
    $address = $_POST['address'];
    $pwd = $_POST['pwd'];
    $pwd_id_no = $_POST['pwd_id_no'];
    $indigent = $_POST['indigent'];
    $solo_parent = $_POST['solo_parent'];
    $solo_parent_id_no = $_POST['solo_parent_id_no'];
    $member_4ps = $_POST['member_4ps'];
    $family_monthly_income = $_POST['family_monthly_income'];
    $registered_voter = $_POST['registered_voter'];
    $purok_no = $_POST['purok_no'];
    $house_no = $_POST['house_no'];
    $street = $_POST['street'];
    $emergency_full_name = $_POST['emergency_full_name'];
    $emergency_relationship = $_POST['emergency_relationship'];
    $emergency_contact_no = $_POST['emergency_contact_no'];
    $emergency_address = $_POST['emergency_address'];
    $national_id_no = $_POST['national_id_no'];
    $philhealth_no = $_POST['philhealth_no'];
    $sss_no = $_POST['sss_no'];
    $pagibig_no = $_POST['pagibig_no'];
    $tin_no = $_POST['tin_no'];
    $voters_id_no = $_POST['voters_id_no'];
    $covid_status = $_POST['covid_status'];
    $vaccinated = $_POST['vaccinated'];
    $date_of_registration = $_POST['date_of_registration'];
    $date_of_death = $_POST['date_of_death'];
    $alive_or_deceased = $_POST['alive_or_deceased'];

    // Prepare the SQL query with placeholders
    $sql = "UPDATE residences SET 
                first_name = ?, 
                middle_name = ?, 
                last_name = ?, 
                suffix = ?, 
                birth_date = ?, 
                birth_place = ?, 
                age = ?, 
                sex = ?, 
                civil_status = ?, 
                nationality = ?, 
                religion = ?, 
                occupation = ?, 
                contact_number = ?, 
                address = ?, 
                pwd = ?, 
                pwd_id_no = ?, 
                indigent = ?, 
                solo_parent = ?, 
                solo_parent_id_no = ?, 
                member_4ps = ?, 
                family_monthly_income = ?, 
                registered_voter = ?, 
                purok_no = ?, 
                house_no = ?, 
                street = ?, 
                emergency_full_name = ?, 
                emergency_relationship = ?, 
                emergency_contact_no = ?, 
                emergency_address = ?, 
                national_id_no = ?, 
                philhealth_no = ?, 
                sss_no = ?, 
                pagibig_no = ?, 
                tin_no = ?, 
                voters_id_no = ?, 
                covid_status = ?, 
                vaccinated = ?, 
                date_of_registration = ?, 
                date_of_death = ?, 
                alive_or_deceased = ? 
            WHERE id = ?";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $stmt->bind_param("sssssssssssssssssssssssssssssssssssssssssss", 
            $first_name, 
            $middle_name, 
            $last_name, 
            $suffix, 
            $birth_date, 
            $birth_place, 
            $age, 
            $sex, 
            $civil_status, 
            $nationality, 
            $religion, 
            $occupation, 
            $contact_number, 
            $address, 
            $pwd, 
            $pwd_id_no, 
            $indigent, 
            $solo_parent, 
            $solo_parent_id_no, 
            $member_4ps, 
            $family_monthly_income, 
            $registered_voter, 
            $purok_no, 
            $house_no, 
            $street, 
            $emergency_full_name, 
            $emergency_relationship, 
            $emergency_contact_no, 
            $emergency_address, 
            $national_id_no, 
            $philhealth_no, 
            $sss_no, 
            $pagibig_no, 
            $tin_no, 
            $voters_id_no, 
            $covid_status, 
            $vaccinated, 
            $date_of_registration, 
            $date_of_death, 
            $alive_or_deceased, 
            $id
        );

        // Execute the statement
        if ($stmt->execute()) {
            echo "Resident information updated successfully.";
        } else {
            echo "Error updating information: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the query: " . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>
