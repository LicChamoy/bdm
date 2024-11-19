<?php
session_start();
require_once 'metodos/conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Verificar si hay un ID de curso y si es numérico
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard-cursos.php");
    exit;
}

$cursoId = (int)$_GET['id'];
$usuarioId = (int)$_SESSION['user_id']; // Cambiado de idUsuario a user_id
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Verificar que el usuario existe
$queryVerificarUsuario = "SELECT idUsuario FROM usuarios WHERE idUsuario = ?";
$stmtVerificarUsuario = $mysqli->prepare($queryVerificarUsuario);
$stmtVerificarUsuario->bind_param("i", $usuarioId);
$stmtVerificarUsuario->execute();
$resultadoUsuario = $stmtVerificarUsuario->get_result();

if ($resultadoUsuario->num_rows === 0) {
    header("Location: login.php");
    exit;
}



// Verificar si el usuario ya está inscrito en el curso o en algún nivel
$queryInscripcion = "
    SELECT 
        ic.idNivel,
        ic.fechaInscripcion,
        ic.montoPorVenta
    FROM interaccionesCurso ic
    WHERE ic.idUsuario = ? AND ic.idCurso = ?";

// Ejecutar el query de inscripción y almacenar los resultados
$stmtInscripcion = $mysqli->prepare($queryInscripcion);
$stmtInscripcion->bind_param("ii", $usuarioId, $cursoId);
$stmtInscripcion->execute();
$inscripciones = $stmtInscripcion->get_result()->fetch_all(MYSQLI_ASSOC);


// Obtener detalles del curso
$queryCurso = "
    SELECT 
        c.idCurso,
        c.titulo AS tituloCurso,
        c.descripcion AS descripcionCurso,
        c.costoTotal,
        cat.nombre AS categoriaNombre,
        u.nombre AS instructorNombre,
        u.apellidos AS instructorApellidos,
        (SELECT AVG(calificacion) FROM interaccionesCurso 
         WHERE idCurso = c.idCurso AND calificacion IS NOT NULL) AS promedioCalificaciones,
        (SELECT COUNT(*) FROM interaccionesCurso 
         WHERE idCurso = c.idCurso AND fechaInscripcion IS NOT NULL) AS totalInscritos
    FROM cursos c
    JOIN usuarios u ON c.idInstructor = u.idUsuario
    JOIN categorias cat ON c.categoria = cat.idCategoria
    WHERE c.idCurso = ? AND c.estado = 'activo'";

$stmtCurso = $mysqli->prepare($queryCurso);
$stmtCurso->bind_param("i", $cursoId);
$stmtCurso->execute();
$curso = $stmtCurso->get_result()->fetch_assoc();

if (!$curso) {
    header("Location: dashboard-cursos.php");
    exit;
}

// Obtener niveles del curso
$queryNiveles = "
    SELECT 
        n.idNivel,
        n.titulo,
        n.descripcion,
        n.costoNivel,
        CASE WHEN n.video IS NOT NULL THEN TRUE ELSE FALSE END AS tieneVideo,
        CASE WHEN n.documento IS NOT NULL THEN TRUE ELSE FALSE END AS tieneDocumento
    FROM niveles n
    WHERE n.idCurso = ?
    ORDER BY n.idNivel";

$stmtNiveles = $mysqli->prepare($queryNiveles);
$stmtNiveles->bind_param("i", $cursoId);
$stmtNiveles->execute();
$niveles = $stmtNiveles->get_result();

// Procesar la compra
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    if (!isset($_SESSION['user_id'])) {
        $error = "Debes iniciar sesión para realizar una compra";
    } else {
        $tipo = $_POST['tipo']; // 'completo' o 'nivel'
        $nivelId = isset($_POST['nivel_id']) ? (int)$_POST['nivel_id'] : null;
        $monto = ($tipo === 'completo') ? $curso['costoTotal'] : 0;

        if ($tipo === 'nivel' && $nivelId) {
            // Verificar que el nivel existe y pertenece al curso
            $queryVerificarNivel = "SELECT idNivel FROM niveles WHERE idNivel = ? AND idCurso = ?";
            $stmtVerificarNivel = $mysqli->prepare($queryVerificarNivel);
            $stmtVerificarNivel->bind_param("ii", $nivelId, $cursoId);
            $stmtVerificarNivel->execute();
            
            if ($stmtVerificarNivel->get_result()->num_rows === 0) {
                throw new Exception("Nivel no válido");
            }

            // Buscar el costo del nivel específico
            $niveles->data_seek(0);
            while ($nivel = $niveles->fetch_assoc()) {
                if ($nivel['idNivel'] == $nivelId) {
                    $monto = $nivel['costoNivel'];
                    break;
                }
            }
            $niveles->data_seek(0);
        }

        // Verificar si ya está inscrito
        $queryVerificarInscripcion = "SELECT idUsuario FROM interaccionesCurso 
            WHERE idUsuario = ? AND idCurso = ? AND 
            (idNivel = ? OR (? IS NULL AND idNivel IS NULL))";
        $stmtVerificarInscripcion = $mysqli->prepare($queryVerificarInscripcion);
        $stmtVerificarInscripcion->bind_param("iiii", $usuarioId, $cursoId, $nivelId, $nivelId);
        $stmtVerificarInscripcion->execute();
        
        if ($stmtVerificarInscripcion->get_result()->num_rows > 0) {
            $error = "Ya estás inscrito en este curso/nivel";
        } else {
            // Iniciar transacción
            $mysqli->begin_transaction();

            try {
                $queryInsertCompra = "
                    INSERT INTO interaccionesCurso (
                        idUsuario, 
                        idCurso, 
                        idNivel,
                        fechaInscripcion, 
                        montoPorVenta, 
                        formaPago,
                        estadoAlumno
                    ) VALUES (?, ?, ?, NOW(), ?, 'tarjeta', 'en progreso')";

                $stmtCompra = $mysqli->prepare($queryInsertCompra);
                $stmtCompra->bind_param("iiid", $usuarioId, $cursoId, $nivelId, $monto);
                $stmtCompra->execute();

                $mysqli->commit();
                echo "<script>alert('Compra realizada con éxito!'); window.location.reload();</script>";
            } catch (Exception $e) {
                $mysqli->rollback();
                $error = "Error al procesar la compra: " . $e->getMessage();
            }
        }
    }
}

