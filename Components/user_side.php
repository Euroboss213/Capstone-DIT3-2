<aside class="sidebar">
  <h2 class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>

  <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $isMyHomePage = in_array($currentPage, ['userHome.php', 'userRequest_Indigency.php', 'userRequest_goodMoral.php', 'userRequest_permit.php', 'userRequest_certResidency.php','userViewReq_goodMoral.php', 'userViewReq_permit.php', 'userViewReq_certResidency.php', 'userViewReq_Indigency.php']);
    $isMyRequestsPage = in_array($currentPage, ['userViewReq.php']);
  ?>

  <button class="<?php echo $isMyHomePage ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='userHome.php'">Request Document</button>
</aside>