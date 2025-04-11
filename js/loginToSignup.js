document.addEventListener("DOMContentLoaded", function () {
    const loginHeader = document.getElementById("login-header");
    const signupHeader = document.getElementById("signup-header");
    const loginForm = document.getElementById("login-form");
    const signupForm = document.getElementById("signup-form");

    loginHeader.addEventListener("click", () => {
        loginForm.style.display = "flex";
        signupForm.style.display = "none";

        loginHeader.classList.add("header-active");
        loginHeader.classList.remove("header-inactive");

        signupHeader.classList.add("header-inactive");
        signupHeader.classList.remove("header-active");
    });

    signupHeader.addEventListener("click", () => {
        loginForm.style.display = "none";
        signupForm.style.display = "grid";

        signupHeader.classList.add("header-active");
        signupHeader.classList.remove("header-inactive");

        loginHeader.classList.add("header-inactive");
        loginHeader.classList.remove("header-active");
    });
});
