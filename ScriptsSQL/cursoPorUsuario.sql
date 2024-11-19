DELIMITER $$

CREATE PROCEDURE GetCoursesByUser(
    IN p_userId INT
)
BEGIN
    -- Seleccionar los cursos del usuario desde la vista
    SELECT * 
    FROM vista_cursos_usuario
    WHERE idUsuario = p_userId;
END$$

DELIMITER ;
