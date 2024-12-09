DELIMITER $$

CREATE PROCEDURE ObtenerCategoriasUsuario(
    IN p_idUsuario INT
)
BEGIN
    SELECT DISTINCT categoria 
    FROM VistaMisCursos 
    WHERE idUsuario = p_idUsuario
    ORDER BY categoria;
END $$

DELIMITER ;
