CREATE DATABASE  IF NOT EXISTS `meet_and_zik` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `meet_and_zik`;
-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: meet_and_zik
-- ------------------------------------------------------
-- Server version	8.0.35-0ubuntu0.22.04.1

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
-- Table structure for table `meet`
--

DROP TABLE IF EXISTS `meet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `meet` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `user_id` int DEFAULT NULL,
                        `has_liked` tinyint(1) DEFAULT NULL,
                        `user_target_id` int DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        KEY `user_id` (`user_id`),
                        KEY `user_target_id` (`user_target_id`),
                        CONSTRAINT `meet_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
                        CONSTRAINT `meet_ibfk_2` FOREIGN KEY (`user_target_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `meet`
--

LOCK TABLES `meet` WRITE;
/*!40000 ALTER TABLE `meet` DISABLE KEYS */;
INSERT INTO `meet` VALUES (1,25,0,19),(2,25,1,22),(3,19,1,25),(4,22,1,25),(5,13,1,11),(6,16,1,25),(7,17,1,9),(8,21,1,6);
/*!40000 ALTER TABLE `meet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `music_style`
--

DROP TABLE IF EXISTS `music_style`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `music_style` (
                               `id` int NOT NULL AUTO_INCREMENT,
                               `style_name` varchar(50) NOT NULL,
                               PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `music_style`
--

LOCK TABLES `music_style` WRITE;
/*!40000 ALTER TABLE `music_style` DISABLE KEYS */;
INSERT INTO `music_style` VALUES (1,'Rock'),(2,'Jazz'),(3,'RnB'),(4,'Metal'),(5,'Rap'),(6,'Rock'),(7,'Pop'),(8,'Hip-hop'),(9,'Electro'),(10,'Classique'),(11,'Jazz'),(12,'Folk'),(13,'Rap'),(14,'Reggae'),(15,'Blues'),(16,'Rock'),(17,'Pop'),(18,'Hip-hop'),(19,'Electro'),(20,'Classique'),(21,'Jazz'),(22,'Folk'),(23,'Rap'),(24,'Reggae'),(25,'Blues'),(26,'Rock'),(27,'Pop'),(28,'Hip-hop'),(29,'Electro'),(30,'Classique'),(31,'Jazz'),(32,'Folk'),(33,'Rap'),(34,'Reggae'),(35,'Blues');
/*!40000 ALTER TABLE `music_style` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `user_name` varchar(50) NOT NULL,
                        `email` varchar(50) NOT NULL,
                        `password` varchar(255) NOT NULL,
                        `description` text,
                        `video` text,
                        `picture` text,
                        `user_type_id` int DEFAULT NULL,
                        `music_style_id` int DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `email` (`email`),
                        KEY `fk_user_user_type` (`user_type_id`),
                        KEY `fk_user_music_style` (`music_style_id`),
                        CONSTRAINT `fk_user_music_style` FOREIGN KEY (`music_style_id`) REFERENCES `music_style` (`id`),
                        CONSTRAINT `fk_user_user_type` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'The Groove Masters','groovemasters@example.com','password1G','Groupe de jazz fusion expérimental',NULL,NULL,2,6),(2,'Electric Echoes','echoes@example.com','password2E','Groupe électro aux sonorités planantes',NULL,NULL,2,4),(3,'Acoustic Serenade','serenade@example.com','password3A','Groupe acoustique avec des ballades douces',NULL,NULL,2,7),(4,'Rhythm Rascals','rhythmrascals@example.com','M0tdepasse1','Groupe de fusion jazz-funk',NULL,NULL,2,6),(5,'Melodic Harmony','melodicharmony@example.com','M0tdepasse2','Groupe pop mélodique avec des influences folk',NULL,NULL,2,2),(6,'Electro Pulse','electropulse@example.com','M0tdepasse3','Projet électro expérimental',NULL,NULL,2,4),(7,'Sonic Beats','sonicbeats@example.com','MdpSonicBeats1','Groupe mêlant rock et électro',NULL,NULL,2,1),(8,'Harmonious Waves','harmoniouswaves@example.com','MdpHarmoniousWaves2','Groupe pop avec des influences rétro',NULL,NULL,2,2),(9,'Funky Groove Collective','funkygroove@example.com','MdpFunkyGroove3','Collectif funky avec des cuivres et percussions',NULL,NULL,2,9),(10,'Melodic Fusion','melodicfusion@example.com','M3lod1cFus10n','Groupe expérimental mêlant différents styles',NULL,NULL,2,5),(11,'Soulful Rhythms','soulfulrhythms@example.com','S0ulfulRhytms21','Groupe de soul et de R&B',NULL,NULL,2,8),(12,'Eclectic Soundscape','eclecticsoundscape@example.com','3clect1cS0und$','Formation explorant divers genres musicaux',NULL,NULL,2,10),(13,'The Melody Hall','melodyhall@example.com','password4M','Salle de concert intimiste pour artistes émergents',NULL,NULL,1,NULL),(14,'Café du Coin','cafeducoin@example.com','password5C','Café accueillant des concerts acoustiques',NULL,NULL,1,NULL),(15,'Rythmique Lounge','rythmiquelounge@example.com','password6R','Espace dédié aux événements musicaux variés',NULL,NULL,1,NULL),(16,'Symphony Hall','symphonyhall@example.com','H0teMdp1','Grande salle de concert pour orchestres et ensembles',NULL,NULL,1,NULL),(17,'Café Rhythme','caferhythme@example.com','H0teMdp2','Café convivial accueillant des concerts live',NULL,NULL,1,NULL),(18,'The Stage Loft','stageloft@example.com','H0teMdp3','Espace de performance pour artistes émergents',NULL,NULL,1,NULL),(19,'Starlight Lounge','starlightlounge@example.com','MotPasseStarlight1','Salle de concert offrant une ambiance intimiste',NULL,NULL,1,NULL),(20,'Acoustic Corner','acousticcorner@example.com','MotPasseCorner2','Espace accueillant des concerts acoustiques',NULL,NULL,1,NULL),(21,'The Groovy Hall','groovyhall@example.com','MotPasseGroovy3','Salle polyvalente pour divers événements musicaux',NULL,NULL,1,NULL),(22,'Harmony Haven','harmonyhaven@example.com','H4rm0nyH@v3n11','Espace dédié à la musique harmonieuse',NULL,NULL,1,NULL),(23,'Groove Corner','groovecorner@example.com','Gr00v3C0rn3r22','Coin musical pour les amoureux du groove',NULL,NULL,1,NULL),(24,'Acoustic Serenity','acousticserenity@example.com','Ac0ust1cS3r3n1ty$','Atmosphère apaisante pour concerts acoustiques',NULL,NULL,1,NULL),(25,'Slipknot','slipknot@gmail.com','$2y$10$tbk9VtV9gwv59Q/VbmIAVu0T6fnDyOmrCXIUbG3Ok5dqKz9XXpoOS','Slipknot est un groupe de nu metal7 américain, originaire de Des Moines, dans l\'Iowa. Il est formé par le percussionniste Shawn Crahan, \nle batteur Joey Jordison, le bassiste Paul Gray et les guitaristes Kun Nong et Donnie Steele en 1995.','https://youtu.be/FdBqOCS8LmM?feature=shared',NULL,2,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_type`
--

DROP TABLE IF EXISTS `user_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_type` (
                             `id` int NOT NULL AUTO_INCREMENT,
                             `type_name` varchar(50) NOT NULL,
                             PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_type`
--

LOCK TABLES `user_type` WRITE;
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
INSERT INTO `user_type` VALUES (1,'Hôte'),(2,'Musicien'),(3,'Hôte'),(4,'Musicien'),(5,'admin');
/*!40000 ALTER TABLE `user_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'meet_and_zik'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-21 13:34:56
