-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: hamiltonhermits
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.28-MariaDB

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
  `prop_id` int(11) NOT NULL AUTO_INCREMENT,
  `prop_name` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `prop_description` varchar(5000) NOT NULL,
  `created_on` date NOT NULL,
  `max_tenants` int(11) DEFAULT NULL,
  `curr_tenants` int(11) DEFAULT NULL,
  `address` varchar(450) NOT NULL,
  `lat` varchar(450) NOT NULL,
  `long` varchar(450) NOT NULL,
  PRIMARY KEY (`prop_id`),
  UNIQUE KEY `propId_UNIQUE` (`prop_id`),
  KEY `createdBy_idx` (`created_by`),
  CONSTRAINT `createdBy` FOREIGN KEY (`created_by`) REFERENCES `usertbl` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `property`
--

LOCK TABLES `property` WRITE;
/*!40000 ALTER TABLE `property` DISABLE KEYS */;
INSERT INTO `property` VALUES (1,'testPropertyPleaseWork',4,'lool','2023-02-02',2,1,'','',''),(7,'Cozy Apartment',4,'A comfortable apartment with a great view','2023-09-01',4,2,'','',''),(8,'Spacious Loft',4,'An open and airy loft space','2023-09-02',6,3,'','',''),(9,'Downtown Condo',4,'Modern condo in the heart of the city','2023-09-03',2,1,'','',''),(10,'Luxury Penthouse',5,'Elegant penthouse with panoramic views','2023-09-04',4,2,'','',''),(13,'testAgain',2,'Testing to see if this works','2023-09-29',NULL,NULL,'somewhere','-27.731779255000504','30.036654473668158'),(14,'testGsdas',2,'asdsadsadsad','2023-09-29',NULL,1,'dasdsasda','-27.644782233903054','27.861440836411926'),(15,'testGsdas',2,'asdsadsadsad','2023-09-29',NULL,NULL,'dasdsasda','-27.644782233903054','27.861440836411926'),(16,'testGsdas',2,'asdsadsadsad','2023-09-29',NULL,NULL,'dasdsasda','-27.644782233903054','27.861440836411926'),(17,'saveimagetoo table',2,'why dont you save please i beg you','2023-09-29',NULL,2,'somewhere','-29.535914245344994','30.827796248748413'),(18,'saveimagetoo table',2,'why dont you save please i beg you','2023-09-29',NULL,NULL,'somewhere','-29.535914245344994','30.827796248748413'),(19,'saveimagetoo table',2,'why dont you save please i beg you','2023-09-29',NULL,NULL,'somewhere','-29.535914245344994','30.827796248748413'),(20,'The Willowwood Boarding House',2,'Nestled in a quiet, tree-lined residential neighborhood, The Willowwood Boarding House is a charming two-story Victorian-style property that offers a welcoming and affordable living experience for its residents. This well-maintained boarding house is known for its sense of community and cozy accommodations.','2023-09-30',NULL,3,'Willowwood','-29.64620609603575','29.85142089259893'),(22,'Downtown apartment',2,'Escape to the tranquility of our charming woodland cabin, nestled deep within a lush forest. This idyllic retreat offers the perfect blend of rustic charm and modern comfort, providing you with an unforgettable getaway','2023-09-30',NULL,2,'29 welkom avenue','-27.98984059429694','26.746066793758168'),(25,'Lego Land',2,'basdbjniasdjknlasdklnoa','2023-09-30',NULL,1,'95 ass ville','-25.765745901241996','27.121468763989483'),(26,'Nicks House',2,'Nicks house is a lovely house','2023-10-01',NULL,1,'95 winchester','42.60137298115397','-85.55267983572413'),(27,'Property Test 1',2,'This is a test','2023-10-01',NULL,1,'dasdsasda','-29.59196832275573','28.39350827021128'),(28,'test1 property',2,'test property description','2023-10-01',NULL,1,'test property adress','-28.94026087069308','26.855873214304424'),(29,'test1',2,'this is to test the ajax response','2023-10-01',NULL,1,'Please work','-29.706542946831675','26.94373807464194'),(30,'A meanignsm',2,'here is a desc','2023-10-01',NULL,1,'testt 1','-28.439110035077235','27.031602934979492'),(31,'Whitehouse',2,'Welcome to the White House, the most iconic residence in the United States! This is your once-in-a-lifetime opportunity to stay in the heart of Washington D.C. and experience the rich history and grandeur of this historic home.\r\n\r\nSpace:\r\n\r\nOur spacious and elegantly furnished White House offers a unique blend of history and modern amenities. With 132 rooms, including the famous Oval Office, multiple bedrooms, formal dining rooms, and beautiful garden areas, you\'ll have ample space to explore and re','2023-10-01',NULL,1,'whitehouse','38.89767449293828','-77.03660036222666');
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

-- Dump completed on 2023-10-01 19:36:29
