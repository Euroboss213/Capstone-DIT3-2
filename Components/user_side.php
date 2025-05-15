<aside class="sidebar">
  <h2 class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>

  <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $isMyHomePage = in_array($currentPage, ['userHome.php', 'userRequest_Indigency.php']);
    $isMyRequestsPage = in_array($currentPage, ['userViewReq.php', 'userViewReq_indigency.php', 'userViewReq_certResidency.php', 'userViewReq_permit.php', 'userViewReq_goodMoral.php']);
  ?>

  <button class="<?php echo $isMyHomePage ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='userHome.php'">Home</button>

  <button class="<?php echo $isMyRequestsPage ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='userViewReq.php'">
  My Requests
  <?php if (isset($hasUnread) && $hasUnread): ?>
    <span class="notif-dot"></span>
  <?php endif; ?>
</button>
</aside>