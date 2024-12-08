DELIMITER $$

CREATE PROCEDURE InsertarMensaje(
    IN p_chat_id INT,
    IN p_contenido TEXT,
    IN p_autor_id INT
)
BEGIN
    INSERT INTO mensaje (chat_id, contenido, idAutor)
    VALUES (p_chat_id, p_contenido, p_autor_id);
END $$

DELIMITER ;
