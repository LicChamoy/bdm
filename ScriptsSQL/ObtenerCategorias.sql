DELIMITER $$

CREATE PROCEDURE ObtenerCategorias()
BEGIN
    SELECT 
        idCategoria, 
        nombre_categoria, 
        descripcion_categoria, 
        nombre_creador, 
        total_cursos
    FROM vista_categorias_cursos;
END $$

DELIMITER ;
