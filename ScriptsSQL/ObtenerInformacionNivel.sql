DELIMITER $$

CREATE PROCEDURE ObtenerInformacionNivel(
    IN p_idNivel INT
)
BEGIN
    SELECT titulo_nivel, descripcion_nivel, url_video
    FROM vistavervideo
    WHERE idNivel = p_idNivel;
END $$

DELIMITER ;
