DELIMITER $$

CREATE PROCEDURE VerificarInscripcion(IN p_userId INT, IN p_idCurso INT)
BEGIN
    SELECT * 
    FROM interaccionesCurso 
    WHERE idUsuario = p_userId 
    AND idCurso = p_idCurso;
END $$

DELIMITER ;
