DELIMITER //

CREATE PROCEDURE ObtenerCursos(
    IN instructorId INT,
    IN userRole ENUM('docente', 'alumno'),
    IN categoria VARCHAR(255),
    IN buscar VARCHAR(255)
)
BEGIN
    SET @where = '';

    IF userRole = 'docente' THEN
        SET @where = CONCAT(@where, ' WHERE c.idInstructor = ', instructorId);
    ELSE
        SET @where = CONCAT(@where, ' WHERE 1=1');
    END IF;

    IF categoria IS NOT NULL AND categoria <> '' THEN
        SET @where = CONCAT(@where, ' AND c.categoria = ''', categoria, '''');
    END IF;

    IF buscar IS NOT NULL AND buscar <> '' THEN
        SET @where = CONCAT(@where, ' AND (c.titulo LIKE ''%', buscar, '%'' OR c.descripcion LIKE ''%', buscar, '%'')');
    END IF;

    SET @query = CONCAT('SELECT 
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
            VistaCursosDisponibles c', @where,
        ' GROUP BY 
            c.idCurso, c.titulo, c.descripcion, c.imagen, 
            c.costoTotal, c.fechaCreacion, c.promedio_calificaciones, 
            c.total_niveles, c.instructor
        ORDER BY 
            c.fechaCreacion DESC');

    PREPARE stmt FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
END //

DELIMITER ;
