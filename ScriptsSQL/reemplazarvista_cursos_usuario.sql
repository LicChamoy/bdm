CREATE or replace
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `judav`.`vista_cursos_usuario` AS
    SELECT 
        `ic`.`idUsuario` AS `idUsuario`,
        `ic`.`idCurso` AS `idCurso`,
        `c`.`titulo` AS `cursoTitulo`,
        `ic`.`fechaInscripcion` AS `fechaInscripcion`,
        `ic`.`fechaUltimaActividad` AS `fechaUltimaActividad`,
        ObtenerProgresoCursoFunc(ic.idUsuario, ic.idCurso) AS `progresoDelCurso`, -- Llamada a la función
        `ic`.`estadoAlumno` AS `estadoAlumno`,
        `ic`.`fechaTerminoCurso` AS `fechaTerminoCurso`,
        `u`.`nombre` AS `instructorNombre`,
        `u`.`apellidos` AS `instructorApellidos`
    FROM
        ((`judav`.`interaccionescurso` `ic`
        JOIN `judav`.`cursos` `c` ON ((`ic`.`idCurso` = `c`.`idCurso`)))
        JOIN `judav`.`usuarios` `u` ON ((`c`.`idInstructor` = `u`.`idUsuario`)));
