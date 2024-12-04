<?php
session_start();
require_once 'conexion.php';

// Verificar si el usuario está logueado y es docente
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Modificar la consulta para obtener categorías consolidadas
$queryCategorias = "
    SELECT DISTINCT categoria 
    FROM (
        SELECT c.categoria 
        FROM VistaCursosDisponibles c
        GROUP BY c.idCurso, c.categoria
    ) AS CategoriasUnicas
    ORDER BY categoria";
$categorias = $mysqli->query($queryCategorias);

// Inicializar la cláusula WHERE
$where = ' WHERE 1=1';

// Filtrar por categoría
if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $categoria = $mysqli->real_escape_string($_GET['categoria']);
    $where .= " AND c.categoria = '$categoria'";
}

// Filtrar por búsqueda
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $buscar = $mysqli->real_escape_string($_GET['buscar']);
    $where .= " AND (c.titulo LIKE '%$buscar%' OR c.descripcion LIKE '%$buscar%')";
}

// Modificar consulta para obtener cursos con categorías consolidadas
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
    c.instructor AS instructor,
    GROUP_CONCAT(DISTINCT c.categoria SEPARATOR ', ') AS categorias
FROM 
    VistaCursosDisponibles c
$where
GROUP BY 
    c.idCurso, c.titulo, c.descripcion, c.imagen, 
    c.costoTotal, c.fechaCreacion, c.promedio_calificaciones, 
    c.total_niveles, c.instructor
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
    <title>Judav Academy</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4a5bd6;
            --secondary-color: #6a78e0;
            --background-color: #f4f6fb;
            --text-color: #2c3e50;
            --card-shadow: 0 4px 6px rgba(74, 91, 214, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .page-title {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 30px;
            font-weight: 600;
        }

        .nav-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .btn {
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s, transform 0.2s;
            font-weight: 500;
            text-align: center;
        }

        .btn:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }

        .filtros {
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            padding: 20px;
            margin-bottom: 30px;
        }

        .filtros form {
            display: flex;
            justify-content: center;
            gap: 15px;
            align-items: center;
        }

        .filtros input,
        .filtros select {
            padding: 10px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            flex-grow: 1;
        }

        .cursos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }

        .curso-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: transform 0.3s;
        }

        .curso-card:hover {
            transform: scale(1.03);
        }

        .curso-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .curso-content {
            padding: 15px;
        }

        .curso-titulo {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .curso-categorias {
            background-color: var(--background-color);
            color: var(--primary-color);
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8em;
            margin-bottom: 10px;
        }

        .curso-detalles {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .no-cursos {
            text-align: center;
            color: var(--primary-color);
            padding: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title">Judav Academy</h1>

        <div class="nav-buttons">
            <a href="registrar_curso.php" class="btn">Registrar Nuevo Curso</a>
            <a href="../mis_cursos.php" class="btn">Mis Cursos</a>
            <a href="../mensajes-instructor.php" class="btn">Bandeja de Mensajes</a>
            <a href="../kardex.php" class="btn">Kardex</a>
            <a href="../perfil.php" class="btn">Perfil</a>
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
                
                <button type="submit" class="btn">Filtrar</button>
            </form>
        </div>

        <div class="cursos-grid">
            <?php while($curso = $cursos->fetch_assoc()): ?>
                <div class="curso-card">
                <img src="<?php echo htmlspecialchars($curso['imagen']); ?>" 
                alt="<?php echo htmlspecialchars($curso['titulo']); ?>">
                    <div class="curso-content">
                        <h3 class="curso-titulo"><?php echo htmlspecialchars($curso['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($curso['descripcion'], 0, 100)) . '...'; ?></p>
                        
                        <div class="curso-categorias">
                            <?php echo htmlspecialchars($curso['categorias']); ?>
                        </div>
                        
                        <div class="curso-detalles">
                            <span>Por: <?php echo htmlspecialchars($curso['instructor']); ?></span>
                            <span>$<?php echo number_format($curso['costoTotal'], 2); ?> MXN</span>
                        </div>
                        
                        <div class="curso-calificacion">
                            <?php
                            $calificacion = round($curso['promedio_calificaciones'] ?? 0);
                            for ($i = 0; $i < 5; $i++) {
                                echo $i < $calificacion ? '★' : '☆';
                            }
                            ?>
                        </div>
                        
                        <a href="../ver-curso.php?idCurso=<?php echo $curso['idCurso']; ?>" class="btn">Ver Detalles</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <?php if ($cursos->num_rows == 0): ?>
            <p class="no-cursos">No se encontraron cursos que coincidan con tu búsqueda.</p>
        <?php endif; ?>
    </div>
</body>
</html>