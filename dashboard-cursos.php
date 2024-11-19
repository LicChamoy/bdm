<?php
session_start();
require_once 'metodos/conexion.php';

$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Obtener categorías para el filtro
$queryCategorias = "SELECT DISTINCT categoria FROM VistaCursosDisponibles";
$categorias = $mysqli->query($queryCategorias);

// Aplicar filtros si existen
$where = "WHERE 1=1";
if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $categoria = $mysqli->real_escape_string($_GET['categoria']);
    $where .= " AND categoria = '$categoria'";
}

if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $buscar = $mysqli->real_escape_string($_GET['buscar']);
    $where .= " AND (titulo LIKE '%$buscar%' OR descripcion LIKE '%$buscar%')";
}

// Obtener cursos
$query = "SELECT * FROM VistaCursosDisponibles $where ORDER BY fechaCreacion DESC";
$cursos = $mysqli->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Cursos Disponibles</title>
    <style>
        .cursos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .curso-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .curso-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 4px;
        }
        .curso-precio {
            font-size: 1.2em;
            color: #2c5282;
            font-weight: bold;
        }
        .curso-instructor {
            color: #666;
            font-style: italic;
        }
        .filtros {
            padding: 20px;
            background: #f7f7f7;
            margin-bottom: 20px;
        }
        .calificacion {
            color: #f6c23e;
        }
        .categoria-badge {
            background: #4299e1;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
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
                <img src="/api/placeholder/400/320" alt="<?php echo htmlspecialchars($curso['titulo']); ?>">
                <h3><?php echo htmlspecialchars($curso['titulo']); ?></h3>
                <p><?php echo htmlspecialchars(substr($curso['descripcion'], 0, 150)) . '...'; ?></p>
                <div class="categoria-badge">
                    <?php echo htmlspecialchars($curso['categoria']); ?>
                </div>
                <p class="curso-instructor">
                    Por: <?php echo htmlspecialchars($curso['instructor'] . ' ' . $curso['instructor_apellidos']); ?>
                </p>
                <div class="calificacion">
                    <?php
                    $calificacion = round($curso['promedio_calificaciones']);
                    for($i = 0; $i < 5; $i++) {
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
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="ver-curso.php?id=<?php echo $curso['idCurso']; ?>" 
                       class="btn-ver-curso">Ver detalles</a>
                <?php else: ?>
                    <a href="login.php" class="btn-login">Inicia sesión para ver más</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <?php if($cursos->num_rows == 0): ?>
        <p class="no-cursos">No se encontraron cursos que coincidan con tu búsqueda.</p>
    <?php endif; ?>
</body>
</html>
