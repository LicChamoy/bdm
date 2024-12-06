use judav;

select * from usuarios;

select * from cursos;


select * from chat;
select * from mensaje;

select * from niveles;
SELECT idUsuario, LENGTH(avatar) AS avatar_size FROM usuarios WHERE nombre = 'Diego';

SELECT idUsuario, idCurso, titulo_curso, imagen_curso FROM vistamiscursos;


SELECT m.texto AS contenido, u.nombre AS usuario, m.fecha AS timestamp
         FROM mensajes m
         JOIN usuarios u;

select * from cursoCategoria;

select ReactivateUser('diego78041@gmail.com');
ALTER TABLE niveles modify COLUMN video VARCHAR(255);
update usuarios
set rol = 'admin'
where rol = 'alumno';

CREATE TABLE usuarios (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50) NOT NULL,
    genero ENUM('hombre', 'mujer', 'otro') NOT NULL,
    fechaNacimiento DATE NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    contraseña VARCHAR(255) NOT NULL,
    avatar mediumblob,
    fechaDeRegistro DATETIME DEFAULT CURRENT_TIMESTAMP,
    fechaDeUltimoCambio DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    rol ENUM('docente', 'alumno', 'admin') NOT NULL,
    estado ENUM('activo', 'baja') NOT NULL DEFAULT 'activo'
);

CREATE TABLE categorias (
    idCategoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    idCreador INT NOT NULL,
    fechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idCreador) REFERENCES usuarios(idUsuario) ON DELETE CASCADE
);

CREATE TABLE cursos (
    idCurso INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    imagen VARCHAR(255),
    costoTotal DECIMAL(10, 2),
    idInstructor INT NOT NULL,
    calificacion DECIMAL(3, 2),
    fechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo') NOT NULL,
    FOREIGN KEY (idInstructor) REFERENCES usuarios(idUsuario) ON DELETE CASCADE
);

CREATE TABLE cursoCategoria (
    idCurso INT NOT NULL,
    idCategoria INT NOT NULL,
    PRIMARY KEY (idCurso, idCategoria),
    FOREIGN KEY (idCurso) REFERENCES cursos(idCurso) ON DELETE CASCADE,
    FOREIGN KEY (idCategoria) REFERENCES categorias(idCategoria) ON DELETE CASCADE
);

CREATE TABLE niveles (
    idNivel INT AUTO_INCREMENT PRIMARY KEY,
    idCurso INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    video blob,
    documento VARCHAR(255),
    costoNivel DECIMAL(10, 2),
    FOREIGN KEY (idCurso) REFERENCES cursos(idCurso) ON DELETE CASCADE
);


CREATE TABLE chat (
    idChat INT AUTO_INCREMENT PRIMARY KEY,
    idEmisor INT NOT NULL,
    idReceptor INT NOT NULL,
    FOREIGN KEY (idEmisor) REFERENCES usuarios(idUsuario),
    FOREIGN KEY (idReceptor) REFERENCES usuarios(idUsuario)
);


CREATE TABLE mensaje (
    idMensaje INT AUTO_INCREMENT PRIMARY KEY,
    chat_id INT,
    idAutor INT,
    contenido TEXT,
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (chat_id) REFERENCES chat(idChat),
    FOREIGN KEY (idAutor) REFERENCES usuarios(idUsuario)
);

CREATE TABLE interaccionesCurso (
    idInteraccion INT AUTO_INCREMENT PRIMARY KEY,
    idUsuario INT NOT NULL,
    idCurso INT NOT NULL,
    
    -- Campos para Inscripciones
    fechaInscripcion DATETIME,
    progresoDelCurso DECIMAL(5, 2),
    fechaUltimaActividad DATETIME,
    estadoAlumno ENUM('en progreso', 'terminado'),
    montoPorVenta DECIMAL(10, 2),
    formaPago VARCHAR(50),
    
    -- Campos para Comentarios
    textoComentario TEXT,
    calificacion INT CHECK(calificacion BETWEEN 1 AND 5),
    estatusComentario ENUM('visible', 'baja'),
    causaBajaComentario TEXT,
    fechaComentario DATETIME,
    
    -- Campos para Certificados
    fechaTerminoCurso DATETIME,
    idInstructor INT,
    
    -- Claves foráneas
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario) ON DELETE CASCADE,
    FOREIGN KEY (idCurso) REFERENCES cursos(idCurso) ON DELETE CASCADE,
    FOREIGN KEY (idInstructor) REFERENCES usuarios(idUsuario) ON DELETE CASCADE
);

CREATE TABLE nivelesCompletados (
    idUsuario INT NOT NULL,
    idNivel INT NOT NULL,
    fechaCompletado DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (idUsuario, idNivel),
    FOREIGN KEY (idUsuario) REFERENCES usuarios(idUsuario) ON DELETE CASCADE,
    FOREIGN KEY (idNivel) REFERENCES niveles(idNivel) ON DELETE CASCADE
);

