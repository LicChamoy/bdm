<?php
// Conexión a la base de datos
session_start();
require_once 'metodos/conexion.php';


$conexion = new ConexionBD();
$mysqli = $conexion->obtenerConexion();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['imagen'])) {
    // Verificar si se subió una imagen
    if ($_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $imagen = file_get_contents($_FILES['imagen']['tmp_name']); // Convertir la imagen a binario
        $imagen_tamano = $_FILES['imagen']['size'];
        $imagen_tipo = $_FILES['imagen']['type'];

        // Verificar que sea una imagen
        if (strpos($imagen_tipo, 'image') === 0) {
            // Actualizar la tabla de cursos
            $stmt = $mysqli->prepare("UPDATE cursos SET imagen = ?");
            $stmt->bind_param("b", $imagen);
            $stmt->send_long_data(0, $imagen);

            if ($stmt->execute()) {
                echo "<p style='color: green;'>¡Imagen actualizada en todos los cursos correctamente!</p>";
            } else {
                echo "<p style='color: red;'>Error al actualizar las imágenes: " . $stmt->error . "</p>";
            }
            $stmt->close();
        } else {
            echo "<p style='color: red;'>El archivo subido no es una imagen válida.</p>";
        }
    } else {
        echo "<p style='color: red;'>Error al subir el archivo. Código de error: " . $_FILES['imagen']['error'] . "</p>";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Imagen de Cursos</title>
</head>
<body>
    <h1>Actualizar Imagen para Todos los Cursos</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="imagen">Selecciona una imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*" required>
        <br><br>
        <button type="submit">Actualizar Imágenes</button>
    </form>
</body>
</html>
