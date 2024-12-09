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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin-top: 50px;
            font-size: 2em;
            color: #f1f1f1;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 30px;
        }
        textarea {
            background-color: #333;
            color: #f1f1f1;
            border: 1px solid #444;
            padding: 10px;
            border-radius: 8px;
            width: 80%;
            max-width: 600px;
            resize: none;
            font-size: 1em;
            line-height: 1.5;
        }
        textarea:focus {
            outline: none;
            border-color: #4caf50;
        }
        button {
            background-color: #4caf50;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #45a049;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .button-container button {
            background-color: #2196f3;
        }
        .button-container button:hover {
            background-color: #1e88e5;
        }
    </style>
</head>
<body>

    <h1>Enviar Mensaje al Instructor</h1>
    
    <div class="form-container">
        <form method="POST">
            <textarea name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí" required></textarea>
            <button type="submit">Enviar Mensaje</button>
        </form>
    </div>

    <div class="button-container">
        <button onclick="window.location.href='mensajes_entrantes.php';">Ver mis mensajes</button>
    </div>

</body>
</html>
