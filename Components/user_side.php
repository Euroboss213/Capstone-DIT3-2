<aside class="sidebar">
  <h2 class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>

  <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $isMyHomePage = in_array($currentPage, ['userHome.php', 'userRequest_Indigency.php', 'userRequest_goodMoral.php', 'userRequest_permit.php', 'userViewReq_residency.php','userViewReq_good_moral.php', 'userViewReq_permit.php', 'userViewReq_certResidency.php', 'userViewReq_Indigency.php']);
    $isMyRequestsPage = in_array($currentPage, ['userViewReq.php']);
  ?>

  <button class="<?php echo $isMyHomePage ? 'side-button-active' : 'side-button'; ?>" onclick="window.location.href='userHome.php'">Request Document</button>

  <div id="inactiveOverlay" class="overlay" style="display:none;">
  <div class="overlay-content">
    <p>Your account is inactive. Please visit the barangay office to reactivate your account.</p>
    <button onclick="closeOverlay()">Close</button>
  </div>
</div>
</aside>