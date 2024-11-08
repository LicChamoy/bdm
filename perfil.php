<?php
session_start(); // Iniciar sesión

if (!isset($_SESSION['user_email'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_nombre = $_SESSION['user_nombre'];
$user_apellidos = $_SESSION['user_apellidos'];
$user_genero = $_SESSION['user_genero'];
$user_fechaNacimiento = $_SESSION['user_fechaNacimiento'];
$user_rol = $_SESSION['user_rol'];
$user_avatar = $_SESSION['user_avatar'];
$user_email = $_SESSION['user_email'];

if ($user_avatar) {
    $avatar_base64 = base64_encode($user_avatar);
    $avatar_data = "data:image/jpeg;base64," . $avatar_base64;
} else {
    $avatar_data = '';  // No hay avatar
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Editar Perfil</title>
        <link rel="stylesheet" href="css/perfil.css">
    </head>
    <body>
        <header>
            <h1>Editar Perfil</h1>
        </header>

        <main>
            <div class="message">
                <p>Edita tu información y mantén tu perfil actualizado en <strong>Judav Academy</strong>.</p>
            </div>

            <form id="editProfileForm" action="metodos/updatePerfil.php" method="POST" enctype="multipart/form-data">
                <label for="name">Nombre(s):</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user_nombre); ?>" required>

                <label for="apellidos">Apellidos:</label>
                <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($user_apellidos); ?>" required>

                <label for="email">Correo Electrónico:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_email); ?>" required>

                <label for="password">Nueva Contraseña:</label>
                <input type="password" id="password" name="password">
                <small>Deja el campo vacío si no deseas cambiar la contraseña.</small>

                <label for="dob">Fecha de Nacimiento:</label>
                <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($user_fechaNacimiento); ?>" required>

                <label for="gender">Género:</label>
                <select id="gender" name="gender" required>
                    <option value="hombre" <?php echo ($user_genero == 'hombre') ? 'selected' : ''; ?>>Masculino</option>
                    <option value="mujer" <?php echo ($user_genero == 'mujer') ? 'selected' : ''; ?>>Femenino</option>
                    <option value="otro" <?php echo ($user_genero == 'otro') ? 'selected' : ''; ?>>Otro</option>
                </select>

                <label for="avatar">Subir Foto:</label>
                <input type="file" id="avatar" name="avatar" accept="image/*" onchange="previewAvatar(event)">

                <div id="avatar-preview-container">
                    <?php if ($avatar_data): ?>
                        <img id="avatar-preview" src="<?php echo $avatar_data; ?>" alt="Avatar Actual" style="max-width: 150px; max-height: 150px;">
                    <?php else: ?>
                        <p>No tienes avatar.</p>
                    <?php endif; ?>
                </div>

                <label for="role">Rol:</label>
                <select id="role" name="role" required disabled>
                    <option value="student" <?php echo ($user_rol == 'student') ? 'selected' : ''; ?>>Estudiante</option>
                    <option value="instructor" <?php echo ($user_rol == 'instructor') ? 'selected' : ''; ?>>Instructor</option>
                    <option value="admin" <?php echo ($user_rol == 'admin') ? 'selected' : ''; ?>>Administrador</option>
                </select>

                <button type="submit">Guardar Cambios</button>
            </form>

            <p><a href="dashboard.html">Volver al Dashboard</a></p>
        </main>

        <script>
            // Función para mostrar la vista previa de la nueva imagen de avatar
            function previewAvatar(event) {
                const file = event.target.files[0];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const avatarPreview = document.getElementById('avatar-preview');
                    avatarPreview.src = e.target.result; // Establecer la nueva imagen
                }

                if (file) {
                    reader.readAsDataURL(file); // Leer la imagen seleccionada
                }
            }
        </script>

    </body>
</html>
