<?php

$conn = new mysqli("localhost", "root", "", "reqwest");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$userName = "Admin Account"; // default text

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    // Fetch role and name for logged-in user
    $stmt = $conn->prepare("SELECT role, first_name, middle_name, last_name, suffix FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['role'] === 'admin') {
            $first_name = $user['first_name'];
            $middle_name = $user['middle_name'];
            $last_name = $user['last_name'];
            $suffix = $user['suffix'];

            $middle_initial = $middle_name ? strtoupper(substr($middle_name, 0, 1)) . '.' : '';
            $suffix_part = $suffix ? ', ' . $suffix : '';
            $full_name = "{$first_name} {$middle_initial} {$last_name}{$suffix_part}";
            
            $userName = htmlspecialchars($full_name);
        }
    }
    $stmt->close();
}

$conn->close();
?>



<aside class="sidebar">
  <h2 class="user-name"><?= $userName ?></h2>

  <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $isDashboard = ($currentPage === 'adminDashboard.php');
    $isResidents = ($currentPage === 'adminResidents.php');
    $isUserAccounts = ($currentPage === 'adminUserAccounts.php');
    $isDocReqPage = in_array($currentPage, ['adminDocReq.php', 'adminPrintList.php', 'adminDocReq_indigency.php', 'adminPrintIndigency.php', 'adminDocReq_residency.php', 'adminDocReq_permit.php', 'adminDocReq_good_moral.php', 'adminPrintpermit.php', 'adminPrintindigency.php', 'adminPrintgood_moral.php', 'adminPrintcertresidency.php']);
  ?>

  <button class="<?php echo $isDashboard ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='adminDashboard.php'">Dashboard</button>

  <button class="<?php echo  $isDocReqPage ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='adminDocReq.php'">
  Document Requests 
  </button>

  <button class="<?php echo $isResidents ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='adminResidents.php'">Registered Residents</button>

  <button class="<?php echo $isUserAccounts ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='adminUserAccounts.php'">User Accounts</button>
</aside>