DELIMITER $$

CREATE PROCEDURE RegistrarNivelCompletado(
    IN p_idUsuario INT,
    IN p_idNivel INT
)
BEGIN
    -- Inserta el registro solo si no existe
    INSERT IGNORE INTO nivelesCompletados (idUsuario, idNivel)
    VALUES (p_idUsuario, p_idNivel);
END$$

DELIMITER ;
