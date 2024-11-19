DELIMITER $$

CREATE PROCEDURE registrar_categoria(
    IN nombre_categoria VARCHAR(100),
    IN descripcion_categoria TEXT,
    IN id_creador INT
)
BEGIN
    INSERT INTO categorias (nombre, descripcion, idCreador)
    VALUES (nombre_categoria, descripcion_categoria, id_creador);
END $$

DELIMITER ;
