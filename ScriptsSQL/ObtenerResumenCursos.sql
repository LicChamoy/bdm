DELIMITER //

CREATE PROCEDURE ObtenerResumenCursos(
    IN p_idInstructor INT,
    IN p_fechaInicio DATE,
    IN p_fechaFin DATE,
    IN p_idCategoria INT,
    IN p_soloActivos BOOLEAN
)
BEGIN
    SELECT 
        c.idCurso,
        c.titulo AS nombreCurso,
        COUNT(ic.idUsuario) AS alumnosInscritos,
        COALESCE(AVG(ic.progresoDelCurso), 0) AS nivelPromedio,
        COALESCE(SUM(ic.montoPorVenta), 0) AS ingresosTotales
    FROM 
        cursos c
    LEFT JOIN 
        interaccionesCurso ic ON c.idCurso = ic.idCurso
    WHERE 
        c.idInstructor = p_idInstructor
		AND c.fechaCreacion BETWEEN p_fechaInicio AND DATE_ADD(p_fechaFin, INTERVAL 1 DAY) - INTERVAL 1 SECOND
        AND (p_soloActivos = 0 OR c.estado = 'activo')
        AND (p_idCategoria = 0 OR c.idCurso IN (
            SELECT cc.idCurso
            FROM cursoCategoria cc
            WHERE cc.idCategoria = p_idCategoria
        ))
    GROUP BY 
        c.idCurso
    ORDER BY 
        c.fechaCreacion DESC;
END //

DELIMITER ;
