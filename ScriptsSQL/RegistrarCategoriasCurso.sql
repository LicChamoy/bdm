DELIMITER $$

CREATE PROCEDURE RegistrarCategoriasCurso(
    IN p_idCurso INT,
    IN p_idUsuario INT,
    IN p_idCategoria INT
)
BEGIN
        -- Registrar la categoría al curso
        INSERT INTO cursoCategoria (idCurso, idCategoria)
        VALUES (p_idCurso, p_idCategoria);
        
END$$

DELIMITER ;
