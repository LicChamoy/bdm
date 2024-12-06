<?php
session_start();
require_once 'metodos/conexion.php';

$userId = $_SESSION['user_id'];
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

$cursos = []; // Inicializar un array para almacenar los cursos

if (isset($userId)) {
    // Llamar al procedimiento almacenado GetCoursesByUser
    $stmt = $mysqli->prepare("CALL GetCoursesByUser(?)");
    $stmt->bind_param('i', $userId);

    if ($stmt->execute()) {
        // Obtener los resultados de cursos
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Agregar el curso al array
                $cursos[$row['idCurso']] = $row;
            }
        } else {
            echo "<script>alert('No se encontraron cursos para el usuario.');</script>";
        }
    } else {
        echo "<script>alert('Error al ejecutar el procedimiento.');</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Usuario no autenticado.'); window.location.href = 'login.php';</script>";
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kardex - Perfil Alumno</title>
        <link rel="stylesheet" href="css/kardex.css">
    </head>
    <body>
        <header>
            <h1>Judav Academy</h1>
            <h1>Kardex - Mis Cursos</h1>
        </header>

        <main>
            <div class="kardex-container">
                <h2>Mis Cursos</h2>
                <table class="kardex-table">
                    <thead>
                        <tr>
                            <th>Curso</th>
                            <th>Fecha de Inscripción</th>
                            <th>Último Acceso</th>
                            <th>Progreso</th>
                            <th>Fecha de Terminación</th>
                            <th>Estado</th>
                            <th>Certificado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursos as $curso) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($curso['cursoTitulo'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($curso['fechaInscripcion'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($curso['fechaUltimaActividad'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($curso['progresoDelCurso']) . '%'; ?></td>
                                <td><?php echo isset($curso['fechaTerminoCurso']) ? htmlspecialchars($curso['fechaTerminoCurso']) : 'En progreso'; ?></td>
                                <td><?php echo htmlspecialchars($curso['estadoAlumno'] ?? 'N/A'); ?></td>
                                <td>
                                    <?php if ($curso['estadoAlumno'] == 'terminado') { ?>
                                        <button onclick="window.location.href='certificado.php?curso_id=<?php echo $curso['idCurso']; ?>'">Ver Certificado</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
            <a href="metodos/dashboard-docente.php">Volver al dashboard</a>
            </div>
        </main>

    </body>
</html>
