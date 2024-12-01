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

// Obtener categorías existentes
$queryCategorias = "SELECT nombre FROM categorias";
$resultCategorias = $mysqli->query($queryCategorias);
$categoriasExistentes = [];
while ($categoria = $resultCategorias->fetch_assoc()) {
    $categoriasExistentes[] = $categoria['nombre'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nuevo Curso</title>
    <style>
        /* ... (estilos anteriores) ... */
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
    let categoriaCounter = 1;

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

    function agregarCategoria() {
        categoriaCounter++;
        const categoriaContainer = document.getElementById('categorias-container');
        const nuevaCategoria = document.createElement('div');
        nuevaCategoria.className = 'categoria-grupo';
        nuevaCategoria.innerHTML = `
            <select name="categorias[]" required>
                <?php 
                foreach ($categoriasExistentes as $categoria) {
                    echo "<option value='".htmlspecialchars($categoria)."'>".htmlspecialchars($categoria)."</option>";
                }
                ?>
                <option value="nueva">+ Nueva Categoría</option>
            </select>
            <input type="text" name="nueva_categoria[]" placeholder="Nombre nueva categoría" style="display:none;">
            <button type="button" onclick="eliminarCategoria(this)">Eliminar</button>
        `;
        categoriaContainer.appendChild(nuevaCategoria);

        // Configurar evento para mostrar/ocultar campo de nueva categoría
        const select = nuevaCategoria.querySelector('select');
        const inputNueva = nuevaCategoria.querySelector('input[type="text"]');
        select.addEventListener('change', function() {
            inputNueva.style.display = this.value === 'nueva' ? 'block' : 'none';
            inputNueva.required = this.value === 'nueva';
        });
    }

    function eliminarCategoria(btn) {
        btn.closest('.categoria-grupo').remove();
    }

    function validarFormulario() {
        const niveles = document.querySelectorAll('.nivel-grupo');
        if (niveles.length === 0) {
            alert('Debe agregar al menos un nivel.');
            return false;
        }

        // Validar categorías
        const categorias = document.querySelectorAll('select[name="categorias[]"]');
        const categoriasNuevas = document.querySelectorAll('input[name="nueva_categoria[]"]');
        
        let categoriasValidas = true;
        categorias.forEach((select, index) => {
            if (select.value === 'nueva' && categoriasNuevas[index].value.trim() === '') {
                categoriasValidas = false;
            }
        });

        if (!categoriasValidas) {
            alert('Por favor, complete el nombre de las nuevas categorías.');
            return false;
        }

        return true;
    }

    // Añadir primera categoría al cargar
    window.onload = function() {
        agregarCategoria();
    };
    </script>
</head>
<body>
    <h1>Registrar Nuevo Curso</h1>
    
    <form action="procesar_curso.php" method="POST" enctype="multipart/form-data" onsubmit="return validarFormulario()">
        <div class="form-group">
            <label>Título del Curso</label>
            <input type="text" name="titulo" required>
        </div>

        <div class="form-group">
            <label>Descripción del Curso</label>
            <textarea name="descripcion" required></textarea>
        </div>

        <h2>Categorías del Curso</h2>
        <div id="categorias-container"></div>
        <div class="form-group">
            <button type="button" class="btn btn-success" onclick="agregarCategoria()">+ Agregar Categoría</button>
        </div>

        <div class="form-group">
            <label>Imagen del Curso (opcional)</label>
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
            <button type="button" class="btn btn-success" onclick="agregarNivel()">+ Agregar Nivel</button>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Registrar Curso</button>
            <a href="dashboard-docente.php" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</body>
</html>