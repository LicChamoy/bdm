DELIMITER $$

CREATE PROCEDURE ActualizarProgreso(
    IN p_idUsuario INT,
    IN p_idCurso INT
)
BEGIN
    -- Declaración de variables locales
    DECLARE total_niveles INT DEFAULT 0;
    DECLARE niveles_completados INT DEFAULT 0;
    DECLARE nuevo_progreso DECIMAL(5, 2) DEFAULT 0;

    -- Contar el total de niveles del curso
    SELECT COUNT(*) 
    INTO total_niveles
    FROM niveles
    WHERE idCurso = p_idCurso;

    -- Contar los niveles completados por el usuario
    SELECT COUNT(*) 
    INTO niveles_completados
    FROM nivelesCompletados
    WHERE idUsuario = p_idUsuario
      AND idNivel IN (
          SELECT idNivel 
          FROM niveles 
          WHERE idCurso = p_idCurso
      );

    -- Calcular el progreso como porcentaje
    IF total_niveles > 0 THEN
        SET nuevo_progreso = (niveles_completados / total_niveles) * 100;
    ELSE
        SET nuevo_progreso = 0;
    END IF;

    -- Actualizar el progreso en la tabla interaccionesCurso
    UPDATE interaccionesCurso
    SET progresoDelCurso = nuevo_progreso
    WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;
END$$

DELIMITER ;
