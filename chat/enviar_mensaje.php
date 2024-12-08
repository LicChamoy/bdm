<?php
require_once '../metodos/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $chat_id = $_POST['chat_id'];
    $contenido = $_POST['texto'];
    $autor_id = $_POST['idEmisor'];

    var_dump($_POST);
    
    insertarMensaje($chat_id, $contenido, $autor_id);

    header("Location: historial_chat.php?chat_id=$chat_id");
    exit;
} else {
    header("Location: error.php");
    exit;
}

function insertarMensaje($chat_id, $contenido, $autor_id) {
    $conexionBD = new ConexionBD();
    $conexion = $conexionBD->obtenerConexion();

    // Preparar la llamada al procedimiento almacenado
    $stmt = $conexion->prepare("CALL InsertarMensaje(?, ?, ?)");
    $stmt->bind_param("isi", $chat_id, $contenido, $autor_id);
    
    // Ejecutar el procedimiento
    $stmt->execute();

    // Cerrar la conexión
    $stmt->close();
    $conexionBD->cerrarConexion();
}
?>
