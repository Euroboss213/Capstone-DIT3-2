<?php
include "../php/auth_check.php";

$userName = $_SESSION['user_name'];

// Define path to the complete PDF
$pdfPath = "../temp/complete_requests.pdf";

// Check if file exists
if (!file_exists($pdfPath)) {
    die("The complete requests PDF does not exist.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Complete Requests PDF</title>
    <link rel="stylesheet" href="../styles/adminTemplate.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo-container">
            <img src="../assets/logo.png" alt="REQWEST Logo" class="logo-img" />
            <div class="barangay-name">
                <span class="barangay">Barangay West Kamias</span>
                <span class="city">Quezon City</span>
            </div>
        </div>
        <div class="profile-menu">
            <button id="profileButton" class="profile-button">👤</button>
            <div id="dropdownMenu" class="dropdown-menu">
                <a href="#" class="dropdown-item">Change Password</a>
                <a href="../pages/newlogin.php" class="dropdown-item">Logout</a>
            </div>
        </div>
    </nav>

    <div class="flex-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <h2 class="user-name">Admin Account</h2>
            <button class="side-button" onclick="window.location.href='adminDashboard.php'">Dashboard</button>
            <button class="side-button" onclick="window.location.href='adminDocReq.php'">Document Requests</button>
            <button class="side-button" onclick="window.location.href='adminResidents.php'">Registered Residents</button>
            <button class="side-button" onclick="window.location.href='adminUserAccounts.php'">User Accounts</button>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="top-bar">
                <button class="back-btn" onclick="window.location.href='adminDocReq.php'">Go Back</button>
            </div>

            <h2>Complete Requests Document</h2>

            <!-- Embed complete_requests.pdf -->
            <div id="pdf-container">
                <object data="<?= $pdfPath ?>" type="application/pdf" width="100%" height="600px">
                    <p>Your browser does not support PDFs. <a href="<?= $pdfPath ?>">Download the PDF</a>.</p>
                </object>
            </div>

            <br><br>
            <a href="adminDocReq.php">Back to Document Requests</a>
        </main>
    </div>
</body>
</html>
