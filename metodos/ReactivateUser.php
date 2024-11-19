<?php
require 'conexion.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    echo "No se recibió ningún email.";
}

$conexionBD = new ConexionBD();
$conexion = $conexionBD->obtenerConexion();

// Llamar al procedimiento almacenado ReactivateUser
$stmt = $conexion->prepare("CALL ReactivateUser(?)");
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    // Obtener el resultado
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $result_message = $row['result_message'];
        echo "<script>alert('$result_message'); window.history.back();</script>";
    } else {
        echo "<script>alert('No se recibió un mensaje de respuesta.'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Error al ejecutar el procedimiento.'); window.history.back();</script>";
}

$stmt->close();
$conexionBD->cerrarConexion();
?>
