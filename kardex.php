<?php
session_start();
require_once 'metodos/conexion.php';

$userId = $_SESSION['user_id'];  // Asumimos que el ID de usuario está guardado en la sesión
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Consulta para obtener los cursos de la vista
$query = "SELECT * FROM vista_cursos_usuario WHERE idUsuario = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

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
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['cursoTitulo']; ?></td>
                                <td><?php echo $row['fechaInscripcion']; ?></td>
                                <td><?php echo $row['fechaUltimaActividad']; ?></td>
                                <td><?php echo $row['progresoDelCurso'] . '%'; ?></td>
                                <td><?php echo $row['fechaTerminoCurso'] ?? 'En progreso'; ?></td>
                                <td><?php echo $row['estadoAlumno']; ?></td>
                                <td>
                                    <?php if ($row['estadoAlumno'] == 'terminado') { ?>
                                        <button onclick="window.location.href='certificado.php?curso_id=<?php echo $row['idCurso']; ?>'">Ver Certificado</button>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>

        <script src="js/kardex.js"></script>
        <footer>
            <p>Judav Academy - 2024</p>
        </footer>
    </body>
</html>

<?php
$stmt->close();
$mysqli->close();
?>
