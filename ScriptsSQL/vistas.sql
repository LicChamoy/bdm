CREATE or replace VIEW UsuarioLoginView AS
SELECT idUsuario, email, contraseña, rol, estado
FROM usuarios;

CREATE VIEW UsuariosBloqueados AS
SELECT 
    nombre, 
    apellidos, 
    email 
FROM 
    usuarios 
WHERE 
    estado = 'baja';


CREATE VIEW vista_categorias_cursos AS
SELECT 
    c.nombre AS nombre_categoria,
    c.descripcion AS descripcion_categoria,
    CONCAT(u.nombre, ' ', u.apellidos) AS nombre_creador,
    COUNT(cc.idCurso) AS total_cursos
FROM 
    categorias c
LEFT JOIN 
    usuarios u ON c.idCreador = u.idUsuario
LEFT JOIN 
    cursoCategoria cc ON c.idCategoria = cc.idCategoria
GROUP BY 
    c.idCategoria;

CREATE VIEW vista_cursos_usuario AS
SELECT 
    ic.idUsuario,
    ic.idCurso,
    c.titulo AS cursoTitulo,
    ic.fechaInscripcion,
    ic.fechaUltimaActividad,
    ic.progresoDelCurso,
    ic.estadoAlumno,
    ic.fechaTerminoCurso,
    u.nombre AS instructorNombre,
    u.apellidos AS instructorApellidos
FROM 
    interaccionesCurso ic
JOIN 
    cursos c ON ic.idCurso = c.idCurso
JOIN 
    usuarios u ON c.idInstructor = u.idUsuario;