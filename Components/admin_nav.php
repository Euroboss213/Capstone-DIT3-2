<nav class="navbar">
    <div class="logo-container">
      <img src="../assets/logo.png" alt="REQWEST Logo" class="logo-img" />
      <div class="barangay-name">
        <span class="barangay">Barangay West Kamias</span>
        <span class="city">Quezon City</span>
      </div>
    </div>
    <div class="profile-menu">
          <!-- Notification Button -->
     <button id="notifButton" id="notifButton-unread" class="notif-button">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405C18.2 14.79 18 13.918 18 13V9a6 6 0 10-12 0v4c0 .918-.2 1.79-.595 2.595L4 17h5m6 0v1a3 3 0 11-6 0v-1h6z" />
      </svg>
      <?php if (isset($hasUnread) && $hasUnread): ?>
        <span class="notif-dot"></span>
      <?php endif; ?>
    </button>
      <button id="profileButton" class="profile-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </button>
      <div id="dropdownMenu" class="dropdown-menu">
        <a href="../admin/manageAcc_admin.php" class="dropdown-item">Manage Account</a>
        <a href="../pages/newlogin.php" class="dropdown-item">Logout</a>
      </div>
    </div>
  </nav>
