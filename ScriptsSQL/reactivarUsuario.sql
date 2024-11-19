DELIMITER $$

CREATE PROCEDURE ReactivateUser(
    IN p_email VARCHAR(255)
)
BEGIN
    DECLARE result_message VARCHAR(255);

    -- Verificar si el usuario está bloqueado
    IF EXISTS (SELECT 1 FROM usuarios WHERE email = p_email AND estado = 'baja') THEN
        -- Reactivar el usuario
        UPDATE usuarios 
        SET estado = 'activo'
        WHERE email = p_email;

        SET result_message = 'Usuario reactivado exitosamente.';
    ELSE
        SET result_message = 'El usuario no está bloqueado o no existe.';
    END IF;

    -- Devolver el mensaje
    SELECT result_message;
END$$

DELIMITER ;
