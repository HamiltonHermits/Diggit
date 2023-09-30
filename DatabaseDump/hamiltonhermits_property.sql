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
  PRIMARY KEY (`prop_id`),
  UNIQUE KEY `propId_UNIQUE` (`prop_id`),
  KEY `createdBy_idx` (`created_by`),
  CONSTRAINT `createdBy` FOREIGN KEY (`created_by`) REFERENCES `usertbl` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property`
--

LOCK TABLES `property` WRITE;
/*!40000 ALTER TABLE `property` DISABLE KEYS */;
INSERT INTO `property` VALUES (1,'testPropertyPleaseWork',4,'lool','2023-02-02',2,1,'','',''),(7,'Cozy Apartment',4,'A comfortable apartment with a great view','2023-09-01',4,2,'','',''),(8,'Spacious Loft',4,'An open and airy loft space','2023-09-02',6,3,'','',''),(9,'Downtown Condo',4,'Modern condo in the heart of the city','2023-09-03',2,1,'','',''),(10,'Luxury Penthouse',5,'Elegant penthouse with panoramic views','2023-09-04',4,2,'','',''),(13,'testAgain',2,'Testing to see if this works','2023-09-29',NULL,NULL,'somewhere','-27.731779255000504','30.036654473668158'),(14,'testGsdas',2,'asdsadsadsad','2023-09-29',NULL,1,'dasdsasda','-27.644782233903054','27.861440836411926'),(15,'testGsdas',2,'asdsadsadsad','2023-09-29',NULL,NULL,'dasdsasda','-27.644782233903054','27.861440836411926'),(16,'testGsdas',2,'asdsadsadsad','2023-09-29',NULL,NULL,'dasdsasda','-27.644782233903054','27.861440836411926'),(17,'saveimagetoo table',2,'why dont you save please i beg you','2023-09-29',NULL,2,'somewhere','-29.535914245344994','30.827796248748413'),(18,'saveimagetoo table',2,'why dont you save please i beg you','2023-09-29',NULL,NULL,'somewhere','-29.535914245344994','30.827796248748413'),(19,'saveimagetoo table',2,'why dont you save please i beg you','2023-09-29',NULL,NULL,'somewhere','-29.535914245344994','30.827796248748413');
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

-- Dump completed on 2023-09-30 12:01:36
