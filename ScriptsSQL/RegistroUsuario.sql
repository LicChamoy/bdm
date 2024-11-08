DELIMITER $$

CREATE PROCEDURE RegisterUserOrManageUser(
    IN p_accion ENUM('registrar', 'actualizar', 'baja', 'login'),
    IN p_nombre VARCHAR(50),
    IN p_apellidos VARCHAR(50),
    IN p_genero ENUM('hombre', 'mujer', 'otro'),
    IN p_fechaNacimiento DATE,
    IN p_email VARCHAR(100),
    IN p_contrasena VARCHAR(255),
    IN p_avatar MEDIUMBLOB,
    IN p_rol ENUM('docente', 'alumno', 'admin'),
    OUT p_resultado VARCHAR(255)
)
BEGIN
    DECLARE userExists INT DEFAULT 0;

    -- Verificar si el usuario ya existe (por email)
    SELECT COUNT(*) INTO userExists FROM usuarios WHERE email = p_email;

    -- Seleccionar la acción
    IF p_accion = 'registrar' THEN
        IF userExists = 0 THEN
            -- Insertar el nuevo usuario
            INSERT INTO usuarios (nombre, apellidos, genero, fechaNacimiento, email, contraseña, avatar, fechaDeRegistro, rol, estado)
            VALUES (p_nombre, p_apellidos, p_genero, p_fechaNacimiento, p_email, p_contrasena, p_avatar, NOW(), p_rol, 'activo');
            
            SET p_resultado = 'Registro exitoso.';
        ELSE
            SET p_resultado = 'Error: el usuario ya existe.';
        END IF;

    ELSEIF p_accion = 'actualizar' THEN
        IF userExists = 1 THEN
        -- Actualizar datos del usuario
        UPDATE usuarios
        SET 
            nombre = p_nombre,
            apellidos = p_apellidos,
            genero = p_genero,
            fechaNacimiento = p_fechaNacimiento,
            avatar = p_avatar,
            fechaDeUltimoCambio = NOW(),
            -- Solo actualizar la contraseña si no está vacía
            contraseña = CASE 
                        WHEN p_contrasena IS NOT NULL AND p_contrasena != '' THEN p_contrasena 
                        ELSE contraseña 
                       END
        WHERE email = p_email;
            SET p_resultado = 'Actualización exitosa.';
        ELSE
            SET p_resultado = 'Error: el usuario no existe.';
        END IF;

    ELSEIF p_accion = 'baja' THEN
        IF userExists = 1 THEN
            -- Cambiar el estado del usuario a 'baja'
            UPDATE usuarios
            SET estado = 'baja',
                fechaDeUltimoCambio = NOW()
            WHERE email = p_email;

            SET p_resultado = 'El usuario ha sido dado de baja.';
        ELSE
            SET p_resultado = 'Error: el usuario no existe.';
        END IF;

    ELSEIF p_accion = 'login' THEN
        IF userExists = 1 THEN
            -- Comprobación de las credenciales de inicio de sesión
            SELECT COUNT(*) INTO userExists
            FROM usuarios
            WHERE email = p_email AND contraseña = p_contrasena AND estado = 'activo';

            IF userExists = 1 THEN
				SELECT 'Inicio de sesión exitoso.' AS resultado, idUsuario, nombre, apellidos, genero, fechaNacimiento, rol, avatar, email
                FROM usuarios
                WHERE email = p_email AND estado = 'activo';            ELSE
                SET p_resultado = 'Error: credenciales incorrectas.';
            END IF;
        ELSE
            SET p_resultado = 'Error: el usuario no existe.';
        END IF;

    ELSE
        SET p_resultado = 'Error: acción no válida.';
    END IF;

END$$

DELIMITER ;
