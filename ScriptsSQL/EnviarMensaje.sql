DELIMITER $$

CREATE PROCEDURE EnviarMensaje(
    IN p_idInstructor INT,
    IN p_idAlumno INT,
    IN p_mensaje TEXT
)
BEGIN
    DECLARE v_chat_id INT;

    -- Comprobar si ya existe un chat entre el alumno y el instructor
    SELECT idChat INTO v_chat_id
    FROM chat
    WHERE (idEmisor = p_idAlumno AND idReceptor = p_idInstructor) 
       OR (idEmisor = p_idInstructor AND idReceptor = p_idAlumno)
    LIMIT 1;

    -- Si no existe un chat, crear uno nuevo
    IF v_chat_id IS NULL THEN
        INSERT INTO chat (idEmisor, idReceptor) 
        VALUES (p_idAlumno, p_idInstructor);
        
        SET v_chat_id = LAST_INSERT_ID();  -- Obtener el ID del nuevo chat
    END IF;

    -- Insertar el mensaje en la tabla mensaje
    INSERT INTO mensaje (chat_id, idAutor, contenido) 
    VALUES (v_chat_id, p_idAlumno, p_mensaje);
END $$

DELIMITER ;
