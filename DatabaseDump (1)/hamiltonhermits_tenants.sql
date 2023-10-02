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
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tenants` (
  `id_prop_tenant` int NOT NULL AUTO_INCREMENT,
  `prop_id` int NOT NULL,
  `tenant_id` varchar(450) NOT NULL,
  PRIMARY KEY (`id_prop_tenant`),
  UNIQUE KEY `id_prop_tenant_UNIQUE` (`id_prop_tenant`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tenants`
--

LOCK TABLES `tenants` WRITE;
/*!40000 ALTER TABLE `tenants` DISABLE KEYS */;
INSERT INTO `tenants` VALUES (1,17,'hello@gmail.com'),(2,17,'what@gmail.com'),(3,20,'michaelgreen@gmail.com'),(4,20,'nomie@gmail.com'),(5,20,'sandman@gmail.com'),(6,22,'demo1@gmail.com'),(7,22,'demo2@gmail.com'),(8,25,'demo1@gmail.com'),(9,26,'someone@gmail.com'),(10,27,'someone@gmail.com'),(11,28,'some@gmail.com'),(12,29,'Ibeg@gmail.com'),(13,30,'some@gmail.com'),(15,32,'garwindampies@gmail.com'),(16,7,'admin@gmail.com'),(18,34,'sdsa@gmail.com'),(19,34,'new@gmail.com'),(20,34,'sdsass@gmail.com'),(21,35,'demo@gmail.com'),(22,35,'someone@gmail.com'),(23,35,'manu@gmail.com'),(36,31,'admin@gmail.com'),(37,31,'demo@gmail.com'),(38,31,'manu@gmail.com'),(39,31,'trump@gmail.com');
/*!40000 ALTER TABLE `tenants` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-10-02 21:44:18
