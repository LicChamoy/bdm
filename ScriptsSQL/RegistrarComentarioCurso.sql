DELIMITER //

CREATE PROCEDURE RegistrarComentarioCurso (
    IN p_idUsuario INT,
    IN p_idCurso INT,
    IN p_textoComentario TEXT,
    IN p_calificacion INT
)
BEGIN
    DECLARE v_existeComentario INT;
    DECLARE v_inscrito INT;

    -- Verificar si el usuario está inscrito en el curso
    SELECT COUNT(*) INTO v_inscrito
    FROM interaccionesCurso
    WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;

    IF v_inscrito = 0 THEN
        -- El usuario no está inscrito en el curso
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El usuario no está inscrito en este curso.';
    ELSE
        -- Verificar si el usuario ya comentó en este curso
        SELECT COUNT(*) INTO v_existeComentario
        FROM interaccionesCurso
        WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso AND textoComentario IS NOT NULL;

        IF v_existeComentario > 0 THEN
            -- Ya existe un comentario, actualizarlo
            UPDATE interaccionesCurso
            SET textoComentario = p_textoComentario,
                calificacion = p_calificacion,
                fechaComentario = NOW(),
                estatusComentario = 'visible'
            WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;
        ELSE
            -- Insertar nuevo comentario
            UPDATE interaccionesCurso
            SET textoComentario = p_textoComentario,
                calificacion = p_calificacion,
                fechaComentario = NOW(),
                estatusComentario = 'visible'
            WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;
        END IF;
    END IF;
END //

DELIMITER ;

