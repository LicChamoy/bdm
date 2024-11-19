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

    $stmt = $conexion->prepare("CALL RegisterUserOrManageUser(?, NULL, NULL, NULL, NULL, ?, ?, NULL, NULL, ?)");
    $stmt->bind_param("ssss", $accion, $email, $password, $resultado);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $resultado = $row['resultado'];

        if ($resultado === 'Inicio de sesión exitoso.') {

            $_SESSION['user_id'] = $row['idUsuario'];
            $_SESSION['user_nombre'] = $row['nombre'];
            $_SESSION['user_apellidos'] = $row['apellidos'];
            $_SESSION['user_genero'] = $row['genero'];
            $_SESSION['user_fechaNacimiento'] = $row['fechaNacimiento'];
            $_SESSION['user_rol'] = $row['rol'];
            $_SESSION['user_avatar'] = $row['avatar'];
            $_SESSION['user_email'] = $email;

            header("Location: ../dashboard-cursos.php");
            exit;
        } else {
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
