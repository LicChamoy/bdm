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
$stmt = $mysqli->prepare("CALL ObtenerDetallesCurso(?)");
$stmt->bind_param("i", $idCurso);
$stmt->execute();
$curso = $stmt->get_result()->fetch_assoc();
if (!$curso) {
    header("Location: metodos/dashboard-docente.php");
    exit;
}

$stmt->close();
$mysqli->next_result();

// Obtener niveles del curso
$stmtNiveles = $mysqli->prepare("CALL ObtenerNivelesCurso(?)");
$stmtNiveles->bind_param("i", $idCurso);
$stmtNiveles->execute();
$niveles = $stmtNiveles->get_result();

$stmtNiveles->close();
$mysqli->next_result();

// Verificar inscripción del usuario
$stmtInscripcion = $mysqli->prepare("CALL VerificarInscripcion(?, ?)");
$stmtInscripcion->bind_param("ii", $userId, $idCurso);
$stmtInscripcion->execute();
$inscripcion = $stmtInscripcion->get_result()->fetch_assoc();

$stmtInscripcion->close();
$mysqli->next_result();

// Procesar compra si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comprar'])) {
    $idNivel = isset($_POST['nivel']) ? intval($_POST['nivel']) : null;
    $formaPago = $_POST['formaPago'];


    if ($idNivel == 0){
        $idNivel =null;
    }

    // Obtener costo e instructor
    $stmtCosto = $mysqli->prepare("CALL ObtenerCostoEInstructor(?, ?)");
    $stmtCosto->bind_param("ii", $idCurso, $idNivel);
    $stmtCosto->execute();

    // Obtener los resultados directamente
    $result = $stmtCosto->get_result();
    if ($row = $result->fetch_assoc()) {
        $monto = $row['monto'];
        $idInstructor = $row['idInstructor'];
    } else {
        // Manejar el caso donde no hay resultado
        die("No se encontraron datos para el curso y nivel especificados.");
    }

    $stmtCosto->close();
    $mysqli->next_result();

    var_dump($idCurso, $idNivel, $monto, $idInstructor);

    $stmtCompra = $mysqli->prepare("CALL RealizarCompraCurso(?, ?, ?, ?)");
    $stmtCompra->bind_param("iiis", $userId, $idCurso, $idNivel, $formaPago);

    if ($stmtCompra->execute()) {
        $result = $stmtCompra->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            $mensaje = $row['mensaje'];

            if ($mensaje === 'Compra realizada con éxito') {
                header("Location: ver-curso.php?idCurso=$idCurso&success=1");
                exit;
            }
        } else {
            $mensaje = "Error al procesar la compra.";
        }
    }
    $stmtCompra->close();
    $mysqli->next_result();
}

$mysqli->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($curso['titulo']); ?></title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .curso-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .curso-header {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .curso-imagen {
            flex: 0 0 400px;
            border-radius: 10px;
            overflow: hidden;
        }
        .curso-imagen img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }
        .curso-info {
            flex: 1;
        }
        h1, h2 {
            color: #2c5282;
            font-size: 32px;
            margin-bottom: 15px;
        }
        p {
            font-size: 16px;
            line-height: 1.6;
            color: #555;
        }
        .precio-badge {
            background-color: #2c5282;
            color: white;
            padding: 12px 20px;
            border-radius: 50px;
            display: inline-block;
            margin-top: 15px;
            font-weight: bold;
            font-size: 18px;
        }
        .niveles-lista {
            margin-top: 40px;
        }
        .nivel-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease;
        }
        .nivel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .nivel-card .precio-badge {
            background-color: #38a169;
            color: white;
        }
        .btn-comprar {
            background-color: #2c5282;
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-comprar:hover {
            background-color: #2a4365;
        }
        .btn-comprar:disabled {
            background-color: #cbd5e0;
            cursor: not-allowed;
        }
        .mensaje {
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
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
            z-index: 9999;
        }
        .modal-content {
            background-color: white;
            margin: 15% auto;
            padding: 25px;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 30px;
            color: #aaa;
        }
        .close:hover {
            color: #333;
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
            <?php 
            if ($curso['imagen']) {
                $cursoimagen_base64 = base64_encode($curso['imagen']);
                $cursoimagen_base64 = "data:image/jpeg;base64," . $cursoimagen_base64;
            } else {
                $cursoimagen_base64 = '';
            }
            ?>
            <img src="<?php echo $cursoimagen_base64; ?>" alt="<?php echo htmlspecialchars($curso['titulo']); ?>">
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
            <?php if ($_SESSION['user_rol'] !== 'docente'): ?>
                <?php if (!$inscripcion): ?>
                    <button class="btn-comprar" onclick="mostrarModalCompra(null)">
                        Comprar curso completo
                    </button>
                <?php else: ?>
                    <p>Ya estás inscrito en este curso</p>
                <?php endif; ?>

                <div style="margin-top: 20px;">
                    <button class="btn-comprar" type="button"
                            onclick="location.href='chat/contactar_instructor.php?idInstructor=<?php echo $curso['idInstructor']; ?>'">
                        Contactar al instructor
                    </button>
                </div>
            <?php else: ?>
                <p></p>
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
                    <?php if ($_SESSION['user_rol'] !== 'docente'): ?>
                        <?php if (!$inscripcion): ?>
                            <button class="btn-comprar" onclick="mostrarModalCompra(<?php echo $nivel['idNivel']; ?>)">
                                Comprar este nivel
                            </button>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>Como docente, no puedes comprar cursos.</p>
                    <?php endif; ?>
                </div>
            </div>
            <a href="metodos/dashboard-docente.php" class="btn">Dashboard</a>
        <?php endwhile; ?>
    </div>

    <?php
    include 'metodos/comentarios.php';
    mostrarComentrios($idCurso);
    ?>

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
                    </select>
                </div>
                <button class="btn-comprar" type="submit">
                    Confirmar compra
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function mostrarModalCompra(nivelId) {
        document.getElementById('nivelSeleccionado').value = nivelId;
        document.getElementById('modalCompra').style.display = 'block';
    }

    function cerrarModalCompra() {
        document.getElementById('modalCompra').style.display = 'none';
    }
</script>

</body>
</html>
