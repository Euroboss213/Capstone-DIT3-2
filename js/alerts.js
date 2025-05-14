function showRequestAlertIndigency() {
  const alert = document.getElementById("requestAlertIndigency");
  alert.style.display = "flex";
  alert.style.visibility = "visible";
  alert.style.opacity = "1";
}

function showRequestAlertResidency() {
  const alert = document.getElementById("requestAlertResidency");
  alert.style.display = "flex";
  alert.style.visibility = "visible";
  alert.style.opacity = "1";
}
function showRequestAlertPermit() {
  const alert = document.getElementById("requestAlertPermit");
  alert.style.display = "flex";
  alert.style.visibility = "visible";
  alert.style.opacity = "1";
}

function closeAlert(alertId) {
  const alert = document.getElementById(alertId);
  alert.style.display = "none";
  alert.style.visibility = "hidden";
  alert.style.opacity = "0";
}
