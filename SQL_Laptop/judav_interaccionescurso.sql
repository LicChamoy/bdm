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
-- Table structure for table `interaccionescurso`
--

DROP TABLE IF EXISTS `interaccionescurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `interaccionescurso` (
  `idInteraccion` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL COMMENT 'ID del usuario relacionado a la interacción',
  `idCurso` int(11) NOT NULL COMMENT 'ID del curso relacionado a la interacción',
  `fechaInscripcion` datetime DEFAULT NULL COMMENT 'Fecha en que el usuario se inscribió en el curso',
  `progresoDelCurso` decimal(5,2) DEFAULT NULL COMMENT 'Progreso del usuario en el curso',
  `fechaUltimaActividad` datetime DEFAULT NULL COMMENT 'Fecha de la última actividad del usuario en el curso',
  `nivelActual` varchar(50) DEFAULT NULL,
  `estadoAlumno` enum('en progreso','terminado') DEFAULT NULL COMMENT 'Estado del alumno en el curso (en progreso o terminado)',
  `montoPorVenta` decimal(10,2) DEFAULT NULL COMMENT 'Monto pagado por el alumno al adquirir el curso',
  `formaPago` varchar(50) DEFAULT NULL COMMENT 'Método de pago utilizado para adquirir el curso',
  `textoComentario` text DEFAULT NULL COMMENT 'Comentario del alumno sobre el curso',
  `calificacion` int(11) DEFAULT NULL COMMENT 'Calificación otorgada por el alumno al curso, entre 1 y 5',
  `estatusComentario` enum('visible','baja') DEFAULT NULL COMMENT 'Estatus del comentario (visible o dado de baja)',
  `causaBajaComentario` text DEFAULT NULL COMMENT 'Causa por la cual el comentario fue dado de baja',
  `fechaComentario` datetime DEFAULT NULL COMMENT 'Fecha y hora en que se realizó el comentario',
  `fechaTerminoCurso` datetime DEFAULT NULL COMMENT 'Fecha en que se completó el curso',
  `idInstructor` int(11) DEFAULT NULL COMMENT 'ID del instructor del curso',
  `progresoTotal` varchar(50) DEFAULT NULL,
  `ultimoAcceso` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idInteraccion`),
  KEY `idUsuario` (`idUsuario`),
  KEY `idCurso` (`idCurso`),
  KEY `idInstructor` (`idInstructor`),
  CONSTRAINT `interaccionescurso_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE,
  CONSTRAINT `interaccionescurso_ibfk_2` FOREIGN KEY (`idCurso`) REFERENCES `cursos` (`idCurso`) ON DELETE CASCADE,
  CONSTRAINT `interaccionescurso_ibfk_3` FOREIGN KEY (`idInstructor`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `interaccionescurso`
--

LOCK TABLES `interaccionescurso` WRITE;
/*!40000 ALTER TABLE `interaccionescurso` DISABLE KEYS */;
INSERT INTO `interaccionescurso` VALUES (1,16,1,'2024-11-30 10:05:30',0.00,NULL,NULL,'en progreso',22.00,'tarjeta',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,16,2,'2024-11-30 11:30:42',0.00,NULL,NULL,'en progreso',NULL,'tarjeta',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,17,2,'2024-11-30 12:32:46',100.00,'2024-12-04 18:48:47',NULL,'terminado',NULL,'paypal','xc',1,'visible',NULL,'2024-12-04 16:43:00','2024-12-04 18:48:47',NULL,NULL,NULL),(4,17,1,'2024-11-30 12:36:31',100.00,'2024-12-04 12:28:31',NULL,'en progreso',NULL,'tarjeta',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,17,3,'2024-12-02 11:07:33',0.00,NULL,NULL,'en progreso',NULL,'tarjeta',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,17,9,'2024-12-02 18:04:48',0.00,NULL,NULL,'en progreso',NULL,'tarjeta',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,17,13,'2024-12-03 12:53:56',0.00,NULL,NULL,'en progreso',NULL,'tarjeta',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(8,17,14,'2024-12-04 03:15:37',0.00,NULL,NULL,'en progreso',NULL,'tarjeta',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(9,21,14,'2024-12-04 20:00:34',100.00,'2024-12-04 20:02:12',NULL,'terminado',NULL,'tarjeta','hola',5,'visible',NULL,'2024-12-04 20:01:33','2024-12-04 20:02:12',NULL,NULL,NULL),(10,21,2,'2024-12-04 20:02:49',0.00,NULL,NULL,'en progreso',NULL,'tarjeta',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,21,16,'2024-12-04 20:40:50',100.00,'2024-12-04 20:41:36',NULL,'terminado',NULL,'tarjeta',NULL,NULL,NULL,NULL,NULL,'2024-12-04 20:41:36',NULL,NULL,NULL),(12,21,15,'2024-12-04 21:58:37',50.00,'2024-12-04 21:59:21',NULL,'en progreso',NULL,'tarjeta',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(13,17,17,'2024-12-04 22:03:48',100.00,'2024-12-04 22:04:12',NULL,'terminado',NULL,'tarjeta','revision de proyecto',4,'visible',NULL,'2024-12-04 22:07:02','2024-12-04 22:04:12',NULL,NULL,NULL);
/*!40000 ALTER TABLE `interaccionescurso` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER validar_inscripcion_unica
BEFORE INSERT ON interaccionesCurso
FOR EACH ROW
BEGIN
    IF (EXISTS (SELECT 1 FROM interaccionesCurso WHERE idUsuario = NEW.idUsuario AND idCurso = NEW.idCurso)) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'El usuario ya está inscrito en este curso.';
    END IF;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_unicode_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER actualizar_fecha_ultima_actividad
BEFORE UPDATE ON interaccionesCurso
FOR EACH ROW
BEGIN
    IF OLD.progresoDelCurso <> NEW.progresoDelCurso THEN
        SET NEW.fechaUltimaActividad = NOW();
    END IF;
END */;;
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

-- Dump completed on 2024-12-05 19:21:47
