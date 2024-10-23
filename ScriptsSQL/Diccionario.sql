-- Diccionario de Datos para la Tabla 'usuarios'
ALTER TABLE usuarios 
CHANGE nombre nombre VARCHAR(50) NOT NULL 
COMMENT 'Nombre del usuario';

ALTER TABLE usuarios 
CHANGE apellidos apellidos VARCHAR(50) NOT NULL 
COMMENT 'Apellidos del usuario';

ALTER TABLE usuarios 
CHANGE genero genero ENUM('hombre', 'mujer', 'otro') NOT NULL 
COMMENT 'Género del usuario';

ALTER TABLE usuarios 
CHANGE fechaNacimiento fechaNacimiento DATE NOT NULL 
COMMENT 'Fecha de nacimiento del usuario';

ALTER TABLE usuarios 
CHANGE email email VARCHAR(100) NOT NULL UNIQUE 
COMMENT 'Email único del usuario';

ALTER TABLE usuarios 
CHANGE contraseña contraseña VARCHAR(255) NOT NULL 
COMMENT 'Contraseña del usuario, almacenada de forma segura';

ALTER TABLE usuarios 
CHANGE avatar avatar BLOB 
COMMENT 'Imagen de perfil del usuario en formato BLOB';

ALTER TABLE usuarios 
CHANGE fechaDeRegistro fechaDeRegistro DATETIME DEFAULT CURRENT_TIMESTAMP 
COMMENT 'Fecha y hora de registro del usuario';

ALTER TABLE usuarios 
CHANGE fechaDeUltimoCambio fechaDeUltimoCambio DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
COMMENT 'Fecha y hora del último cambio en la información del usuario';

ALTER TABLE usuarios 
CHANGE rol rol ENUM('docente', 'alumno') NOT NULL 
COMMENT 'Rol del usuario en el sistema (docente o alumno)';

ALTER TABLE usuarios 
CHANGE estado estado ENUM('activo', 'baja') NOT NULL DEFAULT 'activo' 
COMMENT 'Estado del usuario (activo o dado de baja)';

-- Diccionario de Datos para la Tabla 'categorias'
ALTER TABLE categorias 
CHANGE nombre nombre VARCHAR(100) NOT NULL 
COMMENT 'Nombre de la categoría';

ALTER TABLE categorias 
CHANGE descripcion descripcion TEXT 
COMMENT 'Descripción de la categoría';

ALTER TABLE categorias 
CHANGE idCreador idCreador INT NOT NULL 
COMMENT 'ID del usuario administrador que creó la categoría';

ALTER TABLE categorias 
CHANGE fechaCreacion fechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP 
COMMENT 'Fecha y hora de creación de la categoría';

-- Diccionario de Datos para la Tabla 'cursos'
ALTER TABLE cursos 
CHANGE titulo titulo VARCHAR(255) NOT NULL 
COMMENT 'Título del curso';

ALTER TABLE cursos 
CHANGE descripcion descripcion TEXT 
COMMENT 'Descripción del curso';

ALTER TABLE cursos 
CHANGE imagen imagen VARCHAR(255) 
COMMENT 'Imagen representativa del curso';

ALTER TABLE cursos 
CHANGE costoTotal costoTotal DECIMAL(10, 2) 
COMMENT 'Costo total del curso, sumatoria de los niveles';

ALTER TABLE cursos 
CHANGE idInstructor idInstructor INT NOT NULL 
COMMENT 'ID del instructor que ofrece el curso';

ALTER TABLE cursos 
CHANGE calificacion calificacion DECIMAL(3, 2) 
COMMENT 'Calificación promedio del curso en un rango de 1 a 5';

ALTER TABLE cursos 
CHANGE fechaCreacion fechaCreacion DATETIME DEFAULT CURRENT_TIMESTAMP 
COMMENT 'Fecha y hora de creación del curso';

ALTER TABLE cursos 
CHANGE estado estado ENUM('activo', 'inactivo') NOT NULL 
COMMENT 'Estado del curso (activo o inactivo)';

-- Diccionario de Datos para la Tabla 'cursoCategoria'
ALTER TABLE cursoCategoria 
CHANGE idCurso idCurso INT NOT NULL 
COMMENT 'ID del curso al que pertenece la categoría';

ALTER TABLE cursoCategoria 
CHANGE idCategoria idCategoria INT NOT NULL 
COMMENT 'ID de la categoría a la que pertenece el curso';

