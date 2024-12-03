DELIMITER $$

CREATE PROCEDURE RegistrarCursoConNiveles(
    IN accion ENUM('registrar', 'actualizar'),
    IN tituloCurso VARCHAR(255),
    IN descripcionCurso TEXT,
    IN idInstructor INT,
    IN categorias JSON, -- Cambiar a JSON para manejar múltiples categorías
    IN costoTotal DECIMAL(10,2),
    IN nivelTitulo JSON,
    IN nivelDescripcion JSON,
    IN nivelCosto JSON,
    IN nivelVideo JSON,
    IN nivelDocumento JSON,
    IN imagenCurso VARCHAR(255),
    OUT resultado VARCHAR(255)
)
BEGIN
    -- Declaraciones deben ir inmediatamente después de BEGIN
    DECLARE idCurso INT;
    DECLARE i INT DEFAULT 0;

    IF accion = 'registrar' THEN
        -- Insertar un nuevo curso
        INSERT INTO cursos (titulo, descripcion, idInstructor, costoTotal, estado, imagen)
        VALUES (tituloCurso, descripcionCurso, idInstructor, costoTotal, 'activo', imagenCurso);

        -- Obtener el ID del curso insertado
        SET idCurso = LAST_INSERT_ID();

        -- Insertar las categorías asociadas al curso
        WHILE i < JSON_LENGTH(categorias) DO
            INSERT INTO cursoCategoria (idCurso, idCategoria)
            VALUES (
                idCurso,
                JSON_UNQUOTE(JSON_EXTRACT(categorias, CONCAT('$[', i, ']')))
            );
            SET i = i + 1;
        END WHILE;

        -- Insertar niveles asociados al curso
        SET i = 0; -- Reiniciar el índice para los niveles
        WHILE i < JSON_LENGTH(nivelTitulo) DO
            INSERT INTO niveles (idCurso, titulo, descripcion, costoNivel, video, documento)
            VALUES (
                idCurso,
                JSON_UNQUOTE(JSON_EXTRACT(nivelTitulo, CONCAT('$[', i, ']'))),
                JSON_UNQUOTE(JSON_EXTRACT(nivelDescripcion, CONCAT('$[', i, ']'))),
                JSON_UNQUOTE(JSON_EXTRACT(nivelCosto, CONCAT('$[', i, ']'))),
                JSON_UNQUOTE(JSON_EXTRACT(nivelVideo, CONCAT('$[', i, ']'))),
                JSON_UNQUOTE(JSON_EXTRACT(nivelDocumento, CONCAT('$[', i, ']')))
            );
            SET i = i + 1;
        END WHILE;

        SET resultado = 'Curso registrado y niveles insertados exitosamente.';
    ELSEIF accion = 'actualizar' THEN
        -- Actualizar un curso existente
        UPDATE cursos
        SET titulo = tituloCurso, descripcion = descripcionCurso, costoTotal = costoTotal
        WHERE idCurso = idCurso;

        -- Actualizar categorías (primero eliminar las existentes)
        DELETE FROM cursoCategoria WHERE idCurso = idCurso;

        -- Reinsertar categorías actualizadas
        SET i = 0; -- Reiniciar el índice
        WHILE i < JSON_LENGTH(categorias) DO
            INSERT INTO cursoCategoria (idCurso, idCategoria)
            VALUES (
                idCurso,
                JSON_UNQUOTE(JSON_EXTRACT(categorias, CONCAT('$[', i, ']')))
            );
            SET i = i + 1;
        END WHILE;

        SET resultado = 'Curso actualizado exitosamente.';
    ELSE
        SET resultado = 'Acción no válida.';
    END IF;
END $$

DELIMITER ;