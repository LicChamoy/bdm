CREATE VIEW VistaDetalleCurso AS 
SELECT 
    c.idCurso,
    c.titulo AS tituloCurso,
    c.descripcion AS descripcionCurso,
    c.costoTotal,
    cat.nombre AS categoriaNombre,
    u.nombre AS instructorNombre,
    u.apellidos AS instructorApellidos,
    (SELECT AVG(calificacion) FROM interaccionesCurso 
     WHERE idCurso = c.idCurso AND calificacion IS NOT NULL) AS promedioCalificaciones
FROM cursos c
JOIN usuarios u ON c.idInstructor = u.idUsuario
JOIN categorias cat ON c.categoria = cat.idCategoria
WHERE c.estado = 'activo';