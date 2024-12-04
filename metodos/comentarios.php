<?php
function mostrarComentrios($idCurso){
    require 'conexion.php';

    $conexionBD = new ConexionBD();
    $mysqli = $conexionBD->obtenerConexion();

    $query = "CALL ObtenerComentariosCurso(?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $idCurso);
    $stmt->execute();
    
    $result = $stmt->get_result();
    $comentarios = [];
    
    while($row = $result->fetch_assoc()){
        $comentarios[] = $row;
    
    }
    
    $stmt->close();
    $conexionBD->cerrarConexion();

    
    if (count($comentarios) > 0){
        echo '<ul>';
        foreach ($comentarios as $comentario){
            echo '<li>';
            echo '<strong>Usuario:</strong>' . htmlspecialchars($comentario['nombreUsuario']) . '<br>';
            echo '<strong>Calificacion:</strong>' . htmlspecialchars($comentario['calificacion']) . '<br>';
            echo '<strong>Fecha:</strong>' . htmlspecialchars($comentario['FechaComentario']) . '<br>';
            echo '<strong>Texto:</strong>' . htmlspecialchars($comentario['textoComentrio']). '<br>';
            echo '</li><hr>';
        }
        echo '</ul>';
    }else{
        echo'<p>No hay comentarios disponibles para este curso</p>';
    }
}
