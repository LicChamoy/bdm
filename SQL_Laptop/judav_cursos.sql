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
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cursos` (
  `idCurso` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL COMMENT 'Curso título',
  `descripcion` text DEFAULT NULL COMMENT 'Descripción del curso',
  `imagen` varchar(255) DEFAULT NULL,
  `costoTotal` decimal(10,2) DEFAULT NULL,
  `idInstructor` int(11) NOT NULL COMMENT 'ID del instructor que ofrece el curso',
  `calificacion` decimal(3,2) DEFAULT NULL,
  `fechaCreacion` datetime DEFAULT current_timestamp() COMMENT 'Fecha y hora de creación del curso',
  `estado` enum('activo','inactivo') NOT NULL COMMENT 'Estado del curso (activo o inactivo)',
  PRIMARY KEY (`idCurso`),
  KEY `idx_instructor` (`idInstructor`),
  KEY `idx_estado` (`estado`),
  CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`idInstructor`) REFERENCES `usuarios` (`idUsuario`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursos`
--

LOCK TABLES `cursos` WRITE;
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT INTO `cursos` VALUES (1,'Di','DiDi',NULL,22.00,16,NULL,'2024-11-30 10:03:13','activo'),(2,'FO','FO',NULL,33.00,16,NULL,'2024-11-30 11:30:33','activo'),(3,'Sosa','Sosa',NULL,111.00,17,NULL,'2024-12-02 10:55:04','activo'),(4,'Roro','Roro',NULL,223.00,17,NULL,'2024-12-02 11:58:12','activo'),(5,'Pepe','PepePepe',NULL,44.00,17,NULL,'2024-12-02 12:04:54','activo'),(6,'XS','XSXS',NULL,21.00,17,NULL,'2024-12-02 17:29:46','activo'),(7,'ss','ssss',NULL,44.00,17,NULL,'2024-12-02 17:40:46','activo'),(8,'pp','pppp',NULL,1661.00,17,NULL,'2024-12-02 17:53:16','activo'),(9,'AA','AAAA',NULL,33.00,17,NULL,'2024-12-02 18:03:57','activo'),(10,'YA','YAYA','uploads/cursos/curso_674e4d11f2b77_337400926_2990837597891808_3078137582243253113_n.jpg',66.00,17,NULL,'2024-12-02 18:13:05','activo'),(11,'YO','YO','uploads/cursos/curso_674e4e2a6cc6e_337400926_2990837597891808_3078137582243253113_n.jpg',66.00,17,NULL,'2024-12-02 18:17:46','activo'),(12,'lll','l','uploads/cursos/curso_674e4eb31479a_337400926_2990837597891808_3078137582243253113_n.jpg',99.00,17,NULL,'2024-12-02 18:20:03','activo'),(13,'Probando1','Probando1',NULL,64.00,17,NULL,'2024-12-03 12:53:34','inactivo'),(14,'Probando2','Probando2Probando2',NULL,21.00,17,NULL,'2024-12-04 03:15:06','activo'),(15,'Revision de Proyecto','Ya para pasar',NULL,150.00,21,NULL,'2024-12-04 19:58:05','activo'),(16,'como arreglar el get del chat','aaaaaaaaaaaaaaa',NULL,0.00,21,NULL,'2024-12-04 20:40:43','activo'),(17,'Cocina con teresita','Cocina con teresita',NULL,180.00,21,NULL,'2024-12-04 22:01:57','activo');
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-05 19:21:47
