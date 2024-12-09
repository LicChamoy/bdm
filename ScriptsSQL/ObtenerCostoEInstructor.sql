DELIMITER $$

CREATE PROCEDURE ObtenerCostoEInstructor(
    IN p_idCurso INT,
    IN p_idNivel INT
)
BEGIN
    IF p_idNivel IS NULL THEN
        SELECT costoTotal AS monto, idInstructor
        FROM cursos
        WHERE idCurso = p_idCurso;
    ELSE
        SELECT n.costoNivel AS monto, c.idInstructor
        FROM niveles n
        JOIN cursos c ON n.idCurso = c.idCurso
        WHERE n.idNivel = p_idNivel AND n.idCurso = p_idCurso;
    END IF;
END $$

DELIMITER ;
