DELIMITER $$

CREATE PROCEDURE ObtenerProgresoCurso(
    IN p_idUsuario INT,
    IN p_idCurso INT
)
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

    -- Retornar el resultado como una tabla
    SELECT 
        p_idUsuario AS idUsuario,
        p_idCurso AS idCurso,
        nivelesCompletados AS nivelesCompletados,
        totalNiveles AS totalNiveles,
        progresoPorcentaje AS progresoPorcentaje;
END$$

DELIMITER ;
