<?php
session_start();
require_once 'metodos/conexion.php';

$instructorId = $_SESSION['user_id']; // Asumimos que el ID del instructor está almacenado en la sesión
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

$resumenCursos = [];
$ingresosPorFormaPago = [];
$alumnosPorCurso = [];

// Obtener las categorías a través del procedimiento almacenado
$categorias = [];
$stmt = $mysqli->prepare("CALL ObtenerCategorias()");

if ($stmt) {
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado) {
        while ($row = $resultado->fetch_assoc()) {
            $categorias[] = $row;
        }
    }

    $stmt->close();
} else {
    die("Error al preparar la consulta: " . $mysqli->error);
}

// Verificar el resultado
if (empty($categorias)) {
    echo "No hay categorías disponibles.";
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
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #2c2f36; /* Fondo oscuro */
                color: #fff; /* Texto blanco */
            }
            header {
                background-color: #1e252b; /* Fondo más oscuro para el encabezado */
                color: #fff;
                padding: 20px;
                text-align: center;
            }
            h1 {
                margin: 0;
                font-size: 2.5em;
            }
            h2 {
                margin-top: 10px;
                font-size: 1.5em;
            }
            .dashboard-container {
                margin: 20px;
                background-color: #3a434f; /* Fondo oscuro para el contenedor */
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }
            form {
                margin-bottom: 20px;
                background-color: #4e565e; /* Fondo oscuro para el formulario */
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            }
            form label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
                color: #dcdcdc; /* Color más claro para el texto */
            }
            form input, form select {
                width: 100%;
                padding: 8px;
                margin-bottom: 15px;
                border-radius: 5px;
                border: 1px solid #555; /* Borde más claro */
                background-color: #353d45; /* Fondo oscuro para inputs */
                color: #fff; /* Texto blanco */
            }
            form input[type="submit"] {
                background-color: #4CAF50;
                color: white;
                cursor: pointer;
            }
            form input[type="submit"]:hover {
                background-color: #45a049;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                background-color: #2a323a; /* Fondo oscuro para las tablas */
            }
            table th, table td {
                padding: 12px;
                text-align: left;
                border: 1px solid #444; /* Borde más oscuro */
            }
            table th {
                background-color: #3a434f;
                font-weight: bold;
                color: #fff;
            }
            table td {
                background-color: #444d56;
                color: #fff;
            }
            section {
                margin-bottom: 30px;
            }
            section h2 {
                margin-bottom: 10px;
            }
            .back-button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #4CAF50;
                color: white;
                border: none;
                border-radius: 5px;
                text-align: center;
                cursor: pointer;
                margin-top: 20px;
            }
            .back-button:hover {
                background-color: #45a049;
            }
        </style>
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
