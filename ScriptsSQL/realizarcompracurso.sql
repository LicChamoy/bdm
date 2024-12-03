DELIMITER $$

CREATE PROCEDURE RealizarCompraCurso(
    IN p_idUsuario INT,
    IN p_idCurso INT,
    IN p_idNivel INT,  -- NULL si es curso completo
    IN p_formaPago VARCHAR(50),
    OUT p_mensaje VARCHAR(255)
)
BEGIN
    DECLARE v_monto DECIMAL(10,2);
    DECLARE v_existe_inscripcion INT;


    SELECT COUNT(*) INTO v_existe_inscripcion
    FROM interaccionesCurso
    WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;

    IF v_existe_inscripcion > 0 THEN
        SET p_mensaje = 'Ya estás inscrito en este curso';
    ELSE

        IF p_idNivel IS NULL THEN

            SELECT costoTotal INTO v_monto
            FROM cursos
            WHERE idCurso = p_idCurso;
        ELSE

            SELECT costoNivel INTO v_monto
            FROM niveles
            WHERE idNivel = p_idNivel AND idCurso = p_idCurso;
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

        SET p_mensaje = 'Compra realizada con éxito';
    END IF;
    
    SET @mensaje = p_mensaje;
END $$