const formLogin =
    document.getElementById("form-login");


if (formLogin) {
    formLogin.addEventListener(
        "submit",
        function (event) {
            event.preventDefault();

            const username =
                document.getElementById(
                    "username"
                );

            const password =
                document.getElementById(
                    "password"
                );

            const errorUsername =
                document.getElementById(
                    "error-username"
                );

            const errorPassword =
                document.getElementById(
                    "error-password"
                );

            const loginError =
                document.getElementById(
                    "login-error"
                );


            let valid = true;


            errorUsername.classList.add(
                "hidden"
            );

            errorPassword.classList.add(
                "hidden"
            );

            loginError.classList.add(
                "hidden"
            );


            if (
                username.value.trim() === ""
            ) {
                errorUsername.textContent =
                    "Username wajib diisi.";

                errorUsername.classList.remove(
                    "hidden"
                );

                valid = false;
            }


            if (
                password.value.trim() === ""
            ) {
                errorPassword.textContent =
                    "Password wajib diisi.";

                errorPassword.classList.remove(
                    "hidden"
                );

                valid = false;
            }


            if (!valid) {
                return;
            }


            if (
                username.value === "dhani" &&
                password.value === "12345"
            ) {
                window.location.href =
                    "index.php";
            } else {
                loginError.classList.remove(
                    "hidden"
                );  
            }
        }
    );
}