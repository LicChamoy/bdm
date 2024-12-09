DELIMITER $$

CREATE PROCEDURE ObtenerDetallesCurso(IN p_idCurso INT)
BEGIN
    SELECT * 
    FROM VistaCursosDisponibles 
    WHERE idCurso = p_idCurso;
END $$

DELIMITER ;
