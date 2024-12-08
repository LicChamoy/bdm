<?php
session_start();
require_once 'conexion.php';

// Verify if the user is logged in and is an instructor
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'docente') {
    header("Location: ../login.html");
    exit;
}

// Conexión a la base de datos
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Handle course deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_curso'])) {
    $idCurso = $mysqli->real_escape_string($_POST['idCurso']);
    
    // Call the procedure to delete the course
    $stmt = $mysqli->prepare("CALL EliminarCurso(?, ?)");
    $stmt->bind_param("ii", $idCurso, $_SESSION['user_id']);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        $mensaje = "Curso eliminado exitosamente.";
    } else {
        $mensaje = "Error al eliminar el curso.";
    }
    $stmt->close();
}

// Fetch courses for deletion directly in the query
$query = "
SELECT 
    c.idCurso,
    c.titulo,
    c.descripcion,
    c.fechaCreacion,
    (SELECT COUNT(*) FROM interaccionescurso ic WHERE ic.idCurso = c.idCurso) AS total_estudiantes,
    c.estado
FROM 
    cursos c
WHERE 
    c.estado = 'activo' 
    AND c.idInstructor = ?";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$cursos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Cursos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .btn-eliminar {
            background-color: #ff4742;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .mensaje {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <h1>Eliminar Cursos</h1>
    
    <?php if(isset($mensaje)): ?>
        <div class="mensaje"><?php echo htmlspecialchars($mensaje); ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Fecha Creación</th>
                <th>Estudiantes Inscritos</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php while($curso = $cursos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($curso['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($curso['fechaCreacion']); ?></td>
                    <td><?php echo htmlspecialchars($curso['total_estudiantes']); ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('¿Está seguro de eliminar este curso?');">
                            <input type="hidden" name="idCurso" value="<?php echo $curso['idCurso']; ?>">
                            <button type="submit" name="eliminar_curso" class="btn-eliminar">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>