<?php
session_start();
require_once 'metodos/conexion.php';

// Verificar si hay un usuario logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: metodos/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Obtener el ID del instructor y del curso
if (!isset($_GET['idInstructor']) || !isset($_GET['idCurso'])) {
    header("Location: metodos/dashboard-docente.php");
    exit;
}

$idInstructor = intval($_GET['idInstructor']);
$idCurso = intval($_GET['idCurso']);

// Conexión a la base de datos
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Obtener los mensajes entre el usuario e instructor
$queryMensajes = "SELECT m.*, u.nombre AS emisorNombre, u.apellidos AS emisorApellido 
                  FROM mensajes m
                  JOIN usuarios u ON m.idEmisor = u.idUsuario
                  WHERE (m.idEmisor = ? AND m.idReceptor = ?)
                     OR (m.idEmisor = ? AND m.idReceptor = ?)
                  ORDER BY m.fecha ASC";
$stmtMensajes = $mysqli->prepare($queryMensajes);
$stmtMensajes->bind_param("iiii", $userId, $idInstructor, $idInstructor, $userId);
$stmtMensajes->execute();
$mensajes = $stmtMensajes->get_result();

// Procesar el envío de un nuevo mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensaje'])) {
    $mensajeTexto = trim($_POST['mensaje']);
    if ($mensajeTexto) {
        $queryEnviar = "INSERT INTO mensajes (idEmisor, idReceptor, texto) VALUES (?, ?, ?)";
        $stmtEnviar = $mysqli->prepare($queryEnviar);
        $stmtEnviar->bind_param("iis", $userId, $idInstructor, $mensajeTexto);
        $stmtEnviar->execute();
        header("Location: chat.php?idInstructor=$idInstructor&idCurso=$idCurso");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Chat con el Instructor</title>
    <style>
        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .mensaje {
            margin-bottom: 15px;
        }
        .mensaje-propio {
            text-align: right;
        }
        .mensaje-instructor {
            text-align: left;
        }
        .form-mensaje {
            display: flex;
            margin-top: 20px;
        }
        .form-mensaje textarea {
            flex: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }
        .form-mensaje button {
            padding: 10px 20px;
            background-color: #2c5282;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-mensaje button:hover {
            background-color: #2a4365;
        }
    </style>
</head>
<body>
    <div class="chat-container">
        <h2>Chat con el Instructor</h2>
        <div class="mensajes">
            <?php while ($mensaje = $mensajes->fetch_assoc()): ?>
                <div class="mensaje <?php echo $mensaje['idEmisor'] == $userId ? 'mensaje-propio' : 'mensaje-instructor'; ?>">
                    <strong><?php echo htmlspecialchars($mensaje['emisorNombre'] . ' ' . $mensaje['emisorApellido']); ?>:</strong>
                    <p><?php echo htmlspecialchars($mensaje['texto']); ?></p>
                    <small><?php echo htmlspecialchars($mensaje['fecha']); ?></small>
                </div>
            <?php endwhile; ?>
        </div>

        <form method="POST" class="form-mensaje">
            <textarea name="mensaje" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
