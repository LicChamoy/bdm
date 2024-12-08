<?php
require_once '../metodos/conexion.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Obtener el id del instructor (receptor del mensaje)
if (isset($_GET['idInstructor'])) {
    $idInstructor = intval($_GET['idInstructor']);
} else {
    echo "Error: No se proporcionó el ID del instructor.";
    exit;
}

// Función para enviar el mensaje
function enviarMensaje($idInstructor, $idAlumno, $mensaje) {
    $conexionBD = new ConexionBD();
    $conexion = $conexionBD->obtenerConexion();

    // Preparar la llamada al procedimiento almacenado
    $stmt = $conexion->prepare("CALL EnviarMensaje(?, ?, ?)");
    $stmt->bind_param("iis", $idInstructor, $idAlumno, $mensaje);

    if ($stmt->execute()) {
        echo "Mensaje enviado correctamente.";
    } else {
        echo "Error al enviar el mensaje: " . $stmt->error;
    }

    // Cerrar la conexión
    $stmt->close();
    $conexionBD->cerrarConexion();
}

// Procesar el envío de mensajes si se envía un POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mensaje = $_POST['mensaje'];
    $idAlumno = $_SESSION['user_id'];
    enviarMensaje($idInstructor, $idAlumno, $mensaje);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Mensaje al Instructor</title>
</head>
<body>
    <h1>Enviar Mensaje al Instructor</h1>
    <form method="POST">
        <textarea name="mensaje" rows="5" cols="50" placeholder="Escribe tu mensaje aquí" required></textarea>
        <br>
        <button type="submit">Enviar Mensaje</button>
    </form>

    <!-- Botón para ver los mensajes -->
    <button onclick="window.location.href='mensajes_entrantes.php';">Ver mis mensajes</button>
</body>
</html>
