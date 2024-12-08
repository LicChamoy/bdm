DELIMITER $$

CREATE PROCEDURE ObtenerCategoriasConCursos()
BEGIN
    SELECT 
        nombre_categoria, 
        descripcion_categoria, 
        nombre_creador, 
        total_cursos
    FROM 
        vista_categorias_cursos;
END $$

DELIMITER ;
