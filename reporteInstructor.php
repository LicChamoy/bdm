<?php
session_start();
require_once 'metodos/conexion.php';

$instructorId = $_SESSION['user_id']; // Asumimos que el ID del instructor está almacenado en la sesión
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

$resumenCursos = [];
$ingresosPorFormaPago = [];
$alumnosPorCurso = [];

// Obtener las categorías
$categorias = [];
$queryCategorias = "SELECT idCategoria, nombre_categoria, descripcion_categoria, nombre_creador, total_cursos FROM vista_categorias_cursos"; // Ajusta la consulta según tu estructura de base de datos
$resultCategorias = $mysqli->query($queryCategorias);
if ($resultCategorias) {
    while ($row = $resultCategorias->fetch_assoc()) {
        $categorias[] = $row;
    }
}

if (isset($instructorId)) {
    // Capturar los valores del formulario
    $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '2000-01-01';
    $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : date('Y-m-d');
    $idCategoria = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0; // 0 para todas
    $soloActivos = isset($_GET['soloActivos']) ? intval($_GET['soloActivos']) : 1; // Solo activos por defecto

    // Llamar al procedimiento para el resumen de cursos
    $stmtResumen = $mysqli->prepare("CALL ObtenerResumenCursos(?, ?, ?, ?, ?)");
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
            <form method="GET" action="">
                <label for="fechaInicio">Fecha de Inicio:</label>
                <input type="date" id="fechaInicio" name="fechaInicio" value="<?php echo isset($_GET['fechaInicio']) ? htmlspecialchars($_GET['fechaInicio']) : '2000-01-01'; ?>">

                <label for="fechaFin">Fecha de Fin:</label>
                <input type="date" id="fechaFin" name="fechaFin" value="<?php echo isset($_GET['fechaFin']) ? htmlspecialchars($_GET['fechaFin']) : date('Y-m-d'); ?>">

                <label for="categoria">Categoría:</label>
                <select id="categoria" name="categoria">
                    <option value="0" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == 0) ? 'selected' : ''; ?>>Todas</option>
                    <?php foreach ($categorias as $categoria) { ?>
                        <option value="<?php echo htmlspecialchars($categoria['idCategoria']); ?>" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $categoria['idCategoria']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($categoria['nombre_categoria']); ?>
                        </option>
                    <?php } ?>
                </select>

                <label for="soloActivos">Solo Cursos Activos:</label>
                <select id="soloActivos" name="soloActivos">
                    <option value="1" <?php echo (isset($_GET['soloActivos']) && $_GET['soloActivos'] == 1) ? 'selected' : ''; ?>>Sí</option>
                    <option value="0" <?php echo (isset($_GET['soloActivos']) && $_GET['soloActivos'] == 0) ? 'selected' : ''; ?>>No</option>
                </select>

                <input type="submit" value="Filtrar">
            </form>
            
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
                                <?php foreach ($alumnos as $alumno) { 
                                    // Formatear las fechas y horas
                                    $fechaInscripcion = (new DateTime($alumno['fechaInscripcion']))->format('d-m-y H:i');
                                    $fechaUltimoAcceso = isset($alumno['fechaUltimaActividad']) ? 
                                        (new DateTime($alumno['fechaUltimaActividad']))->format('d-m-y H:i') : 
                                        'No disponible'; // Si no hay fecha de último acceso
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($alumno['nombreAlumno']); ?></td>
                                        <td><?php echo htmlspecialchars($fechaInscripcion); ?></td>
                                        <td><?php echo htmlspecialchars($alumno['nivelAvance']); ?>%</td>
                                        <td><?php echo htmlspecialchars($fechaUltimoAcceso); ?></td>
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
