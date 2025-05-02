function showRequestAlert() {
  const alert = document.getElementById("requestAlertIndigency");
  alert.style.display = "flex";
  alert.style.visibility = "visible";
  alert.style.opacity = "1";
}

function closeAlert() {
  const alert = document.getElementById("requestAlertIndigency");
  alert.style.display = "none";
  alert.style.visibility = "hidden";
  alert.style.opacity = "0";
}
