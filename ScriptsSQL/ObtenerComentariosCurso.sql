DELIMITER //

CREATE PROCEDURE ObtenerComentariosCurso (
    IN p_idCurso INT
)
BEGIN
    SELECT 
        ic.idUsuario,
        u.nombre AS nombreUsuario,
        ic.textoComentario,
        ic.calificacion,
        ic.fechaComentario,
        ic.estatusComentario
    FROM 
        interaccionesCurso ic
    JOIN 
        usuarios u ON ic.idUsuario = u.idUsuario  -- Cambia esto al nombre real de tu tabla de usuarios
    WHERE 
        ic.idCurso = p_idCurso
    ORDER BY 
        ic.fechaComentario DESC;  -- Ordena los comentarios por fecha, más recientes primero
END //

DELIMITER ;
