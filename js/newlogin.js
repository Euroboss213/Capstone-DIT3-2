const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click', () => {
    container.classList.add('active');
})

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
})
function closeLoginAlert() {
    const alertBox = document.getElementById("loginErrorAlert");
    alertBox.style.opacity = 0;
    alertBox.style.visibility = "hidden";
    setTimeout(() => alertBox.style.display = "none", 300);
    history.replaceState(null, "", window.location.pathname); // Clean URL
  }
  
  document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get("error");
  
    if (error) {
      let message = "";
      if (error === "invalid_credentials") {
        message = "User does not exist, make sure you sign up.";
      } else if (error === "invalid_password") {
        message = "You entered an incorrect password.";
      }
  
      if (message) {
        const alertBox = document.getElementById("loginErrorAlert");
        document.getElementById("loginErrorMessage").textContent = message;
        alertBox.style.display = "flex";
        setTimeout(() => {
          alertBox.style.visibility = "visible";
          alertBox.style.opacity = 1;
        }, 50);
      }
    }
  });
  function closeAlert() {
    const modal = document.getElementById('signupErrorModal');
    modal.style.opacity = '0';
    modal.style.visibility = 'hidden';
    setTimeout(() => modal.style.display = 'none', 300);
  }
  