DELIMITER $$

CREATE PROCEDURE ObtenerCursosUsuario(
    IN p_idUsuario INT
)
BEGIN
    SELECT * 
    FROM VistaMisCursos 
    WHERE idUsuario = p_idUsuario
    ORDER BY categoria, idCurso, idNivel;
END $$

DELIMITER ;
