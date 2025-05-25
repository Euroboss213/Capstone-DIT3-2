<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>No Completed Requests</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../styles/alertModal_style.css" />
</head>
<body style="background-color: rgba(0,0,0,0.5); margin: 0;">
  <div class="custom-alert-overlay" style="display: flex; visibility: visible; opacity: 1;">
    <div class="custom-alert-box">
      <div class="alert-icon">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <circle cx="12" cy="12" r="10" stroke="#dc3545" stroke-width="2" fill="#fdecea"/>
          <path stroke="#dc3545" stroke-width="2" stroke-linecap="round" d="M12 8v4m0 4h.01"/>
        </svg>
      </div>
      <p>There are no Completed Document Request.</p>
      <div class="modal-footer justify-content-center">
        <button class="btn btn-primary" onclick="history.back()">Go Back</button>
      </div>
    </div>
  </div>
</body>
</html>
