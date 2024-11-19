<?php
// conexion.php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['category-name'];
    $descripcion = $_POST['category-description'];
    $idCreador = $_POST['user_id'];  // Asegúrate de que este ID venga del usuario autenticado o una sesión.

    $conexionBD = new ConexionBD();
    $conexion = $conexionBD->obtenerConexion();

    // Llamar al procedimiento almacenado
    $query = "CALL registrar_categoria(?, ?, ?)";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('ssi', $nombre, $descripcion, $idCreador); // 'ssi' es para string, string, int

    if ($stmt->execute()) {
        echo "Categoría registrada con éxito";
    } else {
        echo "Error al registrar la categoría: " . $stmt->error;
    }

    $stmt->close();
    $conexionBD->cerrarConexion();
}
?>
