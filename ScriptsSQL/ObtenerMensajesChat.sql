DELIMITER $$

CREATE PROCEDURE ObtenerMensajesChat(
    IN p_chat_id INT
)
BEGIN
    SELECT 
        m.contenido AS contenido, 
        u.nombre AS usuario, 
        m.timestamp AS timestamp
    FROM 
        mensaje m
    JOIN 
        usuarios u ON m.idAutor = u.idUsuario
    WHERE 
        m.chat_id = p_chat_id
    ORDER BY 
        m.timestamp;
END $$

DELIMITER ;
