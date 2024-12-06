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
-- Table structure for table `niveles`
--

DROP TABLE IF EXISTS `niveles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `niveles` (
  `idNivel` int(11) NOT NULL AUTO_INCREMENT,
  `idCurso` int(11) NOT NULL COMMENT 'ID del curso al que pertenece este nivel',
  `titulo` varchar(255) NOT NULL COMMENT 'Título del nivel',
  `descripcion` text DEFAULT NULL COMMENT 'Descripción del nivel',
  `recursos` varchar(50) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL COMMENT 'Ruta del documento asociado al nivel',
  `costoNivel` decimal(10,2) DEFAULT NULL COMMENT 'Costo del nivel',
  `videoUrl` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idNivel`),
  KEY `idCurso` (`idCurso`),
  CONSTRAINT `niveles_ibfk_1` FOREIGN KEY (`idCurso`) REFERENCES `cursos` (`idCurso`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `niveles`
--

LOCK TABLES `niveles` WRITE;
/*!40000 ALTER TABLE `niveles` DISABLE KEYS */;
INSERT INTO `niveles` VALUES (1,1,'Di','DiDiDi',NULL,'uploads/videos/video_nivel_674b37413f686_No-video-title-fdown.net.mp4','uploads/documentos/doc_nivel_674b37413f14a_Ideas de historias .txt',22.00,NULL),(2,2,'FO','FOFOFO',NULL,'uploads/videos/video_nivel_674b4bb99b30b_fofo.mp4','uploads/documentos/doc_nivel_674b4bb99ab0b_Beca.docx',33.00,NULL),(3,6,'XS','XSXS',NULL,'null','null',21.00,NULL),(4,7,'sss','ss',NULL,'null','null',44.00,NULL),(5,8,'pp','pppppp',NULL,'null','null',1661.00,NULL),(6,9,'AAAA','AAAAAA',NULL,'uploads/videos/video_nivel_674e4aed31e7d_d730c342-8b4a-4ceb-a07c-b14821962cd6.mp4','uploads/documentos/doc_nivel_674e4aed31aa8_465168910_870592301929498_6342589404013869821_n.jpg',33.00,NULL),(7,10,'YA','YAYAYA',NULL,'uploads/videos/video_nivel_674e4d11f35bc_d730c342-8b4a-4ceb-a07c-b14821962cd6.mp4','uploads/documentos/doc_nivel_674e4d11f30fa_Beca.docx',66.00,NULL),(8,11,'YA','YO',NULL,'uploads/videos/video_nivel_674e4e2a6d861_AQMYV4Qccv7GXRnzGef_Xn9Ow92FladyLRLKByG-wgiLlMvneJRRbbxaYFIWk1_4fuWcw8QnAheUv6agu6OaldYB.mp4','uploads/documentos/doc_nivel_674e4e2a6d28a_217605274_193975339347562_3670396818540163946_n.jpg',66.00,NULL),(9,12,'ll','llll',NULL,'uploads/videos/video_nivel_674e4eb314f77_2024-10-24 02-19-23.mp4','uploads/documentos/doc_nivel_674e4eb314bf9_434633752_10231931236806768_5937891981291826741_n.jpg',99.00,NULL),(10,13,'Probando1','Probando1',NULL,'uploads/videos/video_nivel_674f53aea34c8_fofo.mp4','uploads/documentos/doc_nivel_674f53aea305d_217605274_193975339347562_3670396818540163946_n.jpg',21.00,NULL),(11,13,'Probando1','Probando1',NULL,'uploads/videos/video_nivel_674f53aea3f1c_No-video-title-fdown.net.mp4','uploads/documentos/doc_nivel_674f53aea3a13_434633752_10231931236806768_5937891981291826741_n.jpg',43.00,NULL),(12,14,'Probando2','Probando2Probando2',NULL,'uploads/videos/video_nivel_67501d9a3c965_Boca Prieta_7398706054294523141-no-watermark.mp4','uploads/documentos/doc_nivel_67501d9a3c1c3_Beca.docx',21.00,NULL),(13,15,'Prueba1','Prueba1',NULL,'uploads/videos/video_nivel_675108adb0e3c_video.mp4',NULL,0.00,NULL),(14,15,'Prueba 2','Prueba 2',NULL,'uploads/videos/video_nivel_675108adb15f4_video.mp4',NULL,150.00,NULL),(15,16,'okarun','okarun',NULL,'uploads/videos/video_nivel_675112ab85d87_video.mp4',NULL,0.00,NULL),(16,17,'Postres','Postres',NULL,'uploads/videos/video_nivel_675125b59be86_video.mp4',NULL,0.00,NULL),(17,17,'Sopas','Sopas',NULL,'uploads/videos/video_nivel_675125b59c918_video.mp4',NULL,180.00,NULL);
/*!40000 ALTER TABLE `niveles` ENABLE KEYS */;
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
