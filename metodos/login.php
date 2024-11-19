<?php
session_start(); // Iniciar sesión

require 'conexion.php';

$conexionBD = new ConexionBD();
$conexion = $conexionBD->obtenerConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $accion = 'login';
    $email = $_POST['email'];
    $password = $_POST['password'];
    $resultado = '';

    // Verificar si los intentos para este correo están en la cookie
    $intentos = 0;
    if (isset($_COOKIE['intentos'])) {
        $intentos_data = unserialize($_COOKIE['intentos']); // Deserializar la cookie
        // Verificar si el correo existe en la cookie
        if (isset($intentos_data[$email])) {
            $intentos = $intentos_data[$email];
        }
    }

    // Si el número de intentos ha alcanzado el límite, bloquear el acceso
    if ($intentos >= 3) {
        echo "<script>alert('Has alcanzado el límite de intentos para este correo.'); window.history.back();</script>";
        exit();
    }

    // Preparar el procedimiento almacenado
    $stmt = $conexion->prepare("CALL RegisterUserOrManageUser(?, NULL, NULL, NULL, NULL, ?, ?, NULL, NULL, ?)");
    $stmt->bind_param("ssss", $accion, $email, $password, $resultado);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $resultado = $row['resultado'];

        if ($resultado === 'Inicio de sesión exitoso.') {
            // Limpiar intentos tras inicio exitoso
            if (isset($_COOKIE['intentos'])) {
                $intentos_data = unserialize($_COOKIE['intentos']);
                unset($intentos_data[$email]); // Eliminar el correo del registro de intentos
                setcookie('intentos', serialize($intentos_data), time() + 3600); // Actualizar la cookie
            }

            // Guardar la información del usuario en la sesión
            $_SESSION['user_id'] = $row['idUsuario'];
            $_SESSION['user_nombre'] = $row['nombre'];
            $_SESSION['user_apellidos'] = $row['apellidos'];
            $_SESSION['user_genero'] = $row['genero'];
            $_SESSION['user_fechaNacimiento'] = $row['fechaNacimiento'];
            $_SESSION['user_rol'] = $row['rol'];
            $_SESSION['user_avatar'] = $row['avatar'];
            $_SESSION['user_email'] = $email;

            // Verificar si el rol es de administrador
            if ($_SESSION['user_rol'] == 'admin') {
                // Redirigir a la página de administrador
                header("Location: /admin/vistaAdmin.html");
                exit;
            } else {
                // Si no es admin, redirigir a la página principal del usuario
                header("Location: ../dashboard.html");
                exit;
            }
        } else {
            // Incrementar los intentos fallidos y guardar en la cookie
            $intentos_data = isset($_COOKIE['intentos']) ? unserialize($_COOKIE['intentos']) : [];
            $intentos_data[$email] = isset($intentos_data[$email]) ? $intentos_data[$email] + 1 : 1;

            // Guardar los intentos actualizados en la cookie (1 hora de duración)
            setcookie('intentos', serialize($intentos_data), time() + 3600);

            echo "<script>alert('$resultado'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error en la ejecución del procedimiento.'); window.history.back();</script>";
    }

    $stmt->close();
}

// Cerrar la conexión
$conexionBD->cerrarConexion();
?>
