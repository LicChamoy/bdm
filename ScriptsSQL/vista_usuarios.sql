CREATE OR REPLACE VIEW vista_usuarios AS
SELECT 
    u.idUsuario,
    u.nombre,
    u.apellidos,
    u.rol,
    u.fechaDeRegistro,
    CASE
        WHEN u.rol = 'alumno' THEN
            (SELECT COUNT(*) FROM interaccionesCurso ic WHERE ic.idUsuario = u.idUsuario AND ic.estadoAlumno = 'en progreso')
        ELSE NULL
    END AS cursosInscritos,
    CASE
        WHEN u.rol = 'alumno' THEN
            (SELECT COUNT(*) FROM interaccionesCurso ic WHERE ic.idUsuario = u.idUsuario AND ic.estadoAlumno = 'terminado')
        ELSE NULL
    END AS cursosTerminados,
    CASE
        WHEN u.rol = 'docente' THEN
            (SELECT COUNT(*) FROM cursos c WHERE c.idInstructor = u.idUsuario)
        ELSE NULL
    END AS cursosOfrecidos,
    CASE
        WHEN u.rol = 'docente' THEN
            (SELECT SUM(ic.montoPorVenta) FROM interaccionesCurso ic WHERE ic.idInstructor = u.idUsuario)
        ELSE NULL
    END AS ganancias
FROM usuarios u;