-- Diccionario de Datos para la Tabla 'niveles'
ALTER TABLE niveles 
CHANGE idCurso idCurso INT NOT NULL 
COMMENT 'ID del curso al que pertenece este nivel';

ALTER TABLE niveles 
CHANGE titulo titulo VARCHAR(255) NOT NULL 
COMMENT 'Título del nivel';

ALTER TABLE niveles 
CHANGE descripcion descripcion TEXT 
COMMENT 'Descripción del nivel';

ALTER TABLE niveles 
CHANGE video video BLOB 
COMMENT 'Video relacionado con el nivel, almacenado como BLOB';

ALTER TABLE niveles 
CHANGE documento documento VARCHAR(255) 
COMMENT 'Ruta del documento asociado al nivel';

ALTER TABLE niveles 
CHANGE costoNivel costoNivel DECIMAL(10, 2) 
COMMENT 'Costo del nivel';

-- Diccionario de Datos para la Tabla 'mensajes'
ALTER TABLE mensajes 
CHANGE idEmisor idEmisor INT NOT NULL 
COMMENT 'ID del usuario emisor del mensaje';

ALTER TABLE mensajes 
CHANGE idReceptor idReceptor INT NOT NULL 
COMMENT 'ID del usuario receptor del mensaje';

ALTER TABLE mensajes 
CHANGE texto texto TEXT NOT NULL 
COMMENT 'Contenido del mensaje enviado';

ALTER TABLE mensajes 
CHANGE fecha fecha DATETIME DEFAULT CURRENT_TIMESTAMP 
COMMENT 'Fecha y hora en que se envió el mensaje';

-- Diccionario de Datos para la Tabla 'interaccionesCurso'
ALTER TABLE interaccionesCurso 
CHANGE idUsuario idUsuario INT NOT NULL 
COMMENT 'ID del usuario relacionado a la interacción';

ALTER TABLE interaccionesCurso 
CHANGE idCurso idCurso INT NOT NULL 
COMMENT 'ID del curso relacionado a la interacción';

ALTER TABLE interaccionesCurso 
CHANGE fechaInscripcion fechaInscripcion DATETIME 
COMMENT 'Fecha en que el usuario se inscribió en el curso';

ALTER TABLE interaccionesCurso 
CHANGE progresoDelCurso progresoDelCurso DECIMAL(5, 2) 
COMMENT 'Progreso del usuario en el curso';

ALTER TABLE interaccionesCurso 
CHANGE fechaUltimaActividad fechaUltimaActividad DATETIME 
COMMENT 'Fecha de la última actividad del usuario en el curso';

ALTER TABLE interaccionesCurso 
CHANGE estadoAlumno estadoAlumno ENUM('en progreso', 'terminado') 
COMMENT 'Estado del alumno en el curso (en progreso o terminado)';

ALTER TABLE interaccionesCurso 
CHANGE montoPorVenta montoPorVenta DECIMAL(10, 2) 
COMMENT 'Monto pagado por el alumno al adquirir el curso';

ALTER TABLE interaccionesCurso 
CHANGE formaPago formaPago VARCHAR(50) 
COMMENT 'Método de pago utilizado para adquirir el curso';

ALTER TABLE interaccionesCurso 
CHANGE textoComentario textoComentario TEXT 
COMMENT 'Comentario del alumno sobre el curso';

ALTER TABLE interaccionesCurso 
CHANGE calificacion calificacion INT 
COMMENT 'Calificación otorgada por el alumno al curso, entre 1 y 5';

ALTER TABLE interaccionesCurso 
CHANGE estatusComentario estatusComentario ENUM('visible', 'baja') 
COMMENT 'Estatus del comentario (visible o dado de baja)';

ALTER TABLE interaccionesCurso 
CHANGE causaBajaComentario causaBajaComentario TEXT 
COMMENT 'Causa por la cual el comentario fue dado de baja';

ALTER TABLE interaccionesCurso 
CHANGE fechaComentario fechaComentario DATETIME 
COMMENT 'Fecha y hora en que se realizó el comentario';

ALTER TABLE interaccionesCurso 
CHANGE fechaTerminoCurso fechaTerminoCurso DATETIME 
COMMENT 'Fecha en que se completó el curso';

ALTER TABLE interaccionesCurso 
CHANGE idInstructor idInstructor INT 
COMMENT 'ID del instructor del curso';
