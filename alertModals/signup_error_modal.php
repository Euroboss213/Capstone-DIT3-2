<?php if (isset($_GET['signup_error'])): ?>
<div id="signupErrorModal" class="custom-alert-overlay" style="display: flex; visibility: visible; opacity: 1;">
  <div class="custom-alert-box">
    <div class="alert-icon">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <circle cx="12" cy="12" r="10" stroke="#dc3545" stroke-width="2" fill="#fdecea"/>
        <path stroke="#dc3545" stroke-width="2" stroke-linecap="round" d="M12 8v4m0 4h.01"/>
      </svg>
    </div>
    <p>
      <?php
        switch ($_GET['signup_error']) {
          case 'password_mismatch':
            echo "Passwords do not match!";
            break;
          case 'id_not_found':
            echo "Resident is not a Registered Voter!";
            break;
          case 'duplicate_user':
            echo "A user with this name already has an account!";
            break;
          case 'no_residence':
            echo "ID did not match any existing Resident!";
            break;
          case 'insert_failed':
            echo "Error occurred while creating your account. Please try again.";
            break;
          case 'db_prepare_residence':
          case 'db_prepare_user_check':
          case 'db_prepare_insert':
            echo "A database error occurred. Please contact support.";
            break;
          case 'weak_password':
            echo "The password did not meet the requirements";
            break;
          default:
            echo "An unknown error occurred. Please try again.";
        }
      ?>
    </p>
    <button onclick="closeAlert()">Ok</button>
  </div>
</div>
<?php endif; ?>
