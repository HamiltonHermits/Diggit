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
  `is_deleted` tinyint NOT NULL DEFAULT '0',
  `agent_phone` varchar(10) DEFAULT NULL,
  `agent_company` varchar(50) DEFAULT NULL,
  `profile_pic` varchar(450) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_id_UNIQUE` (`user_id`),
  UNIQUE KEY `user_name_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertbl`
--

LOCK TABLES `usertbl` WRITE;
/*!40000 ALTER TABLE `usertbl` DISABLE KEYS */;
INSERT INTO `usertbl` VALUES (2,'demo','$2y$10$JdIRcAosIOyPoHYdDbjMMedmCRv2.GR0F3pdV4eThQB1dMDTTpwEy','Kevin','Klark',0,1,'demo@gmail.com',0,'0121231234','Remax','1696108761photo-1438761681033-6461ffad8d80.jpeg'),(3,'demo1','$2y$10$zfySZIdu8t0ryBbwJ3yMle2VjceqOl63RQw3T0YVYjAtVm4jDXPVa','Marc','Daniel',0,1,'demo1@gmail.com',0,'0821212232','Bananans','1696277237photo-1481349518771-20055b2a7b24.jpeg'),(4,'manu','$2y$10$OP2ybDocf4cBGFdvLsp8ouAxZdSsee6Oc0CdIvbVt2ZXMR8joDKxO','Manu','Jourdan',0,1,'manu@gmail.com',0,'1123456789','manu company',NULL),(5,'cameron','$2y$10$R0.SADn6WVp0/.U1YR75YuM8gTJR0N7ncAVj0sDPdKVw5Yha/P0oy','Cameron','Wicks',0,1,'cameron@gmail.com',0,'9987654321','cameron and co.',NULL),(6,'Wynne1','$2y$10$BHqnwkJ0X8j0q9tsJBzdKOZC300RauX5gKYqu9vomEmhKT1BZ9uya','Wynne','Eeeeeee',1,1,'wynne1@gmail.com',0,'0435216851','Wynne lnadlords',NULL),(9,'admin','$2y$10$iQUE4o9faiMkm7EjNJZ8Web1rG8syW.SvCLucrpjA/EbY0OxvuuXK','Admin','Kent',0,0,'admin@gmail.com',0,NULL,NULL,NULL),(10,'mila','$2y$10$wdcDPaj66nZ6bB89ueaf2ulCgraB3ekmI7xHRChLgyh4aT2u2VKtK','Mila-jo','Davies',0,0,'daviesmila@gmail.com',0,NULL,NULL,NULL),(11,'Biden','$2y$10$E2zrPQpZjrdIUCqEdOm19e5GTHAt8ehuYxEBrmFbNJ5.tcSUHoPOq','Joe','Biden',0,0,'biden@gmail.com',0,NULL,NULL,NULL);
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

-- Dump completed on 2023-10-02 22:51:33