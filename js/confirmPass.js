document.getElementById("signup-form").addEventListener("submit", function(e) {
    const pw = document.getElementById("password").value;
    const cpw = document.getElementById("confirm-password").value;
    if (pw !== cpw) {
        alert("Passwords do not match.");
        e.preventDefault(); // Prevent form submission
    }
});