CREATE VIEW VistaCursosDisponibles AS
SELECT 
    c.idCurso,
    c.titulo,
    c.descripcion,
    c.costoTotal,
    c.calificacion,
    u.nombre AS instructor,
    u.apellidos AS instructor_apellidos,
    cat.nombre AS categoria,
    c.fechaCreacion,
    (SELECT COUNT(*) FROM niveles n WHERE n.idCurso = c.idCurso) as total_niveles,
    (SELECT AVG(i.calificacion) 
     FROM interaccionesCurso i 
     WHERE i.idCurso = c.idCurso AND i.calificacion IS NOT NULL) as promedio_calificaciones
FROM cursos c
JOIN usuarios u ON c.idInstructor = u.idUsuario
JOIN categorias cat ON c.categoria = cat.idCategoria
WHERE c.estado = 'activo';