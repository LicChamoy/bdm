<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Verificar si el usuario está logueado y es docente
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] !== 'docente') {
    die("Acceso no autorizado");
}

require_once 'conexion.php';
$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

try {
    // Validar que se hayan enviado todos los datos necesarios
    if (!isset($_POST['tituloCurso'], $_POST['descripcionCurso'], $_POST['categoria'], $_POST['costoTotal'])) {
        throw new Exception("Faltan datos obligatorios del curso");
    }

    // Validar que haya al menos un nivel
    if (!isset($_POST['nivelTitulo']) || empty($_POST['nivelTitulo'])) {
        throw new Exception("Debe agregar al menos un nivel al curso");
    }

    // Iniciar transacción
    $mysqli->begin_transaction();

    // Preparar datos para el procedimiento almacenado
    $tituloCurso = $_POST['tituloCurso'];
    $descripcionCurso = $_POST['descripcionCurso'];
    $idInstructor = $_SESSION['user_id'];
    $categoria = $_POST['categoria'];
    $costoTotal = $_POST['costoTotal'];

    // Convertir arrays de niveles a JSON
    $nivelTitulo = json_encode($_POST['nivelTitulo']);
    $nivelDescripcion = json_encode($_POST['nivelDescripcion']);
    $nivelCosto = json_encode($_POST['nivelCosto']);
    
    // Arrays para almacenar información de archivos
    $nivelVideos = [];
    $nivelDocumentos = [];

    // Procesar archivos de video y documentos
    for ($i = 0; $i < count($_POST['nivelTitulo']); $i++) {
        // Procesar video
        if (isset($_FILES['nivelVideo']['tmp_name'][$i]) && !empty($_FILES['nivelVideo']['tmp_name'][$i])) {
            $videoContent = file_get_contents($_FILES['nivelVideo']['tmp_name'][$i]);
            $nivelVideos[] = base64_encode($videoContent);
        } else {
            $nivelVideos[] = null;
        }

        // Procesar documento
        if (isset($_FILES['nivelDocumento']['tmp_name'][$i]) && !empty($_FILES['nivelDocumento']['tmp_name'][$i])) {
        // Modificar esta línea en procesar_curso.php
        $documentoNombre = time() . '_' . $_FILES['nivelDocumento']['name'][$i];
        // Cambiar la ruta para que sea absoluta
        move_uploaded_file(
        $_FILES['nivelDocumento']['tmp_name'][$i],
        '../documentos/' . $documentoNombre  // Nota el '../' para subir un nivel
        );
            $nivelDocumentos[] = $documentoNombre;
        } else {
            $nivelDocumentos[] = null;
        }
    }

    // Convertir arrays de archivos a JSON
    $nivelVideosJson = json_encode($nivelVideos);
    $nivelDocumentosJson = json_encode($nivelDocumentos);

    // Llamar al procedimiento almacenado
    $query = "CALL RegistrarCursoConNiveles(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @resultado)";
    $stmt = $mysqli->prepare($query);
    $accion = 'registrar';
    
    $stmt->bind_param(
        'sssidssssss',
        $accion,
        $tituloCurso,
        $descripcionCurso,
        $idInstructor,
        $categoria,
        $costoTotal,
        $nivelTitulo,
        $nivelDescripcion,
        $nivelCosto,
        $nivelVideosJson,
        $nivelDocumentosJson
    );

    $stmt->execute();
    
    // Obtener el resultado
    $resultQuery = $mysqli->query("SELECT @resultado as resultado");
    $resultado = $resultQuery->fetch_assoc();

    // Confirmar la transacción
    $mysqli->commit();

    // Redirigir con mensaje de éxito
    $_SESSION['mensaje'] = "Curso registrado exitosamente";
    header("Location: mis_cursos.php");
    exit;

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $mysqli->rollback();
    $_SESSION['error'] = "Error al registrar el curso: " . $e->getMessage();
    header("Location: registrar_curso.php");
    exit;
} finally {
    $conexion->cerrarConexion();
}
?>