// Obtener comentarios
$queryComentarios = "
    SELECT 
        i.textoComentario,
        i.calificacion,
        i.fechaComentario,
        u.nombre,
        u.apellidos
    FROM interaccionesCurso i
    JOIN usuarios u ON i.idUsuario = u.idUsuario
    WHERE i.idCurso = ? 
    AND i.textoComentario IS NOT NULL 
    AND i.estatusComentario = 'visible'
    ORDER BY i.fechaComentario DESC";

$stmtComentarios = $mysqli->prepare($queryComentarios);
$stmtComentarios->bind_param("i", $cursoId);
$stmtComentarios->execute();
$comentarios = $stmtComentarios->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($curso['tituloCurso']); ?> - Detalles</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-7xl mx-auto px-4 py-8">
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Información principal del curso -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($curso['tituloCurso']); ?></h1>
                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($curso['descripcionCurso']); ?></p>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-blue-800">
                            Categoría: <?php echo htmlspecialchars($curso['categoriaNombre']); ?>
                        </p>
                        <p>Por: <?php echo htmlspecialchars($curso['instructorNombre'] . ' ' . $curso['instructorApellidos']); ?></p>
                        <div class="text-yellow-400 mt-2">
                            <?php 
                            $calificacion = round($curso['promedioCalificaciones']);
                            for ($i = 0; $i < 5; $i++): 
                            ?>
                                <?php echo $i < $calificacion ? '★' : '☆'; ?>
                            <?php endfor; ?>
                            <span class="text-gray-600">
                                (<?php echo $curso['promedioCalificaciones'] ? number_format($curso['promedioCalificaciones'], 1) : 'Sin calificaciones'; ?>)
                            </span>
                        </div>
                        <p class="text-gray-600 mt-2">
                            <?php echo $curso['totalInscritos']; ?> estudiantes inscritos
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl text-blue-600 font-bold">
                            $<?php echo number_format($curso['costoTotal'], 2); ?> MXN
                        </p>
                        <?php if (isset($_SESSION['user_id'])): ?>
    <?php
    $cursoComprado = false;
    foreach ($inscripciones as $inscripcion) {
        if ($inscripcion['idNivel'] === null) {
            $cursoComprado = true;
            break;
        }
    }
    ?>
    <?php if (!$cursoComprado): ?>
        <form method="POST" class="mt-4">
            <input type="hidden" name="tipo" value="completo">
            <button type="submit" name="comprar" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                Comprar curso completo
            </button>
        </form>
    <?php else: ?>
        <p class="text-green-600 font-semibold">Ya estás inscrito en este curso</p>
    <?php endif; ?>
<?php else: ?>
    <a href="login.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 inline-block">
        Inicia sesión para comprar
    </a>
<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Niveles -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Niveles del curso</h2>
            <?php if ($niveles->num_rows > 0): ?>
                <?php while ($nivel = $niveles->fetch_assoc()): ?>
    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
        <!-- ... (contenido del nivel) ... -->
        <div class="text-right">
            <p class="text-blue-600 font-bold">
                $<?php echo number_format($nivel['costoNivel'], 2); ?> MXN
            </p>
            <?php 
            $nivelComprado = false;
            $cursoCompletoComprado = false;
            
            foreach ($inscripciones as $inscripcion) {
                if ($inscripcion['idNivel'] === $nivel['idNivel']) {
                    $nivelComprado = true;
                    break;
                }
                if ($inscripcion['idNivel'] === null) {
                    $cursoCompletoComprado = true;
                    break;
                }
            }
            ?>
            <?php if (!$nivelComprado && !$cursoCompletoComprado): ?>
                <form method="POST" class="mt-2">
                    <input type="hidden" name="tipo" value="nivel">
                    <input type="hidden" name="nivel_id" value="<?php echo $nivel['idNivel']; ?>">
                    <button type="submit" name="comprar" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Comprar nivel
                    </button>
                </form>
            <?php else: ?>
                <p class="text-green-600 font-semibold">
                    <?php echo $cursoCompletoComprado ? 'Incluido en el curso completo' : 'Nivel adquirido'; ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
<?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-600">Este curso aún no tiene niveles definidos.</p>
            <?php endif; ?>
        </div>

        <!-- Comentarios -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Comentarios</h2>
            <?php if ($comentarios->num_rows > 0): ?>
                <?php while ($comentario = $comentarios->fetch_assoc()): ?>
                    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                        <p class="font-bold"><?php echo htmlspecialchars($comentario['nombre'] . ' ' . $comentario['apellidos']); ?></p>
                        <div class="text-yellow-400 my-1">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <?php echo $i < $comentario['calificacion'] ? '★' : '☆'; ?>
                            <?php endfor; ?>
                        </div>
                        <p class="mt-2"><?php echo htmlspecialchars($comentario['textoComentario']); ?></p>
                        <p class="text-sm text-gray-500 mt-2">
                            <?php echo date('d/m/Y', strtotime($comentario['fechaComentario'])); ?>
                        </p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-gray-600">Aún no hay comentarios para este curso.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>