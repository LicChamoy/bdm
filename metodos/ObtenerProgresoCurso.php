<?php
require 'conexion.php';

$conexionBD = new ConexionBD();
$mysqli = $conexionBD->obtenerConexion();

// Parámetros
$userId = $_SESSION['user_id'];
$cursoId = $_GET['idCurso'];

// Llamada al procedimiento almacenado
$query = "CALL ObtenerProgresoCurso(?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('ii', $userId, $cursoId);
$stmt->execute();

$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    echo "Curso: " . $cursoId . "<br>";
    echo "Niveles completados: " . $row['nivelesCompletados'] . "/" . $row['totalNiveles'] . "<br>";
    echo "Progreso: " . $row['progresoPorcentaje'] . "%<br>";
} else {
    echo "No se encontró información del progreso para este curso.";
}

$stmt->close();
$conexionBD->cerrarConexion();
?>
