<?php
session_start();

require 'conexion.php';

$conexionBD = new ConexionBD();
$conexion = $conexionBD->obtenerConexion();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$nombres = $_POST['name'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$fechaNacimiento = $_POST['dob'];
$contrasena = $_POST['password'];
$genero = $_POST['gender'];
$avatar = NULL;
$resultado = '';

$accion = 'actualizar';
$rol = NULL;

if ($contrasena === '') {
    $contrasena = null;
}

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
    $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
}

$stmt = $conexion->prepare("CALL RegisterUserOrManageUser(?, ?, ?, ?, ?, ?, ?, ?, NULL, ?)");
$stmt->bind_param("sssssssss", $accion, $nombres, $apellidos, $genero, $fechaNacimiento, $email, $contrasena, $avatar, $resultado);

if ($stmt->execute()) {
    if ($resultado === 'Actualización exitosa.') {
        $_SESSION['user_nombre'] = $nombres;
        $_SESSION['user_apellidos'] = $apellidos;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_fechaNacimiento'] = $fechaNacimiento;
        $_SESSION['user_genero'] = $genero;
        
        if ($avatar !== NULL) {
            $_SESSION['user_avatar'] = base64_encode($avatar);
        }

        header("Location: ../perfil.php?success=1");
    } else {
        echo "<script>alert('$resultado'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Error en la ejecución del procedimiento.'); window.history.back();</script>";
}

$stmt->close();
$conexionBD->cerrarConexion();
