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

// Obtener categorías
$queryCategorias = "SELECT DISTINCT nombre AS categoria FROM categorias"; // Cambiado para obtener nombres de categorías
$categorias = $mysqli->query($queryCategorias);


// Filtrar por categoría
if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $categoria = $mysqli->real_escape_string($_GET['categoria']);
    $where .= " AND cat.nombre = '$categoria'"; // Cambiado para referirse al nombre de categoría
}

// Filtrar por búsqueda
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $buscar = $mysqli->real_escape_string($_GET['buscar']);
    $where .= " AND (c.titulo LIKE '%$buscar%' OR c.descripcion LIKE '%$buscar%')";
}

// Obtener cursos
$query = "
SELECT 
    c.idCurso,
    c.titulo,
    c.descripcion,
    c.imagen,
    c.costoTotal,
    c.fechaCreacion,
    c.promedio_calificaciones,
    c.total_niveles,
    c.categoria,
    CONCAT(u.nombre, ' ', u.apellidos) AS instructor
FROM 
    VistaCursosDisponibles c
JOIN 
    usuarios u ON c.idInstructor = u.idUsuario
ORDER BY 
    c.fechaCreacion DESC";

$cursos = $mysqli->query($query);
if (!$cursos) {
    die("Error en la consulta: " . $mysqli->error);
}
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Dashboard Docente</title>
        <style>
            .btn-registrar {
                display: block;
                margin: 20px auto;
                padding: 10px 20px;
                background-color: #2c5282;
                color: white;
                border: none;
                border-radius: 4px;
                text-align: center;
                text-decoration: none;
                font-size: 1em;
            }
            .btn-registrar:hover {
                background-color: #2a4365;
            }
            .cursos-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 20px;
                padding: 20px;
            }
            .curso-card {
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 15px;
                text-align: center;
                background-color: white;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                transition: transform 0.2s;
            }
            .curso-card:hover {
                transform: translateY(-5px);
            }
            .curso-card img {
                max-width: 100%;
                height: 200px;
                object-fit: cover;
                border-radius: 8px;
            }
            .categoria-badge {
                background-color: #e2e8f0;
                padding: 5px 10px;
                border-radius: 15px;
                display: inline-block;
                margin: 10px 0;
                font-size: 0.9em;
            }
            .calificacion {
                color: #f6e05e;
                font-size: 1.2em;
                margin: 10px 0;
            }
            .curso-precio {
                font-weight: bold;
                color: #2c5282;
                font-size: 1.1em;
            }
            .btn-ver-detalles {
                display: inline-block;
                padding: 8px 16px;
                background-color: #2c5282;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                margin-top: 10px;
                transition: background-color 0.3s;
            }
            .btn-ver-detalles:hover {
                background-color: #2a4365;
            }
            .filtros {
                padding: 20px;
                background-color: #f7fafc;
                border-radius: 8px;
                margin: 20px;
            }
            .filtros form {
                display: flex;
                gap: 10px;
                align-items: center;
                flex-wrap: wrap;
            }
            .filtros input[type="text"],
            .filtros select {
                padding: 8px;
                border: 1px solid #e2e8f0;
                border-radius: 4px;
            }
            .filtros button {
                padding: 8px 16px;
                background-color: #2c5282;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            .no-cursos {
                text-align: center;
                padding: 20px;
                color: #718096;
            }
            </style>
    </head>
    <body>
        <h1>Dashboard - Docente</h1>

        <div class="dashboard-buttons">
            <a href="registrar_curso.php" class="btn-registrar">Registrar Nuevo Curso</a>
            <a href="../mis_cursos.php" class="btn-registrar">Mis Cursos</a>
        </div>

        <div class="filtros">
            <form method="GET" action="">
                <input type="text" name="buscar" placeholder="Buscar cursos..." 
                    value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>">
                
                <select name="categoria">
                    <option value="">Todas las categorías</option>
                    <?php while($cat = $categorias->fetch_assoc()): ?>
                        <option value="<?php echo htmlspecialchars($cat['categoria']); ?>"
                                <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['categoria']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($cat['categoria']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <button type="submit">Filtrar</button>
            </form>
        </div>

        <div class="cursos-grid">
            <?php while($curso = $cursos->fetch_assoc()): ?>
                <div class="curso-card">
                    <img src="<?php echo htmlspecialchars($curso['imagen'] ?? '../img/placeholder.jpg'); ?>" 
                        alt="<?php echo htmlspecialchars($curso['titulo']); ?>">
                    <h3><?php echo htmlspecialchars($curso['titulo']); ?></h3>
                    <p><?php echo htmlspecialchars(substr($curso['descripcion'], 0, 150)) . '...'; ?></p>
                    <div class="categoria-badge">
                        <?php echo htmlspecialchars($curso['categorias']); ?> <!-- Asegúrate de que se muestre aquí -->
                    </div>
                    <p class="curso-instructor">
                        Por: <?php echo htmlspecialchars($curso['instructor'] . ' ' . $curso['instructor_apellidos']); ?>
                    </p>
                    <div class="calificacion">
                        <?php
                        $calificacion = round($curso['promedio_calificaciones'] ?? 0);
                        for ($i = 0; $i < 5; $i++) {
                            echo $i < $calificacion ? '★' : '☆';
                        }
                        ?>
                    </div>
                    <p class="curso-precio">
                        $<?php echo number_format($curso['costoTotal'], 2); ?> MXN
                    </p>
                    <p>
                        <?php echo $curso['total_niveles']; ?> niveles
                    </p>
                    <a href="../ver-curso.php?idCurso=<?php echo $curso['idCurso']; ?>" class="btn-ver-detalles">Ver Detalles</a>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($cursos->num_rows == 0): ?>
            <p class="no-cursos">No se encontraron cursos que coincidan con tu búsqueda.</p>
        <?php endif; ?>
    </body>
</html>