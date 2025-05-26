function closeSignupAlert() {
  const alert = document.getElementById('signupSuccessAlert');
  alert.style.opacity = '0';
  alert.style.visibility = 'hidden';
  setTimeout(() => {
    alert.style.display = 'none';
  }, 300);
}

window.addEventListener('DOMContentLoaded', () => {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.has('signup_success')) {
    const alert = document.getElementById('signupSuccessAlert');
    alert.style.display = 'flex';
    alert.style.visibility = 'visible';
    alert.style.opacity = '1';
  }
});