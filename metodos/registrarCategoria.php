<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['category-name'] ?? null;
    $descripcion = $_POST['category-description'] ?? null;
    $idCreador = $_POST['user_id'] ?? null;

    if (!$nombre || !$idCreador) {
        echo "Faltan datos para registrar la categoría.";
        exit;
    }

    $conexionBD = new ConexionBD();
    $conexion = $conexionBD->obtenerConexion();

    // Llamada al procedimiento almacenado o consulta para registrar la categoría
    $stmt = $conexion->prepare("CALL registrar_categoria(?, ?, ?)");
    $stmt->bind_param("ssi", $nombre, $descripcion, $idCreador);

    if ($stmt->execute()) {
        echo "Categoría registrada con éxito.";
    } else {
        echo "Error al registrar la categoría: " . $conexion->error;
    }

    $stmt->close();
    $conexionBD->cerrarConexion();
}
?>
