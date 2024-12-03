<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario está logueado y es docente
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'docente') {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Obtener el ID del usuario
$idUsuario = $_SESSION['user_id'];

// Obtener categorías existentes
$queryCategorias = "SELECT idCategoria, nombre FROM categorias";
$resultCategorias = $mysqli->query($queryCategorias);
$categoriasExistentes = [];
while ($categoria = $resultCategorias->fetch_assoc()) {
    $categoriasExistentes[] = $categoria;
}

// Procesar formulario al enviar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $categorias = $_POST['categorias'] ?? []; // Lista de IDs de categorías seleccionadas
    $niveles = $_POST['niveles'] ?? [];
    $imagenCurso = null;

    // Validar que al menos una categoría esté seleccionada
    $categorias = array_filter($categorias, function ($categoria) {
        return !empty($categoria) && is_numeric($categoria);
    });
    
    if (empty($categorias)) {
        echo "<script>alert('Debe seleccionar al menos una categoría válida.');</script>";
        exit;
    }

    // Manejar subida de imagen
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/cursos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageName = uniqid('curso_') . '_' . basename($_FILES['imagen']['name']);
        $imagePath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $imagePath)) {
            $imagenCurso = $imagePath; // Guardar la ruta de la imagen
        } else {
            echo "<script>alert('Error al subir la imagen.');</script>";
            exit;
        }
    }    

    // Validar y procesar niveles
    $nivelTitulos = [];
    $nivelDescripciones = [];
    $nivelCostos = [];
    $nivelVideos = [];
    $nivelDocumentos = [];
    $nivelCounter = 0;

    foreach ($niveles as $nivel) {
        $nivelCounter++;
        $nivelTitulos[] = $nivel['titulo'] ?? '';
        $nivelDescripciones[] = $nivel['descripcion'] ?? '';
        $nivelCostos[] = floatval($nivel['costoNivel'] ?? 0);
        
        // Procesar documento del nivel
        if (!empty($_FILES['niveles']['name'][$index]['documento'])) {
            $documentoNombre = 'doc_nivel_' . uniqid() . '_' . $_FILES['niveles']['name'][$index]['documento'];
            $documentoRuta = 'uploads/documentos/' . $documentoNombre;

            // Crear directorio si no existe
            if (!is_dir('uploads/documentos')) {
                mkdir('uploads/documentos', 0755, true);
            }

            if (move_uploaded_file($_FILES['niveles']['tmp_name'][$index]['documento'], $documentoRuta)) {
                $nivelData['documento'] = $documentoRuta;
            }
        }

        // Procesar video del nivel
        if (!empty($_FILES['niveles']['name'][$index]['video'])) {
            $videoNombre = 'video_nivel_' . uniqid() . '_' . $_FILES['niveles']['name'][$index]['video'];
            $videoRuta = 'uploads/videos/' . $videoNombre;

            // Crear directorio si no existe
            if (!is_dir('uploads/videos')) {
                mkdir('uploads/videos', 0755, true);
            }

            if (move_uploaded_file($_FILES['niveles']['tmp_name'][$index]['video'], $videoRuta)) {
                $nivelData['video'] = $videoRuta;
            }
        }

    }

    // Calcular costo total
    $costoTotal = array_sum($nivelCostos);

    // Validar datos en formato JSON
    try {
        $categoriasJson = json_encode($categorias, JSON_THROW_ON_ERROR);
        $nivelTitulosJson = json_encode($nivelTitulos, JSON_THROW_ON_ERROR);
        $nivelDescripcionesJson = json_encode($nivelDescripciones, JSON_THROW_ON_ERROR);
        $nivelCostosJson = json_encode($nivelCostos, JSON_THROW_ON_ERROR);
        $nivelVideosJson = json_encode($nivelVideos, JSON_THROW_ON_ERROR);
        $nivelDocumentosJson = json_encode($nivelDocumentos, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        echo "<script>alert('Error al procesar datos en formato JSON: ');</script>" . $e->getMessage();
        exit;
    }

    // Llamar al procedimiento almacenado
    $stmt = $mysqli->prepare("CALL RegistrarCursoConNiveles(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $accion = 'registrar';
    $resultado = '';

    // Actualizar bind_param para incluir videos y documentos
    $stmt->bind_param(
        'sssisdsssssss',
        $accion,
        $titulo,
        $descripcion,
        $idUsuario,
        $categoriasJson,
        $costoTotal,
        $nivelTitulosJson,
        $nivelDescripcionesJson,
        $nivelCostosJson,
        $nivelVideosJson,
        $nivelDocumentosJson,
        $imagenCurso,
        $resultado
    );


    try {
        if ($stmt->execute()) {
            echo "<script>alert('Curso registrado con éxito.');</script>";
            header("Location: dashboard-docente.php");
            exit;
        } else {
            throw new Exception($stmt->error);
        }
    } catch (Exception $e) {
        echo "<script>alert('Error al registrar el curso, contacta con tu administrador, error: {$e->getMessage()}');</script>";
        exit;
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registrar Nuevo Curso</title>
        <style>
            .categoria-grupo {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }
            .categoria-grupo input, .categoria-grupo select {
                margin-right: 10px;
            }
        </style>
        <script>
        let nivelCounter = 1;
        let categoriaCounter = 0; // Cambiado a 0 para empezar desde el primer grupo de categorías
        let categoriasDisponibles = <?php echo json_encode($categoriasExistentes); ?>;
        let categoriasSeleccionadas = [];

        function agregarCategoria() {
            const categoriaContainer = document.getElementById('categorias-container');
            const nuevaCategoria = document.createElement('div');
            nuevaCategoria.className = 'categoria-grupo';
            nuevaCategoria.innerHTML = `
                <select name="categorias[]" onchange="verificarCategorias()">
                    <option value="">Selecciona una categoría</option>
                    <?php 
                        foreach ($categoriasExistentes as $categoria) {
                            echo "<option value='".htmlspecialchars($categoria['idCategoria'])."'>".htmlspecialchars($categoria['nombre'])."</option>";
                        }
                    ?>
                    <option value="nueva">+ Nueva Categoría</option>
                </select>
                <input type="text" name="nueva_categoria[]" placeholder="Nombre nueva categoría" style="display:none;">
                <button type="button" onclick="eliminarCategoria(this)">Eliminar</button>
            `;
            categoriaContainer.appendChild(nuevaCategoria);

            // Bloquear el botón después de añadir una nueva categoría
            const btnAgregar = document.getElementById('btn-agregar-categoria');
            btnAgregar.disabled = true;

            // Configurar evento para mostrar/ocultar campo de nueva categoría
            const select = nuevaCategoria.querySelector('select');
            const inputNueva = nuevaCategoria.querySelector('input[type="text"]');
            select.addEventListener('change', function() {
                inputNueva.style.display = this.value === 'nueva' ? 'block' : 'none';
                inputNueva.required = this.value === 'nueva';
                verificarCategorias();
            });
        }

        function verificarCategorias() {
            const categorias = document.querySelectorAll('select[name="categorias[]"]');
            const btnAgregar = document.getElementById('btn-agregar-categoria');

            // Contar categorías válidas seleccionadas
            categoriasSeleccionadas = 0;
            categorias.forEach((select) => {
                if (select.value && select.value !== '' && select.value !== 'nueva') {
                    categoriasSeleccionadas++;
                }
            });

            // Habilitar el botón solo si todas las categorías actuales tienen una selección válida
            btnAgregar.disabled = categoriasSeleccionadas !== categorias.length;
        }


        function eliminarCategoria(btn) {
            btn.closest('.categoria-grupo').remove();
            verificarCategorias();
        }


        function agregarNivel() {
            nivelCounter++;
            const nivelContainer = document.getElementById('niveles-container');
            const nuevoNivel = document.createElement('div');
            nuevoNivel.className = 'nivel-grupo';
            nuevoNivel.innerHTML = `
                <h3>Nivel ${nivelCounter}</h3>
                <div class="form-group">
                    <label>Título del Nivel</label>
                    <input type="text" name="niveles[${nivelCounter}][titulo]" required>
                </div>
                <div class="form-group">
                    <label>Descripción del Nivel</label>
                    <textarea name="niveles[${nivelCounter}][descripcion]" required></textarea>
                </div>
                <div class="form-group">
                    <label>Costo del Nivel ($)</label>
                    <input type="number" name="niveles[${nivelCounter}][costoNivel]" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label>Documento del Nivel (opcional)</label>
                    <input type="file" name="niveles[${nivelCounter}][documento]">
                </div>
                <div class="form-group">
                    <label>Video del Nivel (opcional)</label>
                    <input type="file" name="niveles[${nivelCounter}][video]" accept="video/*">
                </div>
            `;
            nivelContainer.appendChild(nuevoNivel);
        }

        function validarFormulario() {
            const niveles = document.querySelectorAll('.nivel-grupo');
            if (niveles.length === 0) {
                alert('Debe agregar al menos un nivel.');
                return false;
            }

            // Validar que al menos una categoría esté seleccionada
            const categorias = document.querySelectorAll('select[name="categorias[]"]');
            let categoriaSeleccionada = false;
            categorias.forEach((select) => {
                if (select.value && select.value !== 'nueva') {
                    categoriaSeleccionada = true;
                }
            });

            if (!categoriaSeleccionada) {
                alert('Debe seleccionar al menos una categoría.');
                return false;
            }

            return true;
        }

        window.onload = function() {
            agregarCategoria();
            verificarCategorias();
        };
        </script>
    </head>
    <body>
        <h1>Registrar Nuevo Curso</h1>
        
        <form action="" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario()">
            <div class="form-group">
                <label>Título del Curso</label>
                <input type="text" name="titulo" required>
            </div>

            <div class="form-group">
                <label>Descripción del Curso</label>
                <textarea name="descripcion" required></textarea>
            </div>

            <div>
                <label>Categorías (al menos una):</label>
                <button type="button" id="btn-agregar-categoria" class="btn btn-success" onclick="agregarCategoria()">+ Agregar Categoría</button>
                <div id="categorias-container">
                    <!-- Aquí se agregarán las categorías -->
                </div>
            </div>

            <div class="form-group">
                <label>Imagen del Curso</label>
                <input type="file" name="imagen" accept="image/*">
            </div>

            <h2>Niveles del Curso</h2>
            <div id="niveles-container">
                <div class="nivel-grupo">
                    <h3>Nivel 1</h3>
                    <div class="form-group">
                        <label>Título del Nivel</label>
                        <input type="text" name="niveles[1][titulo]" required>
                    </div>
                    <div class="form-group">
                        <label>Descripción del Nivel</label>
                        <textarea name="niveles[1][descripcion]" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Costo del Nivel ($)</label>
                        <input type="number" name="niveles[1][costoNivel]" step="0.01" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Documento del Nivel (opcional)</label>
                        <input type="file" name="niveles[1][documento]">
                    </div>
                    <div class="form-group">
                        <label>Video del Nivel (opcional)</label>
                        <input type="file" name="niveles[1][video]" accept="video/*">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button type="button" onclick="agregarNivel()">Agregar Nivel</button>
                <button type="submit" class="btn btn-primary">Registrar Curso</button>
                <a href="dashboard-docente.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </body>
</html>
