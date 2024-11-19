<?php
session_start();
require 'conexion.php';

$conexionBD = new ConexionBD();
$conexion = $conexionBD->obtenerConexion();

$email = $_POST['email'];
$password = $_POST['password'];
$accion = 'login'; // Acción para manejar inicio de sesión
$resultado = '';

// Intentar iniciar sesión
$stmt = $conexion->prepare("CALL RegisterUserOrManageUser(?, NULL, NULL, NULL, NULL, ?, ?, NULL, NULL, ?)");
$stmt->bind_param("sss", $accion, $email, $password, $resultado);

if ($stmt->execute()) {
    $stmt->bind_result($resultado);
    $stmt->fetch();

    if ($resultado === 'Inicio de sesión exitoso.') {
        // Limpiar intentos tras inicio exitoso
        $stmt_reset = $conexion->prepare("UPDATE usuarios SET intentos = 0 WHERE email = ?");
        $stmt_reset->bind_param("s", $email);
        $stmt_reset->execute();
        $stmt_reset->close();

        // Iniciar sesión
        $_SESSION['user_email'] = $email;
        echo "<script>alert('Inicio de sesión exitoso.'); window.location.href = '../perfil.php';</script>";
    } else {
        // Llamar a la función para manejar intentos fallidos
        $stmt_block = $conexion->prepare("SELECT CheckAndBlockUser(?) AS result_message");
        $stmt_block->bind_param("s", $email);

        if ($stmt_block->execute()) {
            $stmt_block->bind_result($block_message);
            $stmt_block->fetch();
            echo "<script>alert('$block_message'); window.history.back();</script>";
        } else {
            echo "<script>alert('Error al procesar el intento fallido.'); window.history.back();</script>";
        }

        $stmt_block->close();
    }
} else {
    echo "<script>alert('Error al procesar la solicitud.'); window.history.back();</script>";
}

$stmt->close();
$conexionBD->cerrarConexion();
?>
