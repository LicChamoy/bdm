DELIMITER $$

CREATE PROCEDURE GetCourseDetails(
    IN p_idCurso INT,
    IN p_idUsuario INT
)
BEGIN
    SELECT * 
    FROM vista_cursos_usuario 
    WHERE idCurso = p_idCurso AND idUsuario = p_idUsuario;
END$$

DELIMITER ;

