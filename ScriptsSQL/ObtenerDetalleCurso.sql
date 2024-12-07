DELIMITER //

CREATE PROCEDURE ObtenerDetalleCurso(
    IN p_idCurso INT,
    IN p_fechaInicio DATE,
    IN p_fechaFin DATE,
    IN p_soloActivos BOOLEAN
)
BEGIN
    SELECT 
        c.titulo AS nombreCurso,
        u.nombre AS nombreAlumno,
        ic.fechaInscripcion,
        ic.progresoDelCurso AS nivelAvance,
        ic.fechaUltimaActividad,
        ic.montoPorVenta AS precioPagado,
        ic.formaPago
    FROM 
        interaccionesCurso ic
    JOIN 
        cursos c ON ic.idCurso = c.idCurso
    JOIN 
        usuarios u ON ic.idUsuario = u.idUsuario
    WHERE 
        c.idCurso = p_idCurso
        AND c.fechaCreacion BETWEEN p_fechaInicio AND p_fechaFin
        AND (p_soloActivos = 0 OR c.estado = 'activo')
    ORDER BY 
        ic.fechaInscripcion DESC;
END //

DELIMITER ;
