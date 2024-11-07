DELIMITER $$

CREATE PROCEDURE GetUserDataByEmail(
    IN p_email VARCHAR(100)
)
BEGIN
    -- Recuperar los datos del usuario
    SELECT idUsuario, nombre, apellidos, genero, fechaNacimiento, rol
    FROM usuarios
    WHERE email = p_email AND estado = 'activo';
END$$

DELIMITER ;
