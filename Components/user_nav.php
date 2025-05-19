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
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 8.5A6.5 6.5 0 018.5 2h7a6.5 6.5 0 016.5 6.5v3a6.5 6.5 0 01-6.5 6.5h-2.586a1 1 0 00-.707.293l-3.414 3.414A1 1 0 0110 21v-2.5a1 1 0 00-1-1H8.5A6.5 6.5 0 012 14.5v-6z" />
  </svg>
</button>
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
  <div id="acc-dropdownMenu" class="dropdown-menu">
  <button class="dropdown-item-btn" onclick="location.href='../user/manageAcc.php'">Manage Account</button>
  <button class="dropdown-item-btn" onclick="location.href='../php/tologout.php'">Logout</button>
</div>
</div>
<div id="chat-dropdownMenu" class="dropdown-menu">
  <button type="submit" class="dropdown-item-btn" id="chatBot-btn">AI Assistant</button>
  <button type="submit" class="dropdown-item-btn" id="autoChat-btn">Chat Bot</button>
</div>
  </div>
</nav>