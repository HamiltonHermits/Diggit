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
-- Table structure for table `property`
--

DROP TABLE IF EXISTS `property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `property` (
  `prop_id` int NOT NULL AUTO_INCREMENT,
  `prop_name` varchar(50) NOT NULL,
  `created_by` int NOT NULL,
  `prop_description` varchar(5000) NOT NULL,
  `created_on` date NOT NULL,
  `max_tenants` int DEFAULT NULL,
  `curr_tenants` int DEFAULT NULL,
  `address` varchar(450) NOT NULL,
  `lat` varchar(450) NOT NULL,
  `long` varchar(450) NOT NULL,
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`prop_id`),
  UNIQUE KEY `propId_UNIQUE` (`prop_id`),
  KEY `createdBy_idx` (`created_by`),
  CONSTRAINT `createdBy` FOREIGN KEY (`created_by`) REFERENCES `usertbl` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property`
--

LOCK TABLES `property` WRITE;
/*!40000 ALTER TABLE `property` DISABLE KEYS */;
INSERT INTO `property` VALUES (36,'The Greens',16,'If you are looking for a flat or an apartment that is situated in a garden setting, this is the place for you! This highly sought after complex is ideally situated close to Rhodes and the Peppergrove Mall and extremely popular with students. It has two sizeable bedrooms, one bathroom, open plan kitchen/lounge, resnet for students, 24 hour security and off street parking. Its on the ground floor which gives you instant access to the garden area.','2023-10-03',NULL,1,'11 New Street','-33.30894488803071','26.523704072019388',0);
/*!40000 ALTER TABLE `property` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-03 18:21:29
