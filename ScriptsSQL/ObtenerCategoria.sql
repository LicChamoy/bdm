DELIMITER //

CREATE PROCEDURE ObtenerCategoria()
BEGIN
    SELECT DISTINCT categoria 
    FROM (
        SELECT c.categoria 
        FROM VistaCursosDisponibles c
        GROUP BY c.idCurso, c.categoria
    ) AS CategoriasUnicas
    ORDER BY categoria;
END //

DELIMITER ;

call ObtenerCategoria