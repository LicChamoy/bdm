document.addEventListener("DOMContentLoaded", function() {
    // -----------------------------------------------
    // Registro de Usuario: Validación y Redirección
    // -----------------------------------------------
    const registerForm = document.getElementById("registerForm");
    const registerSuccessMessage = document.getElementById("register-success");

    if (registerForm) {
        registerForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Evitar envío por defecto

            // Validar contraseña
            const password = document.getElementById("password").value;
            const passwordRegex = /^(?=.*\d)(?=.*[A-Z])(?=.*[@$!%*?&#]).{8,}$/;

            if (!passwordRegex.test(password)) {
                alert("La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.");
                return;
            }

            // Validar género
            const gender = document.getElementById("gender").value;
            if (gender === "") {
                alert("Por favor, selecciona tu género.");
                return;
            }

            // Validar avatar
            const avatar = document.getElementById("avatar").files[0];
            if (!avatar) {
                alert("Por favor, sube una imagen de avatar.");
                return;
            } else {
                const fileSizeMB = avatar.size / (1024 * 1024);
                if (fileSizeMB > 2) {
                    alert("El avatar no debe exceder los 2MB.");
                    return;
                }
            }

            // Simulación de registro exitoso
            registerSuccessMessage.textContent = "Registro exitoso. Redirigiendo a la página de inicio de sesión...";

            // Redirigir al login después de 2 segundos
            setTimeout(function() {
                window.location.href = "login.html";
            }, 2000);  // 2000 ms = 2 segundos
        });
    }

    // -----------------------------------------------
    // Inicio de Sesión: Validación e Intentos Fallidos
    // -----------------------------------------------
    const loginForm = document.getElementById("loginForm");
    const errorMessage = document.getElementById("error-message");

    // Obtener el número de intentos fallidos del LocalStorage
    let failedAttempts = localStorage.getItem("failedAttempts") || 0;

    // Verificar si el usuario está bloqueado
    if (failedAttempts >= 3) {
        errorMessage.textContent = "Usuario deshabilitado por demasiados intentos fallidos.";
        loginForm.querySelector("button").disabled = true; // Deshabilitar el botón de inicio de sesión
    }

    if (loginForm) {
        loginForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Evitar el envío del formulario por defecto

            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            // Simulación de verificación de credenciales (cambiar por lógica real más adelante)
            const correctEmail = "usuario@example.com";
            const correctPassword = "Password123!";

            // Comprobar si las credenciales son correctas
            if (email === correctEmail && password === correctPassword) {
                alert("Inicio de sesión exitoso");
                localStorage.setItem("failedAttempts", 0); // Reiniciar los intentos fallidos
                window.location.href = "dashboard.html"; // Redirigir a una página principal (simulado)
            } else {
                failedAttempts++;
                localStorage.setItem("failedAttempts", failedAttempts); // Incrementar los intentos fallidos
                errorMessage.textContent = `Intento fallido ${failedAttempts}.`;

                // Bloquear después de 3 intentos fallidos
                if (failedAttempts >= 3) {
                    errorMessage.textContent = "Usuario deshabilitado por demasiados intentos fallidos.";
                    loginForm.querySelector("button").disabled = true; // Deshabilitar el botón de inicio de sesión
                }
            }
        });
    }
});
