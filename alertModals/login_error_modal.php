<!-- loginErrorModal.php -->
<div id="loginErrorAlert" class="custom-alert-overlay" style="display: none; visibility: hidden; opacity: 0;">
  <div class="custom-alert-box">
    <div class="alert-icon">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <circle cx="12" cy="12" r="10" stroke="#dc3545" stroke-width="2" fill="#fdecea"/>
        <path stroke="#dc3545" stroke-width="2" stroke-linecap="round" d="M12 8v4m0 4h.01"/>
      </svg>
    </div>
    <p id="loginErrorMessage">An error occurred.</p>
    <button onclick="closeLoginAlert()">Ok</button>
  </div>
</div>