DELIMITER $$

CREATE FUNCTION CheckAndBlockUser(p_email VARCHAR(100)) 
RETURNS VARCHAR(255)
BEGIN
    DECLARE current_attempts INT;
    DECLARE result_message VARCHAR(255);

    -- Consultar los intentos actuales (puede estar en una tabla separada o como campo adicional)
    SELECT intentos INTO current_attempts 
    FROM usuarios
    WHERE email = p_email;

    -- Si el usuario no existe, retornar mensaje de error
    IF current_attempts IS NULL THEN
        RETURN 'Error: Usuario no encontrado.';
    END IF;

    -- Incrementar intentos fallidos
    SET current_attempts = current_attempts + 1;

    -- Actualizar intentos en la tabla
    UPDATE usuarios 
    SET intentos = current_attempts
    WHERE email = p_email;

    -- Si los intentos alcanzan 3, bloquear al usuario
    IF current_attempts >= 3 THEN
        UPDATE usuarios 
        SET estado = 'baja'
        WHERE email = p_email;
        SET result_message = 'Usuario bloqueado tras 3 intentos fallidos.';
    ELSE
        SET result_message = CONCAT('Intentos fallidos: ', current_attempts);
    END IF;

    RETURN result_message;
END$$

DELIMITER ;
