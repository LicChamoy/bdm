<?php
require 'conexion.php';

if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    echo "No se recibió ningún email.";
}

$conexionBD = new ConexionBD();
$conexion = $conexionBD->obtenerConexion();

// Llamada a la función ReactivateUser
$stmt = $conexion->prepare("SELECT ReactivateUser(?) AS result_message");
$stmt->bind_param("s", $email);

if ($stmt->execute()) {
    $stmt->bind_result($result_message);
    $stmt->fetch();

    echo "$result_message";
} else {
    echo "Error al intentar reactivar al usuario";
}

$stmt->close();
$conexionBD->cerrarConexion();
?>
