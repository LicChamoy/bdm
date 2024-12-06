<?php
require_once '../metodos/conexion.php';

session_start();

if (isset($_GET['chat_id'])) {
    $chat_id = intval($_GET['chat_id']);
} else {
    echo "Error: No se proporcionó el ID del chat.";
    exit;
}

function obtenerMensajesChat($chat_id) {
    $conexionBD = new ConexionBD();
    $conexion = $conexionBD->obtenerConexion();

    // Consulta para obtener los mensajes entre el usuario actual y el otro usuario
    $stmt = $conexion->prepare(
        "SELECT m.contenido AS contenido, u.nombre AS usuario, m.timestamp AS timestamp
         FROM mensaje m
         JOIN usuarios u ON m.idAutor = u.idUsuario
         WHERE m.chat_id = ?
         ORDER BY m.timestamp"
    );
    
    $stmt->bind_param("i", $chat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $mensajes = $result->fetch_all(MYSQLI_ASSOC);

    $conexionBD->cerrarConexion();

    return $mensajes;
}

$mensajes = obtenerMensajesChat($chat_id);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Historial de Chat</title>
        <link rel="stylesheet" href="historial_chat.css">
    </head>
    <body>
        <div class="container">
            <h1>Historial de Chat</h1>
            <div class="mensajes">
                <?php foreach ($mensajes as $mensaje): ?>
                    <div class="mensaje">
                        <p><strong><?php echo htmlspecialchars($mensaje['usuario']); ?>:</strong> <?php echo htmlspecialchars($mensaje['contenido']); ?></p>
                        <p class="timestamp"><?php echo $mensaje['timestamp']; ?></p>
                    </div>
                <?php endforeach; ?>
                <form action="enviar_mensaje.php" method="POST">
                    <input type="hidden" name="chat_id" value="<?php echo $chat_id; ?>">
                    <input type="hidden" name="idEmisor" value="<?php echo $_SESSION['user_id']; ?>">
                    <textarea name="texto" rows="3" placeholder="Escribe tu mensaje aquí" required></textarea>
                    <button type="submit">Enviar Mensaje</button>
                </form>
                <a href="mensajes_entrantes.php">Volver a mis mensajes</a>
            </div>
        </div>
    </body>
</html>
