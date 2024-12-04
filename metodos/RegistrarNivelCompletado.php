<?php
require 'conexion.php';

$userId = $_SESSION['user_id'];
$idNivel = $_POST['idNivel'];
$idCurso = $_POST['idCurso'];

$conexionBD = new ConexionBD();
$mysqli = $conexionBD->obtenerConexion();

try {
    // Llamar al procedimiento almacenado para registrar el nivel completado
    $stmt = $mysqli->prepare("CALL RegistrarNivelCompletado(?, ?)");
    $stmt->bind_param("ii", $userId, $idNivel);
    $stmt->execute();

    // Llamar al procedimiento para actualizar el progreso
    $stmt = $mysqli->prepare("CALL ActualizarProgreso(?, ?)");
    $stmt->bind_param("ii", $userId, $idCurso);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Progreso actualizado."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $stmt->close();
    $conexionBD->cerrarConexion();
}
?>
