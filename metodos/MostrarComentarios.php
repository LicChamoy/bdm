<?php
require 'conexion.php';

$conexionBD = new ConexionBD();
$mysqli = $conexionBD->obtenerConexion();

$cursoId = $_GET['idCurso'];

// Llamada al procedimiento almacenado
$query = "CALL ObtenerComentariosCurso(?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $cursoId);
$stmt->execute();

$result = $stmt->get_result();
$comentarios = [];

while($row = $result->fetch_assoc()){
    $comentarios[] = $row;

}

$stmt->close();
$conexionBD->cerrarConexion();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <h1>Comentarios del curso</h1>
        <?php if (count($comentarios) > 0): ?>
            <ul>
                <?php foreach ($comentarios as $comentario): ?>
                <li>
                    <strong>Usuario:</strong> <?= htmlspecialchars($comentario['nombreUsuario'])?> <br>
                    <strong>Calificacion:</strong> <?= htmlspecialchars($comentario['calificacion'])?> <br>
                    <strong>Fecha:</strong> <?= htmlspecialchars($comentario['fechaComentario'])?> <br>
                    <strong>Comentario</strong> <?= htmlspecialchars($comentario['textoComentrio'])?> <br>
                </li>
                <hr>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p>No hay comentarios disponibles para este curso</p>
            <?php endif ?>
    </body>
</html>
