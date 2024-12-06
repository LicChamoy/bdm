<?php
require 'conexion.php';

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

    // Leer el contenido del archivo de avatar en formato binario
    $avatar = NULL;
    if ($_FILES['avatar']['tmp_name']) {
        $avatar = file_get_contents($_FILES['avatar']['tmp_name']);
    }

    $conexionBD = new ConexionBD();
    $conexion = $conexionBD->obtenerConexion();
    
    // Preparar la consulta y definir los parámetros
    $stmt = $conexion->prepare("CALL RegisterUserOrManageUser(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $accion, $nombre, $apellidos, $genero, $fechaNacimiento, $email, $contrasena, $avatar, $rol, $resultado);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result) {
            $row = $result->fetch_assoc();
            $resultado = $row['resultado'] ?? '';

        header("Location: ../login.html"); // Redirigir a la página de login
        }
    }

    $stmt->close();
}

$conexionBD->cerrarConexion();
?>
