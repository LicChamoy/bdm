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

// Validar datos del formulario
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: registrar_curso.php");
    exit;
}

try {
    // Procesar imagen del curso (opcional)
    $imagen = null;
    if (!empty($_FILES['imagen']['name'])) {
        $imagenNombre = 'curso_' . uniqid() . '_' . $_FILES['imagen']['name'];
        $imagenRuta = 'uploads/cursos/' . $imagenNombre;
        
        // Crear directorio si no existe
        if (!is_dir('uploads/cursos')) {
            mkdir('uploads/cursos', 0755, true);
        }

        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $imagenRuta)) {
            throw new Exception("Error al subir la imagen del curso");
        }
        $imagen = $imagenRuta;
    }

    // Calcular costo total de todos los niveles
    $costoTotal = 0;
    foreach ($_POST['niveles'] as $nivel) {
        $costoTotal += floatval($nivel['costoNivel']);
    }

    // Preparar categorías
    $categorias = [];
    foreach ($_POST['categorias'] as $index => $categoria) {
        if ($categoria === 'nueva') {
            // Usar categoría nueva si se especificó
            $categorias[] = $_POST['nueva_categoria'][$index];
        } else {
            $categorias[] = $categoria;
        }
    }

    // Preparar niveles con archivos
    $niveles = [];
    foreach ($_POST['niveles'] as $index => $nivel) {
        $nivelData = [
            'titulo' => $nivel['titulo'],
            'descripcion' => $nivel['descripcion'],
            'costoNivel' => $nivel['costoNivel'],
            'documento' => null,
            'video' => null
        ];

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

        $niveles[] = $nivelData;
    }

    // Preparar datos para el procedimiento almacenado
    $categoriasJson = json_encode($categorias);
    $nivelesJson = json_encode($niveles);

    // Llamar al procedimiento almacenado
    $stmt = $mysqli->prepare("CALL InsertarCursoCompleto(?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssdiss", 
        $_POST['titulo'], 
        $_POST['descripcion'], 
        $imagen, 
        $costoTotal, 
        $_SESSION['user_id'], 
        $categoriasJson,
        $nivelesJson
    );
    $stmt->execute();

    // Verificar si hubo errores
    if ($stmt->error) {
        throw new Exception("Error al insertar el curso: " . $stmt->error);
    }

    // Redirigir con mensaje de éxito
    $_SESSION['mensaje'] = "Curso registrado exitosamente";
    header("Location: dashboard-docente.php");
    exit;

} catch (Exception $e) {
    // Mostrar mensaje de error
    $_SESSION['error'] = "Error al registrar el curso: " . $e->getMessage();
    header("Location: registrar_curso.php");
    exit;
}