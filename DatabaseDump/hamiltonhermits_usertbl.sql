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
-- Table structure for table `usertbl`
--

DROP TABLE IF EXISTS `usertbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usertbl` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(200) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `is_admin` tinyint NOT NULL,
  `is_agent` tinyint NOT NULL,
  `email` varchar(50) NOT NULL,
  `is_deleted` tinyint NOT NULL,
  `agent_phone` varchar(10) DEFAULT NULL,
  `agent_company` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `user_name_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertbl`
--

LOCK TABLES `usertbl` WRITE;
/*!40000 ALTER TABLE `usertbl` DISABLE KEYS */;
INSERT INTO `usertbl` VALUES (1,'s','s','s','s',0,0,'some@gma',0,NULL,NULL),(2,'demo','$2y$10$QA6HOJc/T3WhN0MKwtM2keNo/.Ybs89kcsECkTixiV45qC.1priaC','klark','kent',0,1,'demo@gmail.com',0,'0831231234','Femboys Inc'),(3,'demo1','$2y$10$zfySZIdu8t0ryBbwJ3yMle2VjceqOl63RQw3T0YVYjAtVm4jDXPVa','Kevin','Daniel',0,0,'demo1@gmail.com',0,NULL,NULL),(4,'manu','$2y$10$OP2ybDocf4cBGFdvLsp8ouAxZdSsee6Oc0CdIvbVt2ZXMR8joDKxO','Manu','Jourdan',0,1,'manu@gmail.com',0,'1123456789','manu company'),(5,'cameron','$2y$10$R0.SADn6WVp0/.U1YR75YuM8gTJR0N7ncAVj0sDPdKVw5Yha/P0oy','Cameron','Wicks',0,1,'cameron@gmail.com',0,'9987654321','cameron and co.'),(6,'Wynne1','$2y$10$BHqnwkJ0X8j0q9tsJBzdKOZC300RauX5gKYqu9vomEmhKT1BZ9uya','Wynne','Eeeeeee',1,1,'wynne1@gmail.com',0,NULL,NULL),(7,'demo2','$2y$10$xuk24J5ZySS7bRuwo6xLze1pbv1uGjTVPtZJPMvcTj4huRVO5OgMm','david','Dave',0,0,'demo2@gmail.com',1,NULL,NULL),(8,'demo5','$2y$10$KUibkqsx2.uYgYpOFnxvuedgIja7CHY656qPzUgduGMR3vf4ISeVK','fasbkjas','as,fskas',0,0,'demo5@gmail.com',0,NULL,NULL);
/*!40000 ALTER TABLE `usertbl` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-28 18:58:29
