<?php
require 'conexion.php';

session_start();

// Verificar si hay usuario logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

var_dump($_POST);

$userId = $_SESSION['user_id'];
$idCurso = $_POST['idCurso'];
$textoComentario = $_POST['textoComentario'];
$calificacion = $_POST['calificacion'];


var_dump($_POST);
// Validar datos de entrada
if (!is_numeric($calificacion) || $calificacion < 1 || $calificacion > 5) {
    die(json_encode(["success" => false, "message" => "Calificación inválida."]));
}

if (empty(trim($textoComentario))) {
    die(json_encode(["success" => false, "message" => "El comentario no puede estar vacío."]));
}

$conexionBD = new ConexionBD();
$mysqli = $conexionBD->obtenerConexion();

try {
    // Llamar al procedimiento almacenado
    $stmt = $mysqli->prepare("CALL RegistrarComentarioCurso(?, ?, ?, ?)");
    $stmt->bind_param("iisi", $userId, $idCurso, $textoComentario, $calificacion);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Comentario registrado exitosamente."]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
} finally {
    $stmt->close();
    $conexionBD->cerrarConexion();
}
?>
