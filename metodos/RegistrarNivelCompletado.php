<?php
session_start(); // Habilitar acceso a $_SESSION
require 'conexion.php';

// Validar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Usuario no autenticado."]);
    exit;
}

$userId = $_SESSION['user_id'];

// Validar entrada de datos
$idNivel = isset($_POST['idNivel']) ? (int)$_POST['idNivel'] : 0;
$idCurso = isset($_POST['idCurso']) ? (int)$_POST['idCurso'] : 0;

if ($idNivel <= 0 || $idCurso <= 0) {
    echo json_encode(["success" => false, "message" => "Datos inválidos."]);
    var_dump($_POST); // Agrega esta línea para depurar los datos enviados
    exit;
}

// Continuar si los datos son válidos
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
    header("Location: ../mis_cursos.php");

} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $stmt->close();
    $conexionBD->cerrarConexion();
}
?>
