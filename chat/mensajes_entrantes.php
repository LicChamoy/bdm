<?php
require_once '../metodos/conexion.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../metodos/login.php");
    exit;
}

$usuario_id = intval($_SESSION['user_id']); // ID del usuario autenticado

function obtenerChats($usuario_id) {
    $conexionBD = new ConexionBD();
    $conexion = $conexionBD->obtenerConexion();

    // Consulta para obtener chats donde el usuario es el emisor o receptor
    $stmt = $conexion->prepare("
        SELECT DISTINCT 
            IF(c.idEmisor = ?, c.idReceptor, c.idEmisor) AS otro_usuario_id,
            u.nombre, u.apellidos, idChat
        FROM chat c
        INNER JOIN usuarios u ON u.idUsuario = IF(c.idEmisor = ?, c.idReceptor, c.idEmisor)
        WHERE c.idEmisor = ? OR c.idReceptor = ?
    ");
    $stmt->bind_param("iiii", $usuario_id, $usuario_id, $usuario_id, $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $chats = [];
    while ($row = $result->fetch_assoc()) {
        $chats[] = $row;
    }

    $conexionBD->cerrarConexion();

    return $chats;
}

function obtenerUltimoMensaje($usuario_id, $otro_usuario_id) {
    $conexionBD = new ConexionBD();
    $conexion = $conexionBD->obtenerConexion();

    // Obtener el chat_id entre los dos usuarios
    $stmt_chat = $conexion->prepare("
        SELECT idChat 
        FROM chat 
        WHERE (idEmisor = ? AND idReceptor = ?) OR (idEmisor = ? AND idReceptor = ?)
    ");
    $stmt_chat->bind_param("iiii", $usuario_id, $otro_usuario_id, $otro_usuario_id, $usuario_id);
    $stmt_chat->execute();
    $result_chat = $stmt_chat->get_result();
    $chat = $result_chat->fetch_assoc();
    
    if ($chat) {
        $chat_id = $chat['idChat'];
        
        // Obtener el último mensaje en el chat
        $stmt = $conexion->prepare("
            SELECT contenido, timestamp
            FROM mensaje
            WHERE chat_id = ?
            ORDER BY timestamp DESC
            LIMIT 1
        ");
        $stmt->bind_param("i", $chat_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $ultimo_mensaje = $result->fetch_assoc();
        $conexionBD->cerrarConexion();

        return $ultimo_mensaje ? $ultimo_mensaje['contenido'] : "No hay mensajes en este chat.";
    } else {
        $conexionBD->cerrarConexion();
        return "No hay chat.";
    }
}

$chats = obtenerChats($usuario_id);
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Chats</title>
        <link rel="stylesheet" href="../styles/lista_chats.css">
    </head>
    <body>
        <style>
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
            }

            .chat {
                border-bottom: 1px solid #ccc;
                padding: 10px;
            }

            .chat a {
                text-decoration: none;
                color: #333;
                font-weight: bold;
            }

            .chat p {
                margin: 5px 0;
                font-size: 14px;
            }

            .chats {
                list-style-type: none;
                padding: 0;
            }
        </style>

        <h1>Lista de Chats</h1>
        <div class="container">
            <div class="chats">
                <?php foreach ($chats as $chat): ?>
                    <div class="chat">
                    <p><a href="historial_chat.php?chat_id=<?php echo $chat['idChat']; ?>">
                        <?php echo $chat['nombre'] . " " . $chat['apellidos']; ?></a></p>
                    <p>
                            <?php 
                                $ultimo_mensaje = obtenerUltimoMensaje($usuario_id, $chat['otro_usuario_id']);
                                echo htmlspecialchars($ultimo_mensaje);
                            ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="../metodos/dashboard-docente.php">Volver al dashboard</a>
        </div>
    </body>
</html>
