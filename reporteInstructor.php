<?php
session_start();
require_once 'metodos/conexion.php';

$instructorId = $_SESSION['user_id']; // Asumimos que el ID del instructor está almacenado en la sesión
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

$resumenCursos = [];
$ingresosPorFormaPago = [];
$alumnosPorCurso = [];

if (isset($instructorId)) {
    // Llamar al procedimiento para el resumen de cursos
    $stmtResumen = $mysqli->prepare("CALL ObtenerResumenCursos(?, ?, ?, ?, ?)");
    $fechaInicio = '2000-01-01';
    $fechaFin = date('Y-m-d');
    $idCategoria = 0; // Sin filtrar por categoría
    $soloActivos = 1; // Solo cursos activos
    $stmtResumen->bind_param('issii', $instructorId, $fechaInicio, $fechaFin, $idCategoria, $soloActivos);

    if ($stmtResumen->execute()) {
        $result = $stmtResumen->get_result();
        while ($row = $result->fetch_assoc()) {
            $resumenCursos[] = $row;
        }
    }
    $stmtResumen->close();

    // Llamar al procedimiento para ingresos por forma de pago
    $stmtIngresos = $mysqli->prepare("CALL ObtenerIngresosPorFormaPago(?, ?, ?, ?, ?)");
    $stmtIngresos->bind_param('issii', $instructorId, $fechaInicio, $fechaFin, $idCategoria, $soloActivos);

    if ($stmtIngresos->execute()) {
        $result = $stmtIngresos->get_result();
        while ($row = $result->fetch_assoc()) {
            $ingresosPorFormaPago[] = $row;
        }
    }
    $stmtIngresos->close();

    // Llamar al procedimiento para alumnos por curso
    foreach ($resumenCursos as $curso) {
        $stmtAlumnos = $mysqli->prepare("CALL ObtenerDetalleCurso(?, ?, ?, ?)");
        $stmtAlumnos->bind_param('issi', $curso['idCurso'], $fechaInicio, $fechaFin, $soloActivos);

        if ($stmtAlumnos->execute()) {
            $result = $stmtAlumnos->get_result();
            while ($row = $result->fetch_assoc()) {
                $alumnosPorCurso[$curso['idCurso']][] = $row;
            }
        }
        $stmtAlumnos->close();
    }
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
        <title>Dashboard del Instructor</title>
        <link rel="stylesheet" href="css/dashboard.css">
    </head>
    <body>
        <header>
            <h1>Judav Academy</h1>
            <h2>Dashboard del Instructor</h2>
        </header>
        
        <main>
            <div class="dashboard-container">
                <!-- Resumen de Cursos -->
                <section id="resumen-cursos">
                    <h2>Resumen de Cursos</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Curso</th>
                                <th>Alumnos Inscritos</th>
                                <th>Promedio de Progreso</th>
                                <th>Ingresos Totales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($resumenCursos as $curso) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($curso['nombreCurso']); ?></td>
                                    <td><?php echo htmlspecialchars($curso['alumnosInscritos']); ?></td>
                                    <td><?php echo htmlspecialchars($curso['nivelPromedio']); ?>%</td>
                                    <td>$<?php echo number_format($curso['ingresosTotales'], 2, '.', ','); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>

                <!-- Ingresos por Forma de Pago -->
                <section id="ingresos-forma-pago">
                    <h2>Ingresos por Forma de Pago</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Forma de Pago</th>
                                <th>Ingresos Totales</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ingresosPorFormaPago as $ingreso) { ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ingreso['formaPago']); ?></td>
                                    <td>$<?php echo number_format($ingreso['totalIngresos'], 2, '.', ','); ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </section>

                <!-- Detalles de Alumnos por Curso -->
                <section id="detalles-alumnos">
                    <h2>Detalles de Alumnos por Curso</h2>
                    <?php foreach ($alumnosPorCurso as $idCurso => $alumnos) { ?>
                        <h3>Curso: <?php echo htmlspecialchars($resumenCursos[array_search($idCurso, array_column($resumenCursos, 'idCurso'))]['nombreCurso']); ?></h3>
                        <table>
                            <thead>
                                <tr>
                                    <th>Alumno</th>
                                    <th>Fecha y Hora de Inscripción</th>
                                    <th>Progreso</th>
                                    <th>Último Acceso</th>
                                    <th>Precio Pagado</th>
                                    <th>Forma de Pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($alumnos as $alumno) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($alumno['nombreAlumno']); ?></td>
                                        <td><?php echo htmlspecialchars($alumno['fechaInscripcion']); ?></td>
                                        <td><?php echo htmlspecialchars($alumno['nivelAvance']); ?>%</td>
                                        <td><?php echo htmlspecialchars($alumno['fechaUltimaActividad'] ?? 'No disponible'); ?></td>
                                        <td>$<?php echo number_format($alumno['precioPagado'], 2, '.', ','); ?></td>
                                        <td><?php echo htmlspecialchars($alumno['formaPago']); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </section>
            </div>
        </main>
    </body>
</html>
