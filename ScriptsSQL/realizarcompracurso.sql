DELIMITER $$

CREATE PROCEDURE RealizarCompraCurso(
    IN p_idUsuario INT,
    IN p_idCurso INT,
    IN p_idNivel INT,  -- NULL si es curso completo
    IN p_formaPago VARCHAR(50)
)
BEGIN
    DECLARE v_monto DECIMAL(10,2);
    DECLARE v_existe_inscripcion INT;
        DECLARE v_mensaje VARCHAR(255);


    SELECT COUNT(*) INTO v_existe_inscripcion
    FROM interaccionesCurso
    WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;

    IF v_existe_inscripcion > 0 THEN
        SET v_mensaje = 'Ya estás inscrito en este curso';
    ELSE

        IF p_idNivel IS NULL THEN

            SELECT costoTotal, id  INTO v_monto
            FROM cursos
            WHERE idCurso = p_idCurso;
        ELSE

			SELECT n.costoNivel, c.idInstructor
			INTO v_monto, v_idInstructor
			FROM niveles n
			JOIN cursos c ON n.idCurso = c.idCurso
			WHERE n.idNivel = p_idNivel AND n.idCurso = p_idCurso;
        END IF;


        INSERT INTO interaccionesCurso (
            idUsuario,
            idCurso,
            fechaInscripcion,
            progresoDelCurso,
            estadoAlumno,
            montoPorVenta,
            formaPago
        ) VALUES (
            p_idUsuario,
            p_idCurso,
            NOW(),
            0,
            'en progreso',
            v_monto,
            p_formaPago
        );


        SET v_mensaje = v_monto;
    END IF;

    -- Devolver el mensaje como resultado
    SELECT v_mensaje AS mensaje;
END $$