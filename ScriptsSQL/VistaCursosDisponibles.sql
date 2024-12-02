CREATE OR REPLACE VIEW VistaCursosDisponibles AS
SELECT 
    c.idCurso,
    c.titulo,
    c.descripcion,
    c.imagen,  -- Asegúrate de que esta línea esté presente
    c.costoTotal,
    c.calificacion,
    u.nombre AS instructor,
    u.apellidos AS instructor_apellidos,
    GROUP_CONCAT(cat.nombre SEPARATOR ', ') AS categoria,
    c.fechaCreacion,
    (SELECT COUNT(*) FROM niveles n WHERE n.idCurso = c.idCurso) AS total_niveles,
    (SELECT AVG(i.calificacion) 
     FROM interaccionesCurso i 
     WHERE i.idCurso = c.idCurso AND i.calificacion IS NOT NULL) AS promedio_calificaciones,
    c.idInstructor -- Asegúrate de incluir esto
FROM 
    cursos c
JOIN 
    usuarios u ON c.idInstructor = u.idUsuario
JOIN 
    cursoCategoria cc ON c.idCurso = cc.idCurso
JOIN 
    categorias cat ON cc.idCategoria = cat.idCategoria
WHERE 
    c.estado = 'activo'
GROUP BY 
    c.idCurso;
