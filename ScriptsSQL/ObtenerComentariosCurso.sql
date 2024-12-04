DELIMITER //

CREATE PROCEDURE ObtenerComentariosCurso (
    IN p_idCurso INT
)
BEGIN
    SELECT 
        ic.idUsuario AS idUser,
        u.nombre AS nombreUsuario,
        ic.textoComentario AS textoComentario,
        ic.calificacion AS calificacion,
        ic.fechaComentario AS fechaComentario,
        ic.estatusComentario AS estatus
    FROM 
        interaccionesCurso ic
    JOIN 
        usuarios u ON ic.idUsuario = u.idUsuario
    WHERE 
        ic.idCurso = p_idCurso
    ORDER BY 
        ic.fechaComentario DESC;  -- Ordena los comentarios por fecha, más recientes primero
END //

DELIMITER ;
