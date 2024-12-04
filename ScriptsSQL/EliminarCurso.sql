DELIMITER //
CREATE PROCEDURE EliminarCurso(IN p_idCurso INT, IN p_idInstructor INT)
BEGIN
    -- Verify the course belongs to the instructor
    IF EXISTS (
        SELECT 1 
        FROM cursos 
        WHERE idCurso = p_idCurso 
        AND idInstructor = p_idInstructor 
        AND estado = 'activo'
    ) THEN
        -- Update course status to inactive
        UPDATE cursos 
        SET estado = 'inactivo' 
        WHERE idCurso = p_idCurso;
        
        SELECT 1 AS resultado; -- Indica éxito
    ELSE
        SELECT 0 AS resultado; -- Indica fallo
    END IF;
END //
DELIMITER ;