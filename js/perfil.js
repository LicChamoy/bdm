document.addEventListener("DOMContentLoaded", function() {
    const editProfileForm = document.getElementById("editProfileForm");

    // Simulamos datos almacenados en localStorage (puedes cambiarlo para obtener datos reales)
    const userData = {
        name: "Alex Pérez",
        email: "alex.perez@gmail.com",
        dob: "1990-05-15",
        gender: "male",
        role: "student",
    };

    // Prellenar el formulario con los datos del usuario
    document.getElementById("name").value = userData.name;
    document.getElementById("email").value = userData.email;
    document.getElementById("dob").value = userData.dob;
    document.getElementById("gender").value = userData.gender;
    document.getElementById("role").value = userData.role;

    // Guardar los cambios al enviar el formulario
    editProfileForm.addEventListener("submit", function(event) {
        event.preventDefault();

        // Simular guardado de los cambios (puedes usar localStorage para persistir cambios)
        const updatedData = {
            name: document.getElementById("name").value,
            email: document.getElementById("email").value,
            password: document.getElementById("password").value,
            dob: document.getElementById("dob").value,
            gender: document.getElementById("gender").value,
            avatar: document.getElementById("avatar").files[0], // Simulamos la subida de una imagen
        };

        // Validación de cambios
        if (updatedData.password && updatedData.password.length < 8) {
            alert("Si vas a cambiar la contraseña, debe tener al menos 8 caracteres.");
            return;
        }

        // Simulamos la actualización de datos
        localStorage.setItem("userProfile", JSON.stringify(updatedData));

        alert("Perfil actualizado exitosamente.");
        // Redirigir o actualizar la página después de la edición
        window.location.href = "dashboard.html";
    });
});

function togglePassword() {
    const passwordInput = document.getElementById('password');
    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
}
