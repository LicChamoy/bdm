CREATE PROCEDURE RegistrarCursoConNiveles(
    IN accion ENUM('registrar', 'actualizar'),
    IN tituloCurso VARCHAR(255),
    IN descripcionCurso TEXT,
    IN idInstructor INT,
    IN categoria INT,
    IN costoTotal DECIMAL(10,2),
    IN nivelTitulo JSON,
    IN nivelDescripcion JSON,
    IN nivelCosto JSON,
    IN nivelVideo JSON,
    IN nivelDocumento JSON,
    OUT resultado VARCHAR(255)
)
BEGIN
    DECLARE idCurso INT;
    IF accion = 'registrar' THEN
        -- Insertar un nuevo curso
        INSERT INTO cursos (titulo, descripcion, idInstructor, categoria, costoTotal, estado)
        VALUES (tituloCurso, descripcionCurso, idInstructor, categoria, costoTotal, 'activo');

        -- Obtener el ID del curso insertado
        SET idCurso = LAST_INSERT_ID();

        -- Insertar niveles asociados al curso
        DECLARE i INT DEFAULT 0;
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
        SELECT idCurso AS idCurso;
    ELSEIF accion = 'actualizar' THEN
        -- Actualizar un curso existente
        UPDATE cursos
        SET titulo = tituloCurso, descripcion = descripcionCurso, categoria = categoria, costoTotal = costoTotal
        WHERE idCurso = idCurso;

        SET resultado = 'Curso actualizado exitosamente.';
    ELSE
        SET resultado = 'Acción no válida.';
    END IF;
END $$
DELIMITER ;