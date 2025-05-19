document.getElementById("signup-form").addEventListener("submit", function(e) {
    const pw = document.getElementById("password").value;
    const cpw = document.getElementById("confirm-password").value;

    const pwPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

    if (pw !== cpw) {
        alert("Passwords do not match.");
        e.preventDefault();
    } else if (!pwPattern.test(pw)) {
        alert("Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.");
        e.preventDefault();
    }
});
