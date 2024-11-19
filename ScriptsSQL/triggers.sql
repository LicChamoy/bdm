DELIMITER $$

CREATE TRIGGER actualizar_fecha_ultima_actividad
BEFORE UPDATE ON interaccionesCurso
FOR EACH ROW
BEGIN
    IF OLD.progresoDelCurso <> NEW.progresoDelCurso THEN
        SET NEW.fechaUltimaActividad = NOW();
    END IF;
END $$

DELIMITER ;

DELIMITER $$

CREATE TRIGGER validar_inscripcion_unica
BEFORE INSERT ON interaccionesCurso
FOR EACH ROW
BEGIN
    IF (EXISTS (SELECT 1 FROM interaccionesCurso WHERE idUsuario = NEW.idUsuario AND idCurso = NEW.idCurso)) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El usuario ya está inscrito en este curso.';
    END IF;
END $$

DELIMITER ;

