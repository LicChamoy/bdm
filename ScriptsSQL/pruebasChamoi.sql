INSERT INTO nivelesCompletados (idUsuario, idNivel)
VALUES (5, 8); -- 1 es el ID del usuario y 101 es el ID del nivel completado

-- Llamar al procedimiento para actualizar el progreso del curso
CALL ActualizarProgreso(5, 11); -- 1 es el ID del usuario, 10 es el ID del curso


select * from niveles;

truncate table interaccionesCurso;

select * from interaccionesCurso;

SELECT * FROM usuarios WHERE idUsuario = 9 AND rol = 'docente' AND estado = 'activo';
SELECT * FROM cursos WHERE idInstructor = 9;

SELECT * 
FROM interaccionesCurso ic
JOIN cursos c ON ic.idCurso = c.idCurso
WHERE c.idInstructor = 9;

SELECT * 
FROM cursos 
WHERE idInstructor = 9 AND fechaCreacion BETWEEN '2000-01-01' AND date_add('2024-12-09', interval 1 day) - interval 1 second;

SELECT * 
FROM interaccionesCurso ic
JOIN cursos c ON ic.idCurso = c.idCurso
WHERE c.idInstructor = 9 AND ic.fechaInscripcion BETWEEN '2000-01-01' AND '2024-12-09';

SELECT * 
FROM cursos 
WHERE idInstructor = 9 AND estado = 'activo';

SELECT * 
FROM cursoCategoria cc
JOIN cursos c ON cc.idCurso = c.idCurso
WHERE c.idInstructor = 9;

SELECT * 
FROM cursos 
WHERE idCurso = 16 AND fechaCreacion BETWEEN '2000-01-01' AND '2024-12-09';


CALL ObtenerNivelesCurso(14);

CALL ObtenerResumenCursos(9, '2000-01-01', '2024-12-09', 0, 1);
CALL ObtenerIngresosPorFormaPago(9, '2000-01-01', '2024-12-09', 0, 1);
CALL ObtenerDetalleCurso(16, '2000-01-01', '2024-12-09', 1);

UPDATE usuarios
set estado = 'baja'
where idUsuario = 6;

select* from cursos;

SELECT * FROM VistaCursosDisponibles WHERE idInstructor = 5;

call ObtenerProgresoCurso(5,11);

call GetCoursesByUser(5);

insert into usuarios (nombre, apellidos, genero, fechaNacimiento, email, contraseña, rol) values ('admin','admin','otro', '2024-11-06', 'admin', 'admin', 'admin');

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
        GROUP_CONCAT(DISTINCT c.categoria SEPARATOR ', ') AS categorias
    FROM 
        VistaCursosDisponibles c
            GROUP BY 
        c.idCurso, c.titulo, c.descripcion, c.imagen, 
        c.costoTotal, c.fechaCreacion, c.promedio_calificaciones, 
        c.total_niveles, c.instructor
    ORDER BY 
        c.fechaCreacion DESC;

SET GLOBAL sort_buffer_size = 256000000;

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
