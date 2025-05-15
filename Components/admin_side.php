<aside class="sidebar">
  <h2 class="user-name">Admin Account</h2>

  <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $isDashboard = ($currentPage === 'adminDashboard.php');
    $isResidents = ($currentPage === 'adminResidents.php');
    $isUserAccounts = ($currentPage === 'adminUserAccounts.php');
    $isDocReqPage = in_array($currentPage, ['adminDocReq.php', 'adminPrintList.php', 'adminDocReq_indigency.php', 'adminPrintIndigency.php', 'adminDocReq_certResidency.php', 'adminDocReq_permit.php', 'adminDocReq_goodMoral.php']);
  ?>

  <button class="<?php echo $isDashboard ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='adminDashboard.php'">Dashboard</button>

  <button class="<?php echo  $isDocReqPage ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='adminDocReq.php'">
  Document Requests 
  <?php if (isset($hasUnread) && $hasUnread): ?>
    <span class="notif-dot"></span>
  <?php endif; ?>
  </button>

  <button class="<?php echo $isResidents ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='adminResidents.php'">Registered Residents</button>

  <button class="<?php echo $isUserAccounts ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='adminUserAccounts.php'">User Accounts</button>
</aside>