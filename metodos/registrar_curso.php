<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Muestra información de depuración
//echo "Archivo actual: " . __FILE__ . "<br>";
//echo "Ruta de inclusión de conexion.php: " . realpath('conexion.php') . "<br>";

session_start(); 

// Forzar sesión de prueba (SOLO PARA DESARROLLO)
$_SESSION['user_id'] = 2;  // ID del docente que viste en tu dump
$_SESSION['user_rol'] = 'docente';

// Muestra el contenido de la sesión
//echo "<pre>Sesión: ";
//print_r($_SESSION);
//echo "</pre>";

require_once 'conexion.php'; // Tu clase de conexión

// Verificar si el usuario está logueado y es docente
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'docente') {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos para obtener categorías
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Verificar conexión
if (!$mysqli) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener categorías para el SELECT
$consultaCategorias = "SELECT idCategoria, nombre FROM categorias";
$resultadoCategorias = $mysqli->query($consultaCategorias);

// Verificar si hay categorías
if (!$resultadoCategorias) {
    echo "Error en la consulta: " . $mysqli->error;
    exit;
}

if ($resultadoCategorias->num_rows === 0) {
    echo "No hay categorías registradas";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Curso</title>
    <script>
function agregarNivel() {
    const contenedorNiveles = document.getElementById('niveles');
    const numeroNivel = contenedorNiveles.children.length + 1;
    const nuevoNivel = document.createElement('div');
    nuevoNivel.classList.add('nivel-container');
    nuevoNivel.innerHTML = `
        <h4>Nivel ${numeroNivel}</h4>
        <div class="campo-nivel">
            <input type="text" name="nivelTitulo[]" placeholder="Título del nivel" required>
        </div>
        <div class="campo-nivel">
            <textarea name="nivelDescripcion[]" placeholder="Descripción del nivel" required></textarea>
        </div>
        <div class="campo-nivel">
            <input type="number" name="nivelCosto[]" step="0.01" placeholder="Costo del nivel" required>
        </div>
        <div class="campo-nivel">
            <label>Video del nivel:</label>
            <input type="file" name="nivelVideo[]" accept="video/*">
        </div>
        <div class="campo-nivel">
            <label>Documento del nivel:</label>
            <input type="file" name="nivelDocumento[]">
        </div>
    `;
    contenedorNiveles.appendChild(nuevoNivel);
}
    </script>
</head>
<body>
    <h2>Registrar Nuevo Curso</h2>
<form action="procesar_curso.php" method="POST" enctype="multipart/form-data">
    <!-- Los campos básicos del curso -->
    <input type="text" name="tituloCurso" placeholder="Título del Curso" required>
    <textarea name="descripcionCurso" placeholder="Descripción del Curso" required></textarea>
    <select name="categoria" required>
        <option value="">Selecciona una categoría</option>
        <?php 
        while($categoria = $resultadoCategorias->fetch_assoc()) {
            echo "<option value='{$categoria['idCategoria']}'>{$categoria['nombre']}</option>";
        }
        ?>
    </select>
    <input type="number" name="costoTotal" step="0.01" placeholder="Costo Total del Curso" required>

    <!-- Contenedor de niveles -->
    <div id="niveles">
        <!-- Los niveles se agregarán aquí -->
    </div>

    <button type="button" onclick="agregarNivel()">Agregar Nivel</button>
    <button type="submit">Registrar Curso</button>
</form>
</body>
</html>