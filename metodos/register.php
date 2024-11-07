<?php
require 'conexion.php';

$conexionBD = new ConexionBD();
$conexion = $conexionBD->obtenerConexion();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['name'];
    $apellidos = $_POST['apellido'];
    $genero = $_POST['gender'];
    $fechaNacimiento = $_POST['dob'];
    $email = $_POST['email'];
    $contrasena = $_POST['password'];
    $rol = $_POST['role'];
    $accion = 'registrar';
    $resultado = '';

    $avatar = NULL;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
    }

    $stmt = $conexion->prepare("CALL RegisterUserOrManageUser(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssbss", $accion, $nombre, $apellidos, $genero, $fechaNacimiento, $email, $contrasena, $avatar, $rol, $resultado);

    if ($stmt->execute()) {
        $stmt->bind_result($resultado);
        $stmt->fetch();

        if ($resultado === 'Registro exitoso.') {
            header("Location: ../login.html"); // Redirigir a la página de login
        } else {
            echo "<script>alert('$resultado'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error en la ejecución del procedimiento.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conexionBD->cerrarConexion();
?>
