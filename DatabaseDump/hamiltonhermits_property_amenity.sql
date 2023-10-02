-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: IS3-DEV.ICT.RU.AC.ZA    Database: hamiltonhermits
-- ------------------------------------------------------
-- Server version	8.0.20

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
-- Table structure for table `property_amenity`
--

DROP TABLE IF EXISTS `property_amenity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `property_amenity` (
  `prop_amenity_id` int NOT NULL AUTO_INCREMENT,
  `prop_id` int NOT NULL,
  `amenity_id` int NOT NULL,
  PRIMARY KEY (`prop_amenity_id`),
  KEY `propId_idx` (`prop_id`),
  KEY `amenityId_idx` (`amenity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=utf8 COMMENT='Junction table';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property_amenity`
--

LOCK TABLES `property_amenity` WRITE;
/*!40000 ALTER TABLE `property_amenity` DISABLE KEYS */;
INSERT INTO `property_amenity` VALUES (1,1,1),(2,1,2),(3,1,3),(4,1,4),(5,1,5),(12,1,6),(13,1,7),(15,2,1),(16,11,1),(17,11,2),(18,11,1),(19,11,2),(20,13,1),(21,13,2),(22,13,3),(23,14,5),(24,14,6),(25,14,7),(26,14,5),(27,14,6),(28,14,7),(29,14,5),(30,14,6),(31,14,7),(32,17,1),(33,17,5),(34,17,7),(35,17,1),(36,17,5),(37,17,7),(38,20,1),(39,20,2),(40,20,3),(41,20,4),(42,22,2),(43,22,3),(44,22,4),(45,25,5),(46,25,6),(47,25,7),(48,26,2),(49,26,3),(50,26,4),(51,26,5),(52,26,6),(53,26,7),(54,26,8),(55,27,1),(56,27,2),(57,28,1),(58,29,1),(59,29,2),(60,30,1),(61,30,2),(62,30,3),(63,30,4),(72,32,1),(73,32,10),(74,32,12),(75,34,4),(76,34,5),(77,34,6),(78,34,7),(79,34,8),(80,35,1),(81,35,2),(82,35,3),(83,35,4),(84,35,5),(85,35,6),(86,35,7),(87,35,8),(88,35,9),(89,35,10),(90,35,11),(91,35,12),(173,31,1),(174,31,2),(175,31,3),(176,31,4),(177,31,5),(178,31,6),(179,31,7),(180,31,8),(181,31,9),(182,31,10),(183,31,11),(184,31,12);
/*!40000 ALTER TABLE `property_amenity` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-02 22:51:34
