// Show the success modal
function showRequestSuccessAlert(message = "Your request was submitted successfully!") {
  const modal = document.getElementById("requestSuccessAlert");
  const msgText = document.getElementById("requestSuccessMessage");

  if (msgText) msgText.textContent = message;

  modal.style.display = "flex";
  setTimeout(() => {
    modal.style.visibility = "visible";
    modal.style.opacity = 1;
  }, 10);
}

// Close the modal
function closeRequestSuccessAlert() {
  const modal = document.getElementById("requestSuccessAlert");
  modal.style.opacity = 0;
  modal.style.visibility = "hidden";
  setTimeout(() => {
    modal.style.display = "none";
    window.location.href = '../user/userHome.php'; // redirect after closing
  }, 300);
}
