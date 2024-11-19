<?php
session_start();
require_once 'metodos/conexion.php';

// Verificar si hay un ID de curso y si es numérico
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard-cursos.php");
    exit;
}

$cursoId = (int)$_GET['id'];
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

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
         WHERE idCurso = c.idCurso AND calificacion IS NOT NULL) AS promedioCalificaciones
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
        <!-- Información principal del curso -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h1 class="text-3xl font-bold mb-4"><?php echo htmlspecialchars($curso['tituloCurso']); ?></h1>
                <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($curso['descripcionCurso']); ?></p>
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
                <p class="text-2xl text-blue-600 font-bold mt-4">
                    $<?php echo number_format($curso['costoTotal'], 2); ?> MXN
                </p>
            </div>
        </div>

        <!-- Niveles -->
        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Niveles del curso</h2>
            <?php if ($niveles->num_rows > 0): ?>
                <?php while ($nivel = $niveles->fetch_assoc()): ?>
                    <div class="bg-white shadow-md rounded-lg p-4 mb-4">
                        <h3 class="text-xl font-semibold"><?php echo htmlspecialchars($nivel['titulo']); ?></h3>
                        <p class="mt-2"><?php echo htmlspecialchars($nivel['descripcion']); ?></p>
                        <p class="text-blue-600 font-bold mt-2">
                            $<?php echo number_format($nivel['costoNivel'], 2); ?> MXN
                        </p>
                        <div class="flex space-x-4 mt-2">
                            <?php if ($nivel['tieneVideo']): ?>
                                <span class="text-green-600">✓ Video incluido</span>
                            <?php endif; ?>
                            <?php if ($nivel['tieneDocumento']): ?>
                                <span class="text-green-600">✓ Material de estudio</span>
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