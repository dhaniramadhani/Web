const formLogin = document.getElementById("form-login");

formLogin.addEventListener("submit", function (event) {
    event.preventDefault();

    const username = document.getElementById("username");
    const password = document.getElementById("password");

    const errorUsername =
        document.getElementById("error-username");

    const errorPassword =
        document.getElementById("error-password");

    const loginError =
        document.getElementById("login-error");

    let valid = true;


    errorUsername.classList.add("hidden");
    errorPassword.classList.add("hidden");
    loginError.classList.add("hidden");

    username.classList.remove("border-red-500");
    password.classList.remove("border-red-500");


    if (username.value.trim() === "") {
        errorUsername.textContent =
            "Username wajib diisi.";

        errorUsername.classList.remove("hidden");
        username.classList.add("border-red-500");

        valid = false;
    }


    if (password.value.trim() === "") {
        errorPassword.textContent =
            "Password wajib diisi.";

        errorPassword.classList.remove("hidden");
        password.classList.add("border-red-500");

        valid = false;
    }


    if (!valid) {
        return;
    }


    if (
        username.value === "petugas" &&
        password.value === "12345"
    ) {
        window.location.href = "index.html";
    } else {
        loginError.classList.remove("hidden");
    }
});