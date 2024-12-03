<?php
session_start();
require_once 'metodos/conexion.php';

// Verificar si hay un usuario logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: metodos/login.php");
    exit;
}

// Verificar si se proporcionó un ID de curso
if (!isset($_GET['idCurso'])) {
    header("Location: metodos/dashboard-docente.php");
    exit;
}

$idCurso = intval($_GET['idCurso']);
$userId = $_SESSION['user_id'];

// Conexión a la base de datos
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Obtener detalles del curso
$query = "SELECT * FROM VistaCursosDisponibles WHERE idCurso = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $idCurso);
$stmt->execute();
$curso = $stmt->get_result()->fetch_assoc();

if (!$curso) {
    header("Location: metodos/dashboard-docente.php");
    exit;
}

// Obtener niveles del curso
$queryNiveles = "SELECT * FROM niveles WHERE idCurso = ? ORDER BY idNivel";
$stmtNiveles = $mysqli->prepare($queryNiveles);
$stmtNiveles->bind_param("i", $idCurso);
$stmtNiveles->execute();
$niveles = $stmtNiveles->get_result();

// Verificar si el usuario ya está inscrito
$queryInscripcion = "SELECT * FROM interaccionesCurso WHERE idUsuario = ? AND idCurso = ?";
$stmtInscripcion = $mysqli->prepare($queryInscripcion);
$stmtInscripcion->bind_param("ii", $userId, $idCurso);
$stmtInscripcion->execute();
$inscripcion = $stmtInscripcion->get_result()->fetch_assoc();

// Procesar compra si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    $idNivel = isset($_POST['nivel']) ? intval($_POST['nivel']) : null;
    $formaPago = $_POST['formaPago'];
    $mensaje = '';

    $stmt = $mysqli->prepare("CALL RealizarCompraCurso(?, ?, ?, ?, @mensaje)");
    $stmt->bind_param("iiis", $userId, $idCurso, $idNivel, $formaPago);
    
    if ($stmt->execute()) {
        // Recuperar el mensaje de la variable de sesión @mensaje
        $result = $mysqli->query("SELECT @mensaje AS mensaje");
        if ($result) {
            $row = $result->fetch_assoc();
            $mensaje = $row['mensaje'];
        } else {
            $mensaje = "Error al recuperar el mensaje.";
        }
        
        if ($mensaje === 'Compra realizada con éxito') {
            header("Location: ver-curso.php?idCurso=$idCurso&success=1");
            exit;
        }
    }
    
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($curso['titulo']); ?></title>
    <style>
        .curso-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .curso-header {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
        }
        .curso-imagen {
            flex: 0 0 400px;
        }
        .curso-imagen img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .curso-info {
            flex: 1;
        }
        .precio-badge {
            background-color: #2c5282;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            margin: 10px 0;
        }
        .niveles-lista {
            margin-top: 30px;
        }
        .nivel-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-comprar {
            background-color: #2c5282;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn-comprar:hover {
            background-color: #2a4365;
        }
        .btn-comprar:disabled {
            background-color: #cbd5e0;
            cursor: not-allowed;
        }
        .mensaje {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .mensaje.exito {
            background-color: #c6f6d5;
            color: #2f855a;
        }
        .mensaje.error {
            background-color: #fed7d7;
            color: #c53030;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 20px;
            width: 80%;
            max-width: 500px;
            border-radius: 8px;
        }
        .close {
            float: right;
            cursor: pointer;
            font-size: 28px;
        }
    </style>
</head>
<body>
    <div class="curso-container">
        <?php if (isset($_GET['success'])): ?>
            <div class="mensaje exito">
                ¡Compra realizada con éxito!
            </div>
        <?php endif; ?>

        <?php if (isset($mensaje) && $mensaje): ?>
            <div class="mensaje error">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <div class="curso-header">
            <div class="curso-imagen">
                <img src="<?php echo htmlspecialchars($curso['imagen'] ?? '/api/placeholder/400/320'); ?>" 
                     alt="<?php echo htmlspecialchars($curso['titulo']); ?>">
            </div>
            <div class="curso-info">
                <h1><?php echo htmlspecialchars($curso['titulo']); ?></h1>
                <p><?php echo htmlspecialchars($curso['descripcion']); ?></p>
                <p>Instructor: <?php echo htmlspecialchars($curso['instructor'] . ' ' . $curso['instructor_apellidos']); ?></p>
                <p>Categoría: <?php echo htmlspecialchars($curso['categoria']); ?></p>
                <div class="calificacion">
                    <?php
                    $calificacion = round($curso['promedio_calificaciones']);
                    for ($i = 0; $i < 5; $i++) {
                        echo $i < $calificacion ? '★' : '☆';
                    }
                    ?> 
                    (<?php echo number_format($curso['promedio_calificaciones'], 1); ?>)
                </div>
                <div class="precio-badge">
                    Curso completo: $<?php echo number_format($curso['costoTotal'], 2); ?> MXN
                </div>
                <?php if (!$inscripcion): ?>
                    <button class="btn-comprar" onclick="mostrarModalCompra(null)">
                        Comprar curso completo
                    </button>
                <?php else: ?>
                    <p>Ya estás inscrito en este curso</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="niveles-lista">
            <h2>Niveles del curso</h2>
            <?php while ($nivel = $niveles->fetch_assoc()): ?>
                <div class="nivel-card">
                    <div>
                        <h3><?php echo htmlspecialchars($nivel['titulo']); ?></h3>
                        <p><?php echo htmlspecialchars($nivel['descripcion']); ?></p>
                    </div>
                    <div>
                        <div class="precio-badge">
                            $<?php echo number_format($nivel['costoNivel'], 2); ?> MXN
                        </div>
                        <?php if (!$inscripcion): ?>
                            <button class="btn-comprar" 
                                    onclick="mostrarModalCompra(<?php echo $nivel['idNivel']; ?>)">
                                Comprar este nivel
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Modal de compra -->
        <div id="modalCompra" class="modal">
            <div class="modal-content">
                <span class="close" onclick="cerrarModalCompra()">&times;</span>
                <h2>Confirmar compra</h2>
                <form method="POST">
                    <input type="hidden" id="nivelSeleccionado" name="nivel">
                    <div>
                        <label for="formaPago">Forma de pago:</label>
                        <select name="formaPago" id="formaPago" required>
                            <option value="tarjeta">Tarjeta de crédito/débito</option>
                            <option value="paypal">PayPal</option>
                            <option value="transferencia">Transferencia bancaria</option>
                        </select>
                    </div>
                    <button type="submit" name="comprar" class="btn-comprar">
                        Confirmar compra
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function mostrarModalCompra(nivelId) {
            document.getElementById('modalCompra').style.display = 'block';
            document.getElementById('nivelSeleccionado').value = nivelId || '';
        }

        function cerrarModalCompra() {
            document.getElementById('modalCompra').style.display = 'none';
        }

        // Cerrar modal al hacer clic fuera de él
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalCompra')) {
                cerrarModalCompra();
            }
        }
    </script>
</body>
</html>