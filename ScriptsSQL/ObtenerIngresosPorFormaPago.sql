DELIMITER //

CREATE PROCEDURE ObtenerIngresosPorFormaPago(
    IN p_idInstructor INT,
    IN p_fechaInicio DATE,
    IN p_fechaFin DATE,
    IN p_idCategoria INT,
    IN p_soloActivos BOOLEAN
)
BEGIN
    SELECT 
        ic.formaPago,
        COALESCE(SUM(ic.montoPorVenta), 0) AS totalIngresos
    FROM 
        interaccionesCurso ic
    JOIN 
        cursos c ON ic.idCurso = c.idCurso
    WHERE 
        c.idInstructor = p_idInstructor
        AND c.fechaCreacion BETWEEN p_fechaInicio AND p_fechaFin
        AND (p_soloActivos = 0 OR c.estado = 'activo')
        AND (p_idCategoria = 0 OR c.idCurso IN (
            SELECT cc.idCurso
            FROM cursoCategoria cc
            WHERE cc.idCategoria = p_idCategoria
        ))
    GROUP BY 
        ic.formaPago;
END //

DELIMITER ;
