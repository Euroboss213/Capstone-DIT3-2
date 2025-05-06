<nav class="navbar">
  <div class="logo-container">
    <img src="../assets/logo.png" alt="REQWEST Logo" class="logo-img" />
    <div class="barangay-name">
      <span class="barangay">Barangay West Kamias</span>
      <span class="city">Quezon City</span>
    </div>
  </div>
  <div class="profile-menu">
    <button id="chatButton" class="chat-button">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v7z" />
      </svg>
    </button>
     <!-- Notification Button -->
     <button id="notifButton" class="notif-button">
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
    <div id="acc-dropdownMenu" class="dropdown-menu">
    <form action="../user/manageAcc.php" method="post">
  <button type="submit" class="dropdown-item-btn">Manage Account</button>
</form>
  <form action="../php/tologout.php" method="post">
  <button type="submit" class="dropdown-item-btn">Logout</button>
  </form>
</div>
<div id="chat-dropdownMenu" class="dropdown-menu">
  <button type="submit" class="dropdown-item-btn" id="chatBot-btn">AI Assistant</button>
  <button type="submit" class="dropdown-item-btn" id="autoChat-btn">Chat Bot</button>
</div>
  </div>
</nav>