DELIMITER $$

CREATE PROCEDURE ObtenerNivelesCurso(IN p_idCurso INT)
BEGIN
    SELECT * 
    FROM niveles 
    WHERE idCurso = p_idCurso 
    ORDER BY idNivel;
END $$

DELIMITER ;
