DELIMITER $$

CREATE PROCEDURE ObtenerUltimoMensaje(IN p_usuario_id INT, IN p_otro_usuario_id INT)
BEGIN
    DECLARE v_chat_id INT;

    -- Obtener el chat_id entre los dos usuarios
    SELECT idChat INTO v_chat_id
    FROM chat 
    WHERE (idEmisor = p_usuario_id AND idReceptor = p_otro_usuario_id) 
       OR (idEmisor = p_otro_usuario_id AND idReceptor = p_usuario_id);

    -- Obtener el último mensaje en el chat
    IF v_chat_id IS NOT NULL THEN
        SELECT contenido, timestamp
        FROM mensaje
        WHERE chat_id = v_chat_id
        ORDER BY timestamp DESC
        LIMIT 1;
    ELSE
        SELECT NULL AS contenido, NULL AS timestamp;  -- No hay chat
    END IF;
END $$

DELIMITER ;
