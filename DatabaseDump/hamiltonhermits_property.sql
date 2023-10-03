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
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property`
--

LOCK TABLES `property` WRITE;
/*!40000 ALTER TABLE `property` DISABLE KEYS */;
INSERT INTO `property` VALUES (7,'Cozy Apartment',4,'A comfortable apartment with a great view','2023-09-01',4,2,'85 Hill Street','42.60137298115397','-45.55267983572413',0),(8,'Spacious Loft',4,'An open and airy loft space','2023-09-02',6,3,'12 bunker ave','34.60137298115397','85.55267983572413',0),(9,'Downtown Condo',4,'Modern condo in the heart of the city','2023-09-03',2,1,'52 newton drive','-42.60137298115397','-85.55267983572413',0),(10,'Luxury Penthouse',5,'Elegant penthouse with panoramic views','2023-09-04',4,2,'3 Price Alphred','42.60137298115397','85.55267983572413',0),(20,'The Willowwood Boarding House',2,'Nestled in a quiet, tree-lined residential neighborhood, The Willowwood Boarding House is a charming two-story Victorian-style property that offers a welcoming and affordable living experience for its residents. This well-maintained boarding house is known for its sense of community and cozy accommodations.','2023-09-30',3,3,'Willowwood','-29.64620609603575','29.85142089259893',0),(22,'Downtown apartment',5,'Escape to the tranquility of our charming woodland cabin, nestled deep within a lush forest. This idyllic retreat offers the perfect blend of rustic charm and modern comfort, providing you with an unforgettable getaway','2023-09-30',4,2,'29 welkom avenue','-27.98984059429694','26.746066793758168',0),(25,'Lego Land',5,' A whimsical retreat where creativity thrives. This charming property boasts colorful, Lego-themed decor, a vibrant play area, and a cozy haven for endless family fun','2023-09-30',6,3,'95  villa walk','-25.765745901241996','27.121468763989483',0),(26,'Nicks House',5,'Nicks house is a lovely house','2023-10-01',5,4,'95 winchester','42.60137298115397','-85.55267983572413',0),(31,'The White house ',2,'Welcome to the White House, the most iconic residence in the United States! This is your once-in-a-lifetime opportunity to stay in the heart of Washington D.C. and experience the rich history and grandeur of this historic home.\r\n\r\n','2023-10-02',50,3,'los angeles','34.05680390533125','-118.24231994615867',0),(32,'VGHS',4,'G.D productions','2023-10-02',20,1,'10 beaufort street makhanda','-33.31511065179325','26.525357397692517',0),(33,'Filler',3,'Filler','2023-05-06',2,2,'22 jump Street','38.89767449293828','27.031602934979492',0),(34,'some place',2,'sadsaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa','2023-10-02',NULL,3,'test','33.986647372958','50.678906723152316',0),(35,'Hotel California',2,'On a dark desert highway\r\nCool wind in my hair\r\nWarm smell of colitas\r\nRising up through the air\r\nUp ahead in the distance\r\nI saw a shimmering light\r\nMy head grew heavy and my sight grew dim\r\nI had to stop for the night\r\nThere she stood in the doorway\r\nI heard the mission bell\r\nAnd I was thinking to myself\r\n\"This could be Heaven or this could be Hell\"\r\nThen she lit up a candle\r\nAnd she showed me the way\r\nThere were voices down the corridor\r\nI thought I heard them say','2023-10-02',NULL,3,'california','36.72349517126469','-119.78761492500506',0);
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

-- Dump completed on 2023-10-02 22:51:33
