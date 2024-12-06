-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: judav
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Temporary view structure for view `usuariosbloqueados`
--

DROP TABLE IF EXISTS `usuariosbloqueados`;
/*!50001 DROP VIEW IF EXISTS `usuariosbloqueados`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `usuariosbloqueados` AS SELECT 
 1 AS `nombre`,
 1 AS `apellidos`,
 1 AS `email`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_cursos_usuario`
--

DROP TABLE IF EXISTS `vista_cursos_usuario`;
/*!50001 DROP VIEW IF EXISTS `vista_cursos_usuario`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vista_cursos_usuario` AS SELECT 
 1 AS `idUsuario`,
 1 AS `idCurso`,
 1 AS `cursoTitulo`,
 1 AS `fechaInscripcion`,
 1 AS `fechaUltimaActividad`,
 1 AS `progresoDelCurso`,
 1 AS `estadoAlumno`,
 1 AS `fechaTerminoCurso`,
 1 AS `instructorNombre`,
 1 AS `instructorApellidos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vistavervideo`
--

DROP TABLE IF EXISTS `vistavervideo`;
/*!50001 DROP VIEW IF EXISTS `vistavervideo`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vistavervideo` AS SELECT 
 1 AS `idNivel`,
 1 AS `titulo_nivel`,
 1 AS `descripcion_nivel`,
 1 AS `url_video`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vistamiscursos`
--

DROP TABLE IF EXISTS `vistamiscursos`;
/*!50001 DROP VIEW IF EXISTS `vistamiscursos`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vistamiscursos` AS SELECT 
 1 AS `idUsuario`,
 1 AS `idCurso`,
 1 AS `titulo_curso`,
 1 AS `descripcion_curso`,
 1 AS `imagen_curso`,
 1 AS `instructor`,
 1 AS `progresoPorcentaje`,
 1 AS `ultimoAcceso`,
 1 AS `idNivel`,
 1 AS `titulo_nivel`,
 1 AS `descripcion_nivel`,
 1 AS `recursos`,
 1 AS `videoUrl`,
 1 AS `categoria`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_usuarios`
--

DROP TABLE IF EXISTS `vista_usuarios`;
/*!50001 DROP VIEW IF EXISTS `vista_usuarios`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vista_usuarios` AS SELECT 
 1 AS `idUsuario`,
 1 AS `nombre`,
 1 AS `apellidos`,
 1 AS `rol`,
 1 AS `fechaDeRegistro`,
 1 AS `cursosInscritos`,
 1 AS `cursosTerminados`,
 1 AS `cursosOfrecidos`,
 1 AS `ganancias`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vista_categorias_cursos`
--

DROP TABLE IF EXISTS `vista_categorias_cursos`;
/*!50001 DROP VIEW IF EXISTS `vista_categorias_cursos`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vista_categorias_cursos` AS SELECT 
 1 AS `nombre_categoria`,
 1 AS `descripcion_categoria`,
 1 AS `nombre_creador`,
 1 AS `total_cursos`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `usuariologinview`
--

DROP TABLE IF EXISTS `usuariologinview`;
/*!50001 DROP VIEW IF EXISTS `usuariologinview`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `usuariologinview` AS SELECT 
 1 AS `idUsuario`,
 1 AS `email`,
 1 AS `contraseña`,
 1 AS `rol`,
 1 AS `estado`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `vistacursosdisponibles`
--

DROP TABLE IF EXISTS `vistacursosdisponibles`;
/*!50001 DROP VIEW IF EXISTS `vistacursosdisponibles`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `vistacursosdisponibles` AS SELECT 
 1 AS `idCurso`,
 1 AS `titulo`,
 1 AS `descripcion`,
 1 AS `costoTotal`,
 1 AS `calificacion`,
 1 AS `imagen`,
 1 AS `idInstructor`,
 1 AS `instructor`,
 1 AS `instructor_apellidos`,
 1 AS `categoria`,
 1 AS `fechaCreacion`,
 1 AS `total_niveles`,
 1 AS `promedio_calificaciones`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `usuariosbloqueados`
--

/*!50001 DROP VIEW IF EXISTS `usuariosbloqueados`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `usuariosbloqueados` AS select `usuarios`.`nombre` AS `nombre`,`usuarios`.`apellidos` AS `apellidos`,`usuarios`.`email` AS `email` from `usuarios` where `usuarios`.`estado` = 'baja' */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_cursos_usuario`
--

/*!50001 DROP VIEW IF EXISTS `vista_cursos_usuario`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_cursos_usuario` AS select `ic`.`idUsuario` AS `idUsuario`,`ic`.`idCurso` AS `idCurso`,`c`.`titulo` AS `cursoTitulo`,`ic`.`fechaInscripcion` AS `fechaInscripcion`,`ic`.`fechaUltimaActividad` AS `fechaUltimaActividad`,`ObtenerProgresoCursoFunc`(`ic`.`idUsuario`,`ic`.`idCurso`) AS `progresoDelCurso`,`ic`.`estadoAlumno` AS `estadoAlumno`,`ic`.`fechaTerminoCurso` AS `fechaTerminoCurso`,`u`.`nombre` AS `instructorNombre`,`u`.`apellidos` AS `instructorApellidos` from ((`interaccionescurso` `ic` join `cursos` `c` on(`ic`.`idCurso` = `c`.`idCurso`)) join `usuarios` `u` on(`c`.`idInstructor` = `u`.`idUsuario`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vistavervideo`
--

/*!50001 DROP VIEW IF EXISTS `vistavervideo`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vistavervideo` AS select `niveles`.`idNivel` AS `idNivel`,`niveles`.`titulo` AS `titulo_nivel`,`niveles`.`descripcion` AS `descripcion_nivel`,`niveles`.`video` AS `url_video` from `niveles` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vistamiscursos`
--

/*!50001 DROP VIEW IF EXISTS `vistamiscursos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vistamiscursos` AS select `ic`.`idUsuario` AS `idUsuario`,`c`.`idCurso` AS `idCurso`,`c`.`titulo` AS `titulo_curso`,`c`.`descripcion` AS `descripcion_curso`,`c`.`imagen` AS `imagen_curso`,`u`.`nombre` AS `instructor`,`ic`.`progresoDelCurso` AS `progresoPorcentaje`,`ic`.`fechaUltimaActividad` AS `ultimoAcceso`,`n`.`idNivel` AS `idNivel`,`n`.`titulo` AS `titulo_nivel`,`n`.`descripcion` AS `descripcion_nivel`,`n`.`documento` AS `recursos`,`n`.`video` AS `videoUrl`,`cat`.`nombre` AS `categoria` from (((((`interaccionescurso` `ic` join `cursos` `c` on(`ic`.`idCurso` = `c`.`idCurso`)) join `usuarios` `u` on(`c`.`idInstructor` = `u`.`idUsuario`)) join `niveles` `n` on(`c`.`idCurso` = `n`.`idCurso`)) join `cursocategoria` `cc` on(`c`.`idCurso` = `cc`.`idCurso`)) join `categorias` `cat` on(`cc`.`idCategoria` = `cat`.`idCategoria`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_usuarios`
--

/*!50001 DROP VIEW IF EXISTS `vista_usuarios`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_usuarios` AS select `u`.`idUsuario` AS `idUsuario`,`u`.`nombre` AS `nombre`,`u`.`apellidos` AS `apellidos`,`u`.`rol` AS `rol`,`u`.`fechaDeRegistro` AS `fechaDeRegistro`,case when `u`.`rol` = 'alumno' then (select count(0) from `interaccionescurso` `ic` where `ic`.`idUsuario` = `u`.`idUsuario` and `ic`.`estadoAlumno` = 'en progreso') else NULL end AS `cursosInscritos`,case when `u`.`rol` = 'alumno' then (select count(0) from `interaccionescurso` `ic` where `ic`.`idUsuario` = `u`.`idUsuario` and `ic`.`estadoAlumno` = 'terminado') else NULL end AS `cursosTerminados`,case when `u`.`rol` = 'instructor' then (select count(0) from `cursos` `c` where `c`.`idInstructor` = `u`.`idUsuario`) else NULL end AS `cursosOfrecidos`,case when `u`.`rol` = 'instructor' then (select sum(`ic`.`montoPorVenta`) from `interaccionescurso` `ic` where `ic`.`idInstructor` = `u`.`idUsuario`) else NULL end AS `ganancias` from `usuarios` `u` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vista_categorias_cursos`
--

/*!50001 DROP VIEW IF EXISTS `vista_categorias_cursos`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vista_categorias_cursos` AS select `c`.`nombre` AS `nombre_categoria`,`c`.`descripcion` AS `descripcion_categoria`,concat(`u`.`nombre`,' ',`u`.`apellidos`) AS `nombre_creador`,count(`cc`.`idCurso`) AS `total_cursos` from ((`categorias` `c` left join `usuarios` `u` on(`c`.`idCreador` = `u`.`idUsuario`)) left join `cursocategoria` `cc` on(`c`.`idCategoria` = `cc`.`idCategoria`)) group by `c`.`idCategoria` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `usuariologinview`
--

/*!50001 DROP VIEW IF EXISTS `usuariologinview`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `usuariologinview` AS select `usuarios`.`idUsuario` AS `idUsuario`,`usuarios`.`email` AS `email`,`usuarios`.`contraseña` AS `contraseña`,`usuarios`.`rol` AS `rol`,`usuarios`.`estado` AS `estado` from `usuarios` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `vistacursosdisponibles`
--

/*!50001 DROP VIEW IF EXISTS `vistacursosdisponibles`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `vistacursosdisponibles` AS select `c`.`idCurso` AS `idCurso`,`c`.`titulo` AS `titulo`,`c`.`descripcion` AS `descripcion`,`c`.`costoTotal` AS `costoTotal`,`c`.`calificacion` AS `calificacion`,coalesce(case when `c`.`imagen` like '/%' then `c`.`imagen` when `c`.`imagen` is not null then concat('../',`c`.`imagen`) else '../img/placeholder.jpg' end,'../img/placeholder.jpg') AS `imagen`,`u`.`idUsuario` AS `idInstructor`,`u`.`nombre` AS `instructor`,`u`.`apellidos` AS `instructor_apellidos`,`cat`.`nombre` AS `categoria`,`c`.`fechaCreacion` AS `fechaCreacion`,(select count(0) from `niveles` `n` where `n`.`idCurso` = `c`.`idCurso`) AS `total_niveles`,(select avg(`i`.`calificacion`) from `interaccionescurso` `i` where `i`.`idCurso` = `c`.`idCurso` and `i`.`calificacion` is not null) AS `promedio_calificaciones` from (((`cursos` `c` join `usuarios` `u` on(`c`.`idInstructor` = `u`.`idUsuario`)) join `cursocategoria` `cc` on(`c`.`idCurso` = `cc`.`idCurso`)) join `categorias` `cat` on(`cc`.`idCategoria` = `cat`.`idCategoria`)) where `c`.`estado` = 'activo' */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Dumping events for database 'judav'
--

--
-- Dumping routines for database 'judav'
--
/*!50003 DROP FUNCTION IF EXISTS `CheckAndBlockUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `CheckAndBlockUser`(p_email VARCHAR(100)) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN

    DECLARE current_attempts INT;

    DECLARE result_message VARCHAR(255);



    -- Obtener los intentos actuales del usuario

    SELECT intentos INTO current_attempts

    FROM usuarios

    WHERE email = p_email;



    -- Si el usuario no existe, retornar mensaje de error

    IF current_attempts IS NULL THEN

        RETURN 'Error: Usuario no encontrado.';

    END IF;



    -- Incrementar los intentos fallidos

    SET current_attempts = current_attempts + 1;



    -- Si alcanza el límite de 3 intentos, bloquear al usuario

    IF current_attempts >= 3 THEN

        UPDATE usuarios 

        SET intentos = current_attempts, estado = 'baja'

        WHERE email = p_email;

        SET result_message = 'Usuario bloqueado tras 3 intentos fallidos.';

    ELSE

        -- Actualizar intentos en la base de datos

        UPDATE usuarios 

        SET intentos = current_attempts

        WHERE email = p_email;

        SET result_message = CONCAT('Intentos fallidos: ', current_attempts);

    END IF;



    RETURN result_message;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `ObtenerProgresoCursoFunc` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ObtenerProgresoCursoFunc`(p_idUsuario INT,
    p_idCurso INT
) RETURNS decimal(5,2)
    DETERMINISTIC
BEGIN
    DECLARE totalNiveles INT DEFAULT 0;
    DECLARE nivelesCompletados INT DEFAULT 0;
    DECLARE progresoPorcentaje DECIMAL(5, 2) DEFAULT 0.00;

    -- Calcular el total de niveles del curso
    SELECT COUNT(*)
    INTO totalNiveles
    FROM niveles
    WHERE idCurso = p_idCurso;

    -- Calcular los niveles completados por el usuario
    SELECT COUNT(*)
    INTO nivelesCompletados
    FROM nivelesCompletados nc
    INNER JOIN niveles n ON nc.idNivel = n.idNivel
    WHERE nc.idUsuario = p_idUsuario AND n.idCurso = p_idCurso;

    -- Calcular el porcentaje de progreso
    IF totalNiveles > 0 THEN
        SET progresoPorcentaje = (nivelesCompletados / totalNiveles) * 100;
    END IF;

    RETURN progresoPorcentaje;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP FUNCTION IF EXISTS `ReactivateUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` FUNCTION `ReactivateUser`(p_email VARCHAR(100)) RETURNS varchar(255) CHARSET utf8mb4 COLLATE utf8mb4_general_ci
BEGIN

    DECLARE user_status ENUM('activo', 'baja');

    DECLARE result_message VARCHAR(255);



    -- Verificar si el usuario existe y obtener su estado actual

    SELECT estado INTO user_status 

    FROM usuarios 

    WHERE email = p_email;



    -- Si el usuario no existe, retornar un mensaje de error

    IF user_status IS NULL THEN

        RETURN 'Error: Usuario no encontrado.';

    END IF;



    -- Si el usuario ya está activo, retornar mensaje

    IF user_status = 'activo' THEN

        RETURN 'El usuario ya está activo.';

    END IF;



    -- Reactivar al usuario si está en estado "baja"

    IF user_status = 'baja' THEN

        UPDATE usuarios 

        SET estado = 'activo', intentos = 0, fechaDeUltimoCambio = NOW()

        WHERE email = p_email;

        SET result_message = 'Usuario reactivado exitosamente.';

    END IF;



    RETURN result_message;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ActualizarProgreso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ActualizarProgreso`(
    IN p_idUsuario INT,
    IN p_idCurso INT
)
BEGIN
    -- Declaración de variables locales
    DECLARE total_niveles INT DEFAULT 0;
    DECLARE niveles_completados INT DEFAULT 0;
    DECLARE nuevo_progreso DECIMAL(5, 2) DEFAULT 0;

    -- Contar el total de niveles del curso
    SELECT COUNT(*) 
    INTO total_niveles
    FROM niveles
    WHERE idCurso = p_idCurso;

    -- Contar los niveles completados por el usuario
    SELECT COUNT(*) 
    INTO niveles_completados
    FROM nivelesCompletados
    WHERE idUsuario = p_idUsuario
      AND idNivel IN (
          SELECT idNivel 
          FROM niveles 
          WHERE idCurso = p_idCurso
      );

    -- Calcular el progreso como porcentaje
    IF total_niveles > 0 THEN
        SET nuevo_progreso = (niveles_completados / total_niveles) * 100;
    ELSE
        SET nuevo_progreso = 0;
    END IF;

    -- Actualizar el progreso en la tabla interaccionesCurso
    UPDATE interaccionesCurso
    SET progresoDelCurso = nuevo_progreso
    WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;

    -- Si el alumno completó todos los niveles, actualizar estado y fecha de término
    IF niveles_completados = total_niveles THEN
        UPDATE interaccionesCurso
        SET estadoAlumno = 'terminado',
            fechaTerminoCurso = NOW()
        WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `EliminarCurso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `EliminarCurso`(IN p_idCurso INT, IN p_idInstructor INT)
BEGIN
    -- Verify the course belongs to the instructor
    IF EXISTS (
        SELECT 1 
        FROM cursos 
        WHERE idCurso = p_idCurso 
        AND idInstructor = p_idInstructor 
        AND estado = 'activo'
    ) THEN
        -- Update course status to inactive
        UPDATE cursos 
        SET estado = 'inactivo' 
        WHERE idCurso = p_idCurso;
        
        SELECT 1 AS resultado; -- Indica éxito
    ELSE
        SELECT 0 AS resultado; -- Indica fallo
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetCourseDetails` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCourseDetails`(

    IN p_idCurso INT,

    IN p_idUsuario INT

)
BEGIN

    SELECT * 

    FROM vista_cursos_usuario 

    WHERE idCurso = p_idCurso AND idUsuario = p_idUsuario;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetCoursesByUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetCoursesByUser`(
    IN p_userId INT
)
BEGIN
    -- Seleccionar los cursos del usuario desde la vista
    SELECT * 
    FROM vista_cursos_usuario
    WHERE idUsuario = p_userId;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `GetUserDataByEmail` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetUserDataByEmail`(

    IN p_email VARCHAR(100)

)
BEGIN

    -- Recuperar los datos del usuario

    SELECT idUsuario, nombre, apellidos, genero, fechaNacimiento, rol

    FROM usuarios

    WHERE email = p_email AND estado = 'activo';

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `InsertarCursoCompleto` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `InsertarCursoCompleto`(

    IN p_titulo VARCHAR(255),

    IN p_descripcion TEXT,

    IN p_imagen VARCHAR(255),

    IN p_costoTotal DECIMAL(10, 2),

    IN p_idInstructor INT,

    IN p_categorias JSON,

    IN p_niveles JSON

)
BEGIN

    DECLARE v_idCurso INT;

    DECLARE v_categoria_id INT;

    DECLARE v_categoria_nombre VARCHAR(100);

    DECLARE v_nivel_titulo VARCHAR(255);

    DECLARE v_nivel_descripcion TEXT;

    DECLARE v_nivel_costo DECIMAL(10, 2);

    DECLARE v_nivel_documento VARCHAR(255);

    DECLARE v_nivel_video VARCHAR(255);

    DECLARE i INT DEFAULT 0;

    DECLARE j INT DEFAULT 0;



    -- Iniciar transacción

    START TRANSACTION;



    -- Insertar curso

    INSERT INTO cursos (

        titulo, 

        descripcion, 

        imagen, 

        costoTotal, 

        idInstructor, 

        estado

    ) VALUES (

        p_titulo, 

        p_descripcion, 

        p_imagen, 

        p_costoTotal, 

        p_idInstructor, 

        'activo'

    );



    -- Obtener ID del curso insertado

    SET v_idCurso = LAST_INSERT_ID();



    -- Insertar categorías

    SET i = 0;

    WHILE i < JSON_LENGTH(p_categorias) DO

        SET v_categoria_nombre = JSON_UNQUOTE(JSON_EXTRACT(p_categorias, CONCAT('$[', i, ']')));

        

        -- Verificar si la categoría existe, si no, insertarla

        INSERT INTO categorias (nombre, idCreador) 

        VALUES (v_categoria_nombre, p_idInstructor)

        ON DUPLICATE KEY UPDATE idCategoria = LAST_INSERT_ID(idCategoria);

        

        SET v_categoria_id = LAST_INSERT_ID();

        

        -- Insertar relación curso-categoría

        INSERT INTO cursoCategoria (idCurso, idCategoria) 

        VALUES (v_idCurso, v_categoria_id);

        

        SET i = i + 1;

    END WHILE;



    -- Insertar niveles

    SET i = 0;

    WHILE i < JSON_LENGTH(p_niveles) DO

        SET v_nivel_titulo = JSON_UNQUOTE(JSON_EXTRACT(p_niveles, CONCAT('$[', i, '].titulo')));

        SET v_nivel_descripcion = JSON_UNQUOTE(JSON_EXTRACT(p_niveles, CONCAT('$[', i, '].descripcion')));

        SET v_nivel_costo = CAST(JSON_UNQUOTE(JSON_EXTRACT(p_niveles, CONCAT('$[', i, '].costoNivel'))) AS DECIMAL(10, 2));

        SET v_nivel_documento = JSON_UNQUOTE(JSON_EXTRACT(p_niveles, CONCAT('$[', i, '].documento')));

        SET v_nivel_video = JSON_UNQUOTE(JSON_EXTRACT(p_niveles, CONCAT('$[', i, '].video')));

        

        -- Insertar nivel

        INSERT INTO niveles (

            idCurso, 

            titulo, 

            descripcion, 

            costoNivel, 

            documento,

            video

        ) VALUES (

            v_idCurso, 

            v_nivel_titulo, 

            v_nivel_descripcion, 

            v_nivel_costo, 

            v_nivel_documento,

            v_nivel_video

        );

        

        SET i = i + 1;

    END WHILE;



    -- Confirmar transacción

    COMMIT;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ObtenerComentariosCurso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerComentariosCurso`(IN `p_idCurso` INT)
BEGIN
    SELECT 
        ic.idUsuario AS idUser,
        u.nombre AS nombreUsuario,
        ic.textoComentario AS textoComentario,
        ic.calificacion AS calificacion,
        ic.fechaComentario AS fechaComentario,
        ic.estatusComentario AS estatus
    FROM 
        interaccionesCurso ic
    JOIN 
        usuarios u ON ic.idUsuario = u.idUsuario
    WHERE 
        ic.idCurso = p_idCurso
    ORDER BY 
        ic.fechaComentario DESC;  -- Ordena los comentarios por fecha, más recientes primero
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ObtenerProgresoCurso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerProgresoCurso`(
    IN p_idUsuario INT,
    IN p_idCurso INT
)
BEGIN
    DECLARE totalNiveles INT DEFAULT 0;
    DECLARE nivelesCompletados INT DEFAULT 0;
    DECLARE progresoPorcentaje DECIMAL(5, 2) DEFAULT 0.00;

    -- Calcular el total de niveles del curso
    SELECT COUNT(*)
    INTO totalNiveles
    FROM niveles
    WHERE idCurso = p_idCurso;

    -- Calcular los niveles completados por el usuario
    SELECT COUNT(*)
    INTO nivelesCompletados
    FROM nivelesCompletados nc
    INNER JOIN niveles n ON nc.idNivel = n.idNivel
    WHERE nc.idUsuario = p_idUsuario AND n.idCurso = p_idCurso;

    -- Calcular el porcentaje de progreso
    IF totalNiveles > 0 THEN
        SET progresoPorcentaje = (nivelesCompletados / totalNiveles) * 100;
    END IF;

    -- Retornar el resultado como una tabla
    SELECT 
        p_idUsuario AS idUsuario,
        p_idCurso AS idCurso,
        nivelesCompletados AS nivelesCompletados,
        totalNiveles AS totalNiveles,
        progresoPorcentaje AS progresoPorcentaje;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `ReactivateUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `ReactivateUser`(

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

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `RealizarCompraCurso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `RealizarCompraCurso`(

    IN p_idUsuario INT,

    IN p_idCurso INT,

    IN p_idNivel INT,  -- NULL si es curso completo

    IN p_formaPago VARCHAR(50),

    OUT p_mensaje VARCHAR(255)

)
BEGIN

    DECLARE v_monto DECIMAL(10,2);

    DECLARE v_existe_inscripcion INT;

    

    -- Verificar si ya existe una inscripción

    SELECT COUNT(*) INTO v_existe_inscripcion

    FROM interaccionesCurso

    WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;

    

    IF v_existe_inscripcion > 0 THEN

        SET p_mensaje = 'Ya estás inscrito en este curso';

    ELSE

        -- Calcular monto según tipo de compra

        IF p_idNivel IS NULL THEN

            -- Compra del curso completo

            SELECT costoTotal INTO v_monto

            FROM cursos

            WHERE idCurso = p_idCurso;

        ELSE

            -- Compra de nivel individual

            SELECT costoNivel INTO v_monto

            FROM niveles

            WHERE idNivel = p_idNivel AND idCurso = p_idCurso;

        END IF;

        

        -- Registrar la compra

        INSERT INTO interaccionesCurso (

            idUsuario,

            idCurso,

            fechaInscripcion,

            progresoDelCurso,

            estadoAlumno,

            montoPorVenta,

            formaPago

        ) VALUES (

            p_idUsuario,

            p_idCurso,

            NOW(),

            0,

            'en progreso',

            v_monto,

            p_formaPago

        );

        

        SET p_mensaje = 'Compra realizada con éxito';

    END IF;

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `RegisterUserOrManageUser` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegisterUserOrManageUser`(

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



END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `RegistrarComentarioCurso` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarComentarioCurso`(
    IN p_idUsuario INT,
    IN p_idCurso INT,
    IN p_textoComentario TEXT,
    IN p_calificacion INT
)
BEGIN
    DECLARE v_existeComentario INT;
    DECLARE v_inscrito INT;

    -- Verificar si el usuario está inscrito en el curso
    SELECT COUNT(*) INTO v_inscrito
    FROM interaccionesCurso
    WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;

    IF v_inscrito = 0 THEN
        -- El usuario no está inscrito en el curso
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El usuario no está inscrito en este curso.';
    ELSE
        -- Verificar si el usuario ya comentó en este curso
        SELECT COUNT(*) INTO v_existeComentario
        FROM interaccionesCurso
        WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso AND textoComentario IS NOT NULL;

        IF v_existeComentario > 0 THEN
            -- Ya existe un comentario, actualizarlo
            UPDATE interaccionesCurso
            SET textoComentario = p_textoComentario,
                calificacion = p_calificacion,
                fechaComentario = NOW(),
                estatusComentario = 'visible'
            WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;
        ELSE
            -- Insertar nuevo comentario
            UPDATE interaccionesCurso
            SET textoComentario = p_textoComentario,
                calificacion = p_calificacion,
                fechaComentario = NOW(),
                estatusComentario = 'visible'
            WHERE idUsuario = p_idUsuario AND idCurso = p_idCurso;
        END IF;
    END IF;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `RegistrarCursoConNiveles` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarCursoConNiveles`(
    IN accion VARCHAR(10),  -- Cambiar ENUM a VARCHAR
    IN tituloCurso VARCHAR(255),
    IN descripcionCurso TEXT,
    IN idInstructor INT,
    IN categorias JSON,
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
    DECLARE i INT DEFAULT 0;

    IF accion = 'registrar' THEN
        -- Insertar un nuevo curso
        INSERT INTO cursos (titulo, descripcion, idInstructor, costoTotal, estado)
        VALUES (tituloCurso, descripcionCurso, idInstructor, costoTotal, 'activo');

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
            
            -- Debug: Verificar valores antes de la inserción
            SELECT JSON_UNQUOTE(JSON_EXTRACT(nivelTitulo, CONCAT('$[', i, ']'))) AS nivelTitulo,
                   JSON_UNQUOTE(JSON_EXTRACT(nivelDescripcion, CONCAT('$[', i, ']'))) AS nivelDescripcion,
                   JSON_UNQUOTE(JSON_EXTRACT(nivelCosto, CONCAT('$[', i, ']'))) AS nivelCosto,
                   JSON_UNQUOTE(JSON_EXTRACT(nivelVideo, CONCAT('$[', i, ']'))) AS nivelVideo,
                   JSON_UNQUOTE(JSON_EXTRACT(nivelDocumento, CONCAT('$[', i, ']'))) AS nivelDocumento;

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
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `RegistrarNivelCompletado` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `RegistrarNivelCompletado`(
    IN p_idUsuario INT,
    IN p_idNivel INT
)
BEGIN
    -- Inserta el registro solo si no existe
    INSERT IGNORE INTO nivelesCompletados (idUsuario, idNivel)
    VALUES (p_idUsuario, p_idNivel);
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `registrar_categoria` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_categoria`(

    IN nombre_categoria VARCHAR(100),

    IN descripcion_categoria TEXT,

    IN id_creador INT

)
BEGIN

    INSERT INTO categorias (nombre, descripcion, idCreador)

    VALUES (nombre_categoria, descripcion_categoria, id_creador);

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-05 19:21:48
