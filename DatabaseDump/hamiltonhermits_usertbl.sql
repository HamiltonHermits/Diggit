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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertbl`
--

LOCK TABLES `usertbl` WRITE;
/*!40000 ALTER TABLE `usertbl` DISABLE KEYS */;
INSERT INTO `usertbl` VALUES (12,'Wynne','$2y$10$tR363hI3Z9iRyIFZwHMRBOUPf1D2.2E/8VlrU.guATSDWsABftIe6','Wynne','Edwards',0,0,'wynne@gmail.com',0,NULL,NULL,NULL),(13,'Tyler','$2y$10$gl7XhctgeQkAH5a6dV4UlOeJwVkAAj04pM.ASA8ARauVLk2PKfKj2','Tyler','Baxter',0,0,'tyler@gmail.com',0,NULL,NULL,NULL),(14,'Cameron','$2y$10$E1p45wSGNUeD5IQS97TfqOsZyGHde4l1l1mydMRnK0fDDEmVuEwb6','Cameron','Wicks',0,0,'cameron@gmail.com',0,NULL,NULL,NULL),(15,'Manu','$2y$10$LqqMyLC.mVt6r83hOVw5XuJC2/lT.fWWFGVRKq.mzKbHVo7OCss6O','Manu','Jourdan',0,0,'manu@gmail.com',0,NULL,NULL,NULL),(16,'Johnny','$2y$10$9SxtK8cZcLaE3N/3uAwMhex8PTb0dI88n1CtHkc6IFP13RJM2fioa','Johnny ','Sins',0,1,'johny@gmail.com',0,'0863264253','Property24','1696347809aN7zVPw2_700w_0.jpg'),(17,'Karen','$2y$10$A90tXREZiSi2JqyEgphR6.vGyFhclDohkd6fm5mhw4gkXzwxa0l5e','Karen','Kliff',0,1,'karen@gmail.com',0,'0423264234','Oaktree','1696348046photo-1438761681033-6461ffad8d80.jpeg'),(18,'admin','$2y$10$lg7PT9MoxdTBhupmbPcb4e0yhqH5oUVpmqyvx5U4g5lZwjaRlQufO','admin','admin',0,0,'admin@gmail.com',0,NULL,NULL,NULL),(19,'Robert','$2y$10$uuQOHskcv27M7xHz7Op46eRr4nEJ4bSkkgWqnh2COeBZxondUc.LC','Robert ','Anderson',0,1,'pebble@gmail.com',0,'0121138759','RE/MAX south africa','1696349043Robert_Anderson_QC_rOqVQSu.2e16d0ba.fill-600x440.jpg'),(20,'Laura','$2y$10$hakhw16XEj.TJ1nTKrnsdejJ.VKl7H3sigmd6HVNgHhigOqsi90QO','Laura','Johnson',0,1,'laura@gmail.com',0,'0232557741','SAHometraders','1696349710photo-1627161683077-e34782c24d81.jpeg');
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

-- Dump completed on 2023-10-03 18:21:28
