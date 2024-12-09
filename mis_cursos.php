<?php
session_start();
require_once 'metodos/conexion.php';

// Verificar si hay un usuario logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: metodos/login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Conexión a la base de datos
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Obtener todas las categorías de los cursos del usuario
$categorias = [];
$stmtCategorias = $mysqli->prepare("CALL ObtenerCategoriasUsuario(?)");
if ($stmtCategorias) {
    $stmtCategorias->bind_param("i", $userId);
    $stmtCategorias->execute();
    $resultadoCategorias = $stmtCategorias->get_result();

    while ($categoria = $resultadoCategorias->fetch_assoc()) {
        $categorias[] = $categoria['categoria'];
    }

    $stmtCategorias->close();
} else {
    die("Error al obtener categorías: " . $mysqli->error);
}

// Obtener cursos por categoría
$queryCursos = "SELECT * 
                FROM VistaMisCursos 
                WHERE idUsuario = ? 
                ORDER BY categoria, idCurso, idNivel";
$stmtCursos = $mysqli->prepare($queryCursos);
$stmtCursos->bind_param("i", $userId);
$stmtCursos->execute();
$cursos = $stmtCursos->get_result();

// Organizar cursos por categoría
$cursosPorCategoria = [];
$stmtCursos = $mysqli->prepare("CALL ObtenerCursosUsuario(?)");
if ($stmtCursos) {
    $stmtCursos->bind_param("i", $userId);
    $stmtCursos->execute();
    $resultadoCursos = $stmtCursos->get_result();

    while ($curso = $resultadoCursos->fetch_assoc()) {
        $categoria = $curso['categoria'];
        if (!isset($cursosPorCategoria[$categoria])) {
            $cursosPorCategoria[$categoria] = [];
        }
        if (!isset($cursosPorCategoria[$categoria][$curso['idCurso']])) {
            $cursosPorCategoria[$categoria][$curso['idCurso']] = [
                'info' => [
                    'idCurso' => $curso['idCurso'],
                    'titulo' => $curso['titulo_curso'],
                    'descripcion' => $curso['descripcion_curso'],
                    'imagen' => $curso['imagen_curso'],
                    'instructor' => $curso['instructor'],
                    'progreso' => $curso['progresoPorcentaje'],
                    'ultimoAcceso' => $curso['ultimoAcceso']
                ],
                'niveles' => []
            ];
        }
        $cursosPorCategoria[$categoria][$curso['idCurso']]['niveles'][] = [
            'idNivel' => $curso['idNivel'],
            'titulo' => $curso['titulo_nivel'],
            'descripcion' => $curso['descripcion_nivel'],
            'recursos' => $curso['recursos'],
            'videoUrl' => $curso['videoUrl']
        ];
    }

    $stmtCursos->close();
} else {
    die("Error al obtener cursos: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
    <link rel="stylesheet" href="css/mis_cursos.css">
        <meta charset="UTF-8">
        <title>Mis Cursos</title>
        
    </head>
    <body>
        <div class="container">
            <h1>Mis Cursos</h1>

            <?php foreach ($cursosPorCategoria as $categoria => $cursos): ?>
                <div class="categoria">
                    <h2 class="categoria-titulo"><?php echo htmlspecialchars($categoria); ?></h2>
                    
                    <?php foreach ($cursos as $curso): ?>
                        <div class="curso">
                            <div class="curso-header"><?php 
                                    if ($curso['info']['imagen']) {
                                        $cursoimagen_base64 = base64_encode($curso['info']['imagen']);
                                        $cursoimagen_base64 = "data:image/jpeg;base64," . $cursoimagen_base64;
                                    } else {
                                        $cursoimagen_base64 = '';
                                    }
                                    ?>
                                    <img src="<?php echo $cursoimagen_base64; ?>" 
                                    alt="<?php echo htmlspecialchars($curso['info']['titulo']); ?>" class="curso-imagen">
                                
                                <div class="curso-info">
                                    <h3 class="curso-titulo"><?php echo htmlspecialchars($curso['info']['titulo']); ?></h3>
                                    
                                    <div class="curso-meta">
                                        <p>Instructor: <?php echo htmlspecialchars($curso['info']['instructor']); ?></p>
                                        <p>Último acceso: <?php echo $curso['info']['ultimoAcceso'] ? date('d/m/Y H:i', strtotime($curso['info']['ultimoAcceso'])) : 'Nunca'; ?></p>
                                    </div>

                                    <div class="progreso-bar">
                                        <div class="progreso-valor" style="width: <?php echo $curso['info']['progreso']; ?>%"></div>
                                    </div>
                                    <small>Progreso: <?php echo $curso['info']['progreso']; ?>%</small>
                                </div>

                                <?php if($curso['info']['progreso'] == 100){?>
                                    <button class="btn-comentario" onclick="abrirModalComentario(<?php echo $curso['info']['idCurso']; ?>, '<?php echo htmlspecialchars($curso['info']['titulo']); ?>')">
                                        Dejar comentario
                                    </button>
                                <?php }?>
                                
                            </div>

                            <div class="niveles">
                                <?php foreach ($curso['niveles'] as $nivel): ?>
                                    <div class="nivel">
                                        <div class="nivel-header" onclick="toggleNivel(this)">
                                            <h4><?php echo htmlspecialchars($nivel['titulo']); ?></h4>
                                            <span class="toggle-icon">▼</span>
                                        </div>
                                        <div class="nivel-content">
                                            <p><?php echo htmlspecialchars($nivel['descripcion']); ?></p>
                                            
                                            <?php if ($nivel['recursos']): ?>
                                                <h5>Recursos disponibles:</h5>
                                                <ul class="recursos-lista">
                                                    <?php foreach (json_decode($nivel['recursos']) as $recurso): ?>
                                                        <li>📁 <?php echo htmlspecialchars($recurso); ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>

                                            <?php if ($nivel['videoUrl']): ?>
                                                <a href="ver_video.php?nivel=<?php echo $nivel['idNivel']; ?>&curso=<?php echo array_search($curso, $cursos); ?>" class="btn-video">Ver video del nivel</a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <script>
            function toggleNivel(element) {
                const nivel = element.parentElement;
                nivel.classList.toggle('activo');
                const icon = element.querySelector('.toggle-icon');
                icon.textContent = nivel.classList.contains('activo') ? '▼' : '▶';
            }

            function abrirModalComentario(idCurso, tituloCurso) {
                document.getElementById('idCurso').value = idCurso;
                document.getElementById('tituloCurso').textContent = `Curso: ${tituloCurso}`;
                document.getElementById('modalComentario').style.display = 'flex';
            }

            function cerrarModalComentario() {
                document.getElementById('modalComentario').style.display = 'none';
            }

        </script>

        <div id="modalComentario" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="cerrar" onclick="cerrarModalComentario()">&times;</span>
                <h2>Dejar un comentario</h2>
                <form id="formComentario" method="POST" action="/bdm/metodos/RegistrarComentarioCurso.php">
                    <input type="hidden" id="idCurso" name="idCurso">
                    <p id="tituloCurso"></p>
                    <textarea name="textoComentario" placeholder="Escribe tu comentario" required></textarea>
                    <br>
                    <label for="calificacion">Calificación:</label>
                    <select name="calificacion" required>
                        <option value="1">1 - Muy malo</option>
                        <option value="2">2 - Malo</option>
                        <option value="3">3 - Regular</option>
                        <option value="4">4 - Bueno</option>
                        <option value="5">5 - Excelente</option>
                    </select>
                    <br><br>
                    <button type="submit" class="btn-enviar">Enviar</button>
                </form>
            </div>
        </div>

    </body>
</html>