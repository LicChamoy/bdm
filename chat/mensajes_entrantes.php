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

    // Preparar y ejecutar el procedimiento almacenado
    $stmt = $conexion->prepare("CALL ObtenerChats(?)");
    $stmt->bind_param("i", $usuario_id);
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

    // Preparar y ejecutar el procedimiento almacenado
    $stmt = $conexion->prepare("CALL ObtenerUltimoMensaje(?, ?)");
    $stmt->bind_param("ii", $usuario_id, $otro_usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $ultimo_mensaje = $result->fetch_assoc();
    $conexionBD->cerrarConexion();

    return $ultimo_mensaje ? $ultimo_mensaje['contenido'] : "No hay mensajes en este chat.";
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

            .chat {
                border-bottom: 1px solid #444;
                padding: 10px 0;
            }

            .chat a {
                text-decoration: none;
                color: #76c7c0;
                font-weight: bold;
                font-size: 16px;
            }

            .chat a:hover {
                color: #b5e1e1;
            }

            .chat p {
                margin: 5px 0;
                font-size: 14px;
                color: #b5b5b5;
            }

            .chats {
                list-style-type: none;
                padding: 0;
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
            <a href="../metodos/dashboard-docente.php" class="back-button">Volver al dashboard</a>
        </div>
    </body>
</html>
