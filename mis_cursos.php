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
$queryCategorias = "SELECT DISTINCT categoria 
                   FROM VistaMisCursos 
                   WHERE idUsuario = ?
                   ORDER BY categoria";
$stmtCategorias = $mysqli->prepare($queryCategorias);
$stmtCategorias->bind_param("i", $userId);
$stmtCategorias->execute();
$categorias = $stmtCategorias->get_result();

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
while ($curso = $cursos->fetch_assoc()) {
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
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mis Cursos</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                line-height: 1.6;
                margin: 0;
                padding: 20px;
                background-color: #f7fafc;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
            }

            .categoria {
                margin-bottom: 40px;
                background-color: white;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .categoria-titulo {
                color: #2d3748;
                border-bottom: 2px solid #e2e8f0;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .curso {
                margin-bottom: 30px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                overflow: hidden;
            }

            .curso-header {
                display: flex;
                gap: 20px;
                padding: 20px;
                background-color: #f8fafc;
            }

            .curso-imagen {
                width: 200px;
                height: 150px;
                object-fit: cover;
                border-radius: 4px;
            }

            .curso-info {
                flex: 1;
            }

            .curso-titulo {
                margin: 0 0 10px 0;
                color: #2d3748;
            }

            .curso-meta {
                color: #718096;
                font-size: 0.9em;
                margin-bottom: 10px;
            }

            .progreso-bar {
                width: 100%;
                height: 10px;
                background-color: #edf2f7;
                border-radius: 5px;
                overflow: hidden;
                margin-top: 10px;
            }

            .progreso-valor {
                height: 100%;
                background-color: #4299e1;
                transition: width 0.3s ease;
            }

            .niveles {
                padding: 20px;
            }

            .nivel {
                padding: 15px;
                border: 1px solid #e2e8f0;
                border-radius: 4px;
                margin-bottom: 10px;
                background-color: white;
            }

            .nivel-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                cursor: pointer;
            }

            .nivel-content {
                display: none;
                margin-top: 15px;
                padding-top: 15px;
                border-top: 1px solid #e2e8f0;
            }

            .nivel.activo .nivel-content {
                display: block;
            }

            .btn-video {
                background-color: #4299e1;
                color: white;
                padding: 8px 16px;
                border-radius: 4px;
                text-decoration: none;
                display: inline-block;
                margin-top: 10px;
            }

            .btn-video:hover {
                background-color: #3182ce;
            }

            .recursos-lista {
                list-style: none;
                padding: 0;
                margin: 10px 0;
            }

            .recursos-lista li {
                padding: 5px 0;
            }

            @media (max-width: 768px) {
                .curso-header {
                    flex-direction: column;
                }

                .curso-imagen {
                    width: 100%;
                    height: 200px;
                }
            }
            .btn-comentario {
                background-color: #48bb78;
                color: white;
                border: none;
                padding: 8px 16px;
                border-radius: 4px;
                cursor: pointer;
                align-self: center; /* Alineación vertical */
                margin-left: auto; /* Empuja el botón al final del contenedor */
            }

            .btn-comentario:hover {
                background-color: #38a169;
            }

            .modal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .modal-content {
                background-color: white;
                padding: 20px;
                border-radius: 8px;
                max-width: 500px;
                width: 90%;
                position: relative;
            }

            .cerrar {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 20px;
                cursor: pointer;
            }

            textarea {
                width: 100%;
                height: 100px;
                resize: none;
                margin-top: 10px;
            }


        </style>
    </head>
    <body>
        <div class="container">
            <h1>Mis Cursos</h1>

            <?php foreach ($cursosPorCategoria as $categoria => $cursos): ?>
                <div class="categoria">
                    <h2 class="categoria-titulo"><?php echo htmlspecialchars($categoria); ?></h2>
                    
                    <?php foreach ($cursos as $curso): ?>
                        <div class="curso">
                            <div class="curso-header">
                                <img src="<?php echo htmlspecialchars($curso['info']['imagen'] ?? '/api/placeholder/400/320'); ?>" 
                                    alt="<?php echo htmlspecialchars($curso['info']['titulo']); ?>" 
                                    class="curso-imagen">
                                
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
                                <button class="btn-comentario" onclick="abrirModalComentario(<?php echo $curso['info']['idCurso']; ?>, '<?php echo htmlspecialchars($curso['info']['titulo']); ?>')">
                                    Dejar comentario
                                </button>
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
                <form id="formComentario" method="POST" action="/metodos/RegistrarComentarioCurso.php">
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