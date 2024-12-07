INSERT INTO nivelesCompletados (idUsuario, idNivel)
VALUES (5, 8); -- 1 es el ID del usuario y 101 es el ID del nivel completado

-- Llamar al procedimiento para actualizar el progreso del curso
CALL ActualizarProgreso(5, 11); -- 1 es el ID del usuario, 10 es el ID del curso


select * from niveles;

select * from usuarios;

select* from cursos;

call ObtenerProgresoCurso(5,11);

call GetCoursesByUser(5);


ALTER TABLE interaccionesCurso
ADD CONSTRAINT UNIQUE (idUsuario, idCurso);


CALL ObtenerComentariosCurso(11);

call RegistrarComentarioCurso(5, 8);

SELECT 
    ic.idUsuario,
    ic.idCurso,
    c.titulo AS nombreCurso,
    COALESCE(niveles_completados, 0) AS nivelesCompletados,
    total_niveles AS totalNiveles,
    ROUND((COALESCE(niveles_completados, 0) / total_niveles) * 100, 2) AS progresoPorcentaje
FROM 
    interaccionesCurso ic
INNER JOIN 
    cursos c ON ic.idCurso = c.idCurso
LEFT JOIN 
    (SELECT 
         n.idCurso, 
         COUNT(*) AS total_niveles
     FROM 
         niveles n
     GROUP BY 
         n.idCurso) t_niveles
ON 
    ic.idCurso = t_niveles.idCurso
LEFT JOIN 
    (SELECT 
         nc.idUsuario, 
         n.idCurso, 
         COUNT(*) AS niveles_completados
     FROM 
         nivelesCompletados nc
     INNER JOIN 
         niveles n ON nc.idNivel = n.idNivel
     GROUP BY 
         nc.idUsuario, n.idCurso) t_completados
ON 
    ic.idUsuario = t_completados.idUsuario AND ic.idCurso = t_completados.idCurso
WHERE 
    ic.idUsuario = 5 AND ic.idCurso = 11;
