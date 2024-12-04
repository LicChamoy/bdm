DELIMITER $$

CREATE FUNCTION ObtenerProgresoCursoFunc(
    p_idUsuario INT,
    p_idCurso INT
)
RETURNS DECIMAL(5, 2)
DETERMINISTIC  -- Indica que la función siempre produce el mismo resultado para los mismos argumentos
BEGIN
    DECLARE totalNiveles INT DEFAULT 0;
    DECLARE nivelesCompletados INT DEFAULT 0;
    DECLARE progresoPorcentaje DECIMAL(5, 2) DEFAULT 0.00;

    -- Calcular el total de niveles del curso
    SELECT COUNT(*)
    INTO totalNiveles
    FROM niveles
    WHERE idCurso = p_idCurso;

    -- Calcular los niveles completados por el usuario
    SELECT COUNT(*)
    INTO nivelesCompletados
    FROM nivelesCompletados nc
    INNER JOIN niveles n ON nc.idNivel = n.idNivel
    WHERE nc.idUsuario = p_idUsuario AND n.idCurso = p_idCurso;

    -- Calcular el porcentaje de progreso
    IF totalNiveles > 0 THEN
        SET progresoPorcentaje = (nivelesCompletados / totalNiveles) * 100;
    END IF;

    RETURN progresoPorcentaje;
END$$

DELIMITER ;
