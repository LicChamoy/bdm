CREATE VIEW vistamiscursos AS
    SELECT 
        ic.idUsuario AS idUsuario,
        c.idCurso AS idCurso,
        c.titulo AS titulo_curso,
        c.descripcion AS descripcion_curso,
        c.imagen AS imagen_curso,
        u.nombre AS instructor,
        ic.progresoDelCurso AS progresoTotal,
        ic.fechaUltimaActividad AS ultimoAcceso,
        n.idNivel AS idNivel,
        n.titulo AS titulo_nivel,
        n.descripcion AS descripcion_nivel,
        n.documento AS recursos,
        n.video AS videoUrl,
        cat.nombre AS categoria
    FROM
        (((((judav.interaccionescurso ic
        JOIN judav.cursos c ON (ic.idCurso = c.idCurso))
        JOIN judav.usuarios u ON (c.idInstructor = u.idUsuario))
        JOIN judav.niveles n ON (c.idCurso = n.idCurso))
        JOIN judav.cursocategoria cc ON (c.idCurso = cc.idCurso))
        JOIN judav.categorias cat ON (cc.idCategoria = cat.idCategoria))