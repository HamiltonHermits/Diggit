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
-- Table structure for table `review`
--

DROP TABLE IF EXISTS `review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `review` (
  `review_id` int NOT NULL,
  `prop_id` int NOT NULL,
  `politeness_rating` int NOT NULL,
  `written_review` varchar(300) DEFAULT NULL,
  `cleanliness_rating` int NOT NULL,
  `noise_rating` int NOT NULL,
  `location_rating` int NOT NULL,
  `saftey_rating` int NOT NULL,
  `affordability_rating` int NOT NULL,
  `repair_quality_rating` int NOT NULL,
  `response_time_rating` int NOT NULL,
  `user_id` int NOT NULL,
  `overall_tenant_rating` int NOT NULL,
  `date_reviewed` date NOT NULL,
  `overall_property_rating` int NOT NULL,
  PRIMARY KEY (`review_id`),
  UNIQUE KEY `review_id_UNIQUE` (`review_id`),
  KEY `prop_id_idx` (`prop_id`),
  KEY `user_id_idx` (`user_id`),
  KEY `user_id_idxx` (`user_id`),
  CONSTRAINT `prop_id` FOREIGN KEY (`prop_id`) REFERENCES `property` (`prop_id`),
  CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `usertbl` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review`
--

LOCK TABLES `review` WRITE;
/*!40000 ALTER TABLE `review` DISABLE KEYS */;
INSERT INTO `review` VALUES (1,31,5,' A historic gem! Iconic architecture, rich history, and grandeur define this remarkable property. A must-visit for its cultural significance.',5,5,5,5,1,5,5,5,5,'2020-10-05',5),(2,7,3,'This has to be one of the cozest places ever but the wifi sucks',2,2,2,1,2,2,2,2,2,'2020-03-03',3),(3,25,4,'The lego is pretty cool here ',1,2,3,2,1,5,5,6,5,'2022-08-12',4);
/*!40000 ALTER TABLE `review` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-02 21:44:17
