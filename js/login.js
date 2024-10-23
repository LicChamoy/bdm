document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("loginForm");

    if (loginForm) {
        loginForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Evitar el envío del formulario por defecto

            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            // Simulación de verificación de credenciales
            const users = {
                "estu@gmail.com": { password: "Contra123!", role: "student" },
                "instr@gmail.com": { password: "Contra123!", role: "instructor" },
                "admin@gmail.com": { password: "AContrad123!", role: "admin" }
            };

            // Comprobar si las credenciales son correctas
            if (users[email] && users[email].password === password) {
                const role = users[email].role;

                if (role === "student") {
                    window.location.href = "dashboard.html";
                } else if (role === "instructor") {
                    window.location.href = "dashboardInstr.html";
                } else if (role === "admin") {
                    window.location.href = "vistaAdmin.html";
                }
                alert("Inicio de sesión exitoso");
            } else {
                alert("Correo electrónico o contraseña incorrectos. Por favor, inténtalo de nuevo.");
            }
        });
    }
});
