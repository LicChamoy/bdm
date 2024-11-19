CREATE VIEW VistaCursosDocente AS
SELECT 
    c.idCurso,
    c.titulo,
    c.descripcion,
    c.costoTotal,
    c.estado,
    c.fechaCreacion,
    COUNT(DISTINCT n.idNivel) as total_niveles,
    COUNT(DISTINCT i.idUsuario) as total_alumnos,
    AVG(i.calificacion) as promedio_calificaciones
FROM cursos c
LEFT JOIN niveles n ON c.idCurso = n.idCurso
LEFT JOIN interaccionesCurso i ON c.idCurso = i.idCurso
GROUP BY c.idCurso;