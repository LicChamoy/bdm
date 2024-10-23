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
    $contrasena = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['role'];

    $avatar = NULL;
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == UPLOAD_ERR_OK) {
        $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
    }

    $stmt = $conexion->prepare("CALL RegisterUser(?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nombre, $apellidos, $genero, $fechaNacimiento, $email, $contrasena, $avatar, $rol);

    if ($stmt->execute()) {
        header("Location: ../login.html");
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
}

$conexionBD->cerrarConexion();