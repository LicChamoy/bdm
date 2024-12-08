DELIMITER $$

CREATE PROCEDURE ObtenerChats(IN p_usuario_id INT)
BEGIN
    SELECT DISTINCT 
        IF(c.idEmisor = p_usuario_id, c.idReceptor, c.idEmisor) AS otro_usuario_id,
        u.nombre, u.apellidos, c.idChat
    FROM chat c
    INNER JOIN usuarios u ON u.idUsuario = IF(c.idEmisor = p_usuario_id, c.idReceptor, c.idEmisor)
    WHERE c.idEmisor = p_usuario_id OR c.idReceptor = p_usuario_id;
END $$

DELIMITER ;
