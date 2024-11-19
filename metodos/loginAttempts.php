<?php
session_start();
require 'conexion.php';

$conexionBD = new ConexionBD();
$conexion = $conexionBD->obtenerConexion();

$email = $_POST['email'];
$password = $_POST['password'];
$accion = 'login'; // Acción para manejar inicio de sesión
$resultado = '';

// Verificar intentos previos en la cookie
if (isset($_COOKIE['intentos']) && $_COOKIE['intentos'] >= 3) {
    echo "<script>alert('Has alcanzado el límite de intentos.'); window.history.back();</script>";
    exit();
}

// Intentar iniciar sesión
$stmt = $conexion->prepare("CALL RegisterUserOrManageUser(?, NULL, NULL, NULL, NULL, ?, ?, NULL, NULL, ?)");
$stmt->bind_param("sss", $accion, $email, $password, $resultado);

if ($stmt->execute()) {
    $stmt->bind_result($resultado);
    $stmt->fetch();

    if ($resultado === 'Inicio de sesión exitoso.') {
        // Limpiar intentos tras inicio exitoso
        setcookie('intentos', 0, time() - 3600); // Eliminar la cookie de intentos

        // Iniciar sesión
        $_SESSION['user_email'] = $email;
        echo "<script>alert('Inicio de sesión exitoso.'); window.location.href = '../perfil.php';</script>";
    } else {
        // Si el inicio de sesión falló, incrementamos los intentos
        if (isset($_COOKIE['intentos'])) {
            $intentos = $_COOKIE['intentos'] + 1;
        } else {
            $intentos = 1;
        }

        // Guardamos la cantidad de intentos en la cookie
        setcookie('intentos', $intentos, time() + 3600); // Válida durante 1 hora

        if ($intentos >= 3) {
            echo "<script>alert('Usuario bloqueado tras 3 intentos fallidos.'); window.history.back();</script>";
        } else {
            echo "<script>alert('Intento fallido $intentos de 3.'); window.history.back();</script>";
        }
    }
} else {
    echo "<script>alert('Error al procesar la solicitud.'); window.history.back();</script>";
}

$stmt->close();
$conexionBD->cerrarConexion();
