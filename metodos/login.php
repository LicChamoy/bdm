<?php
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
            header("Location: ../dashboard.html");
            exit;
        } else {
            echo "<script>alert('$resultado'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Error en la ejecución del procedimiento.'); window.history.back();</script>";
    }
}

// Cerrar la conexión
$conexionBD->cerrarConexion();
?>
