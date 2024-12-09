<?php
// Iniciar sesión y requerir la conexión
session_start();
require_once 'metodos/conexion.php';

// Conexión a la base de datos
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Obtener el ID del nivel desde los parámetros GET
$idNivel = isset($_GET['nivel']) ? (int)$_GET['nivel'] : 0;

if ($idNivel <= 0) {
    die("ID de nivel inválido.");
}

$idCurso = isset($_GET['curso']) ? (int)$_GET['curso'] : 0;

if ($idCurso <= 0) {
    die("ID de curso no válido.");
}

// Llamar al procedimiento almacenado para obtener la información del nivel
$stmtNivel = $mysqli->prepare("CALL ObtenerInformacionNivel(?)");

if (!$stmtNivel) {
    die("Error al preparar la consulta: " . $mysqli->error);
}

$stmtNivel->bind_param("i", $idNivel);
$stmtNivel->execute();
$resultado = $stmtNivel->get_result();

// Validar si el nivel existe
if ($resultado->num_rows === 0) {
    die("El nivel especificado no existe.");
}

// Asignar los valores del resultado
$nivel = $resultado->fetch_assoc();
$stmtNivel->close();

// Asignar los valores a las variables
$titulo = htmlspecialchars($nivel['titulo_nivel']);
$descripcion = htmlspecialchars($nivel['descripcion_nivel']);
$urlVideo = htmlspecialchars($nivel['url_video']);

// Construir la URL completa del video si es necesario
$urlBase = 'http://localhost/bdm/metodos/';
if (strpos($urlVideo, 'http') !== 0) {
    $urlVideo = $urlBase . $urlVideo;
}

// Cerrar la conexión
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="css/ver_video.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Video - <?php echo $titulo; ?></title>
</head>
<body>
    <h1><?php echo $titulo; ?></h1>
    <p><?php echo $descripcion; ?></p>

    <?php if (!empty($urlVideo)) : ?>
        <video controls width="800">
            <source src="<?php echo $urlVideo; ?>" type="video/mp4">
            Tu navegador no soporta el elemento de video.
        </video>
    <?php else : ?>
        <p>El video no está disponible para este nivel.</p>
    <?php endif; ?>

    <form action="metodos/RegistrarNivelCompletado.php" method="POST">
        <input type="hidden" name="idNivel" value="<?php echo $idNivel; ?>">
        <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>">
        <button type="submit">Marcar este nivel como Completado</button>
    </form>
    <a href="metodos/dashboard-docente.php" class="btn">Dashboard</a>
</body>
</html>
