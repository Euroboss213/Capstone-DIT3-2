  const form = document.querySelector('.form-container');
  const passwordInput = document.getElementById('new_password');
  const errorText = document.getElementById('password_error');

  form.addEventListener('submit', function (event) {
    const password = passwordInput.value;
    const uppercase = /[A-Z]/;
    const number = /[0-9]/;
    const special = /[@$!%*?&.,#^()]/;
    const minLength = /.{8,}/;

    if (!minLength.test(password)) {
      errorText.textContent = 'Password must be at least 8 characters long.';
      event.preventDefault();
    } else if (!uppercase.test(password)) {
      errorText.textContent = 'Password must contain at least one uppercase letter.';
      event.preventDefault();
    } else if (!number.test(password)) {
      errorText.textContent = 'Password must contain at least one number.';
      event.preventDefault();
    } else if (!special.test(password)) {
      errorText.textContent = 'Password must contain at least one special character.';
      event.preventDefault();
    } else {
      errorText.textContent = ''; // Allow submit
    }
  });