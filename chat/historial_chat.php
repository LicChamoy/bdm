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

    // Preparar la llamada al procedimiento almacenado
    $stmt = $conexion->prepare("CALL ObtenerMensajesChat(?)");
    $stmt->bind_param("i", $chat_id);
    
    // Ejecutar el procedimiento
    $stmt->execute();
    
    // Obtener el resultado
    $result = $stmt->get_result();
    $mensajes = $result->fetch_all(MYSQLI_ASSOC);

    // Cerrar la conexión
    $stmt->close();
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
        <style>
            body {
                background-color: #121212;
                color: #e0e0e0;
                font-family: Arial, sans-serif;
            }

            h1 {
                text-align: center;
                color: #fff;
                margin-bottom: 20px;
            }

            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                background-color: #1c1c1c;
                border-radius: 10px;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            }

            .mensajes {
                list-style-type: none;
                padding: 0;
            }

            .mensaje {
                border-bottom: 1px solid #444;
                padding: 10px 0;
            }

            .mensaje p {
                margin: 5px 0;
                font-size: 14px;
                color: #b5b5b5;
            }

            .mensaje strong {
                color: #76c7c0;
            }

            .timestamp {
                font-size: 12px;
                color: #888;
            }

            textarea {
                width: 100%;
                padding: 10px;
                margin-top: 10px;
                background-color: #333;
                color: #fff;
                border: 1px solid #444;
                border-radius: 5px;
                resize: none;
            }

            button {
                background-color: #76c7c0;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                margin-top: 10px;
                cursor: pointer;
            }

            button:hover {
                background-color: #66b1b0;
            }

            .back-button {
                display: inline-block;
                padding: 10px 20px;
                margin-top: 20px;
                background-color: #76c7c0;
                color: #fff;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
            }

            .back-button:hover {
                background-color: #66b1b0;
            }
        </style>

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
                <a href="mensajes_entrantes.php" class="back-button">Volver a mis mensajes</a>
            </div>
        </div>
    </body>
</html>
