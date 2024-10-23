DELIMITER $$

CREATE PROCEDURE RegisterUser(
    IN p_nombre VARCHAR(50),
    IN p_apellidos VARCHAR(50),
    IN p_genero ENUM('hombre', 'mujer', 'otro'),
    IN p_fechaNacimiento DATE,
    IN p_email VARCHAR(100),
    IN p_contrasena VARCHAR(255),
    IN p_avatar BLOB,
    IN p_rol ENUM('docente', 'alumno')
)
BEGIN
    -- Insertar el nuevo usuario
    INSERT INTO usuarios (nombre, apellidos, genero, fechaNacimiento, email, contraseña, avatar, fechaDeRegistro, rol, estado)
    VALUES (p_nombre, p_apellidos, p_genero, p_fechaNacimiento, p_email, p_contrasena, p_avatar, NOW(), p_rol, 'activo');
END$$

DELIMITER ;