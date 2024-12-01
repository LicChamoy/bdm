<?php
// Iniciar sesión y requerir la conexión
session_start();
require_once 'metodos/conexion.php';

// Conexión a la base de datos
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Obtener el ID del nivel desde los parámetros GET
$idNivel = isset($_GET['nivel']) ? (int)$_GET['nivel'] : 0;

var_dump($idNivel);

if ($idNivel <= 0) {
    die("ID de nivel inválido.");
}

// Consulta para obtener la información del nivel desde la vista
$queryNivel = "SELECT titulo_nivel, descripcion_nivel, url_video 
               FROM vistavervideo 
               WHERE idNivel = ?";
$stmtNivel = $mysqli->prepare($queryNivel);

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

// Depuración de la URL del video
var_dump($nivel['url_video']);

// Asignar los valores a las variables
$titulo = htmlspecialchars($nivel['titulo_nivel']);
$descripcion = htmlspecialchars($nivel['descripcion_nivel']);
$urlVideo = htmlspecialchars($nivel['url_video']);

// Construir la URL completa del video si es necesario
$urlBase = 'http://localhost/bdm/metodos/';
if (strpos($urlVideo, 'http') !== 0) {
    $urlVideo = $urlBase . $urlVideo;  // Si no tiene el prefijo, se agrega
}

// Cerrar la conexión
$stmtNivel->close();
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
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

</body>
</html>
