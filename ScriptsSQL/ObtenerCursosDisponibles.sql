DELIMITER //

CREATE PROCEDURE ObtenerCursosDisponibles(
    IN p_instructorId INT,
    IN p_categoria VARCHAR(255),
    IN p_buscar VARCHAR(255)
)
BEGIN

	SET GLOBAL sort_buffer_size = 256000000;
    SET @sql = CONCAT('
        SELECT 
            c.idCurso,
            c.titulo,
            c.descripcion,
            c.imagen,
            c.costoTotal,
            c.fechaCreacion,
            c.promedio_calificaciones,
            c.total_niveles,
            c.instructor AS instructor,
            GROUP_CONCAT(DISTINCT c.categoria SEPARATOR '', '') AS categorias
        FROM 
            VistaCursosDisponibles c
        WHERE 
            1=1 ');

    IF p_instructorId IS NOT NULL THEN
        SET @sql = CONCAT(@sql, ' AND c.idInstructor = ', p_instructorId);
    END IF;

    IF p_categoria IS NOT NULL AND p_categoria <> '' THEN
        SET @sql = CONCAT(@sql, ' AND c.categoria = ''', p_categoria, '''');
    END IF;

    IF p_buscar IS NOT NULL AND p_buscar <> '' THEN
        SET @sql = CONCAT(@sql, ' AND (c.titulo LIKE ''%', p_buscar, '%'' OR c.descripcion LIKE ''%', p_buscar, '%'')');
    END IF;

    SET @sql = CONCAT(@sql, ' GROUP BY 
            c.idCurso, c.titulo, c.descripcion, c.imagen, 
            c.costoTotal, c.fechaCreacion, c.promedio_calificaciones, 
            c.total_niveles, c.instructor
        ORDER BY 
            c.fechaCreacion DESC');

    PREPARE stmt FROM @sql;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;
