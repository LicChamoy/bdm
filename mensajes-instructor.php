<?php
session_start();
require_once 'metodos/conexion.php';

// Verificar si hay un usuario logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: metodos/login.php");
    exit;
}

// Verificar que el usuario sea un instructor
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'instructor') {
    header("Location: metodos/dashboard-docente.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Conexión a la base de datos
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Obtener lista de conversaciones (alumnos que han enviado mensajes)
$queryConversaciones = "
    SELECT DISTINCT 
        u.idUsuario, CONCAT(u.nombre, ' ', u.apellido) AS alumnoNombre, c.titulo AS cursoTitulo
    FROM mensajes m
    JOIN usuarios u ON u.idUsuario = m.idEmisor
    JOIN cursos c ON c.idInstructor = m.idReceptor
    WHERE m.idReceptor = ?
    ORDER BY alumnoNombre ASC";
$stmtConversaciones = $mysqli->prepare($queryConversaciones);
$stmtConversaciones->bind_param("i", $userId);
$stmtConversaciones->execute();
$conversaciones = $stmtConversaciones->get_result();

// Mostrar mensajes de un alumno si se selecciona
$mensajes = [];
if (isset($_GET['idAlumno'])) {
    $idAlumno = intval($_GET['idAlumno']);
    $queryMensajes = "
        SELECT m.*, u.nombre AS emisorNombre, u.apellido AS emisorApellido 
        FROM mensajes m
        JOIN usuarios u ON m.idEmisor = u.idUsuario
        WHERE (m.idEmisor = ? AND m.idReceptor = ?)
           OR (m.idEmisor = ? AND m.idReceptor = ?)
        ORDER BY m.fecha ASC";
    $stmtMensajes = $mysqli->prepare($queryMensajes);
    $stmtMensajes->bind_param("iiii", $idAlumno, $userId, $userId, $idAlumno);
    $stmtMensajes->execute();
    $mensajes = $stmtMensajes->get_result();
}

// Enviar un mensaje
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensaje']) && isset($_POST['idAlumno'])) {
    $mensajeTexto = trim($_POST['mensaje']);
    $idAlumno = intval($_POST['idAlumno']);
    if ($mensajeTexto) {
        $queryEnviar = "INSERT INTO mensajes (idEmisor, idReceptor, texto) VALUES (?, ?, ?)";
        $stmtEnviar = $mysqli->prepare($queryEnviar);
        $stmtEnviar->bind_param("iis", $userId, $idAlumno, $mensajeTexto);
        $stmtEnviar->execute();
        header("Location: mensajes-instructor.php?idAlumno=$idAlumno");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes del Instructor</title>
    <style>
        .contenedor {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .lista-conversaciones {
            flex: 0 0 300px;
            border-right: 1px solid #ddd;
            padding: 10px;
        }
        .lista-conversaciones ul {
            list-style: none;
            padding: 0;
        }
        .lista-conversaciones li {
            margin-bottom: 10px;
        }
        .lista-conversaciones a {
            text-decoration: none;
            color: #2c5282;
        }
        .chat {
            flex: 1;
            padding: 10px;
        }
        .mensaje {
            margin-bottom: 15px;
        }
        .mensaje-propio {
            text-align: right;
        }
        .mensaje-alumno {
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
    <div class="contenedor">
        <!-- Lista de conversaciones -->
        <div class="lista-conversaciones">
            <h3>Conversaciones</h3>
            <ul>
                <?php while ($conversacion = $conversaciones->fetch_assoc()): ?>
                    <li>
                        <a href="mensajes-instructor.php?idAlumno=<?php echo $conversacion['idUsuario']; ?>">
                            <?php echo htmlspecialchars($conversacion['alumnoNombre']); ?>
                            (<?php echo htmlspecialchars($conversacion['cursoTitulo']); ?>)
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>

        <!-- Chat de mensajes -->
        <div class="chat">
            <?php if (isset($_GET['idAlumno'])): ?>
                <h3>Chat con <?php echo htmlspecialchars($conversaciones->fetch_assoc()['alumnoNombre'] ?? 'Alumno'); ?></h3>
                <div class="mensajes">
                    <?php while ($mensaje = $mensajes->fetch_assoc()): ?>
                        <div class="mensaje <?php echo $mensaje['idEmisor'] == $userId ? 'mensaje-propio' : 'mensaje-alumno'; ?>">
                            <strong><?php echo htmlspecialchars($mensaje['emisorNombre'] . ' ' . $mensaje['emisorApellido']); ?>:</strong>
                            <p><?php echo htmlspecialchars($mensaje['texto']); ?></p>
                            <small><?php echo htmlspecialchars($mensaje['fecha']); ?></small>
                        </div>
                    <?php endwhile; ?>
                </div>
                <form method="POST" class="form-mensaje">
                    <textarea name="mensaje" rows="3" placeholder="Escribe tu mensaje..." required></textarea>
                    <input type="hidden" name="idAlumno" value="<?php echo intval($_GET['idAlumno']); ?>">
                    <button type="submit">Enviar</button>
                </form>
            <?php else: ?>
                <p>Selecciona una conversación para ver los mensajes.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
