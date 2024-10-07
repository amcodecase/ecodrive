/*!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ecodrive
-- ------------------------------------------------------
-- Server version	10.6.18-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tolls`
--

DROP TABLE IF EXISTS `tolls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tolls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `toll_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tolls`
--

LOCK TABLES `tolls` WRITE;
/*!40000 ALTER TABLE `tolls` DISABLE KEYS */;
INSERT INTO `tolls` VALUES (1,'Chongwe Toll Plaza','Chongwe','2024-09-11 20:05:05'),(2,'Shimabala Toll Plaza','Shimabala','2024-09-12 18:27:13'),(3,'Katuba Toll Plaza','Chisamba','2024-09-12 18:27:36'),(4,'Katuba Toll Plaza','Chisamba','2024-09-12 20:52:56'),(5,'Kalusa','Tasha','2024-10-02 20:45:09');
/*!40000 ALTER TABLE `tolls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','toll_assistant','driver','police') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `qr_code` text DEFAULT NULL,
  `toll_crossings` int(11) DEFAULT 0,
  `payments_made` int(11) DEFAULT 0,
  `outstanding_balance` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@ecodrive.zm','81dc9bdb52d04dc20036dbd8313ed055','admin','2024-09-11 19:33:04','','',NULL,0,0,0.00),(2,'assistant@ecodrive.zm','81dc9bdb52d04dc20036dbd8313ed055','toll_assistant','2024-09-11 19:33:04','','',NULL,0,0,0.00),(3,'driver1@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','driver','2024-09-11 19:33:04','','',NULL,0,0,0.00),(4,'driver2@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','driver','2024-09-11 19:33:04','','',NULL,0,0,0.00),(5,'police1@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','police','2024-09-11 19:33:04','','',NULL,0,0,0.00),(6,'police2@gmail.com','81dc9bdb52d04dc20036dbd8313ed055','police','2024-09-11 19:33:04','','',NULL,0,0,0.00),(7,'justusmichelo@chau.ac.zm','14a660c35308b550d04414a9cbaa10bc','admin','2024-10-02 14:30:15','','',NULL,0,0,0.00),(10,'chomiecho@gmail.com','f87522788a2be2d171666752f97ddebb','admin','2024-10-02 14:47:44','','',NULL,0,0,0.00),(11,'bc@ecodrive.zm','8fb134f258b1f7865a6ab2d935a897c9','toll_assistant','2024-10-02 14:51:16','','',NULL,0,0,0.00),(12,'christa@bel.com','87f7098aa40a8ba5faa51fefa2631f60','admin','2024-10-02 20:50:42','','',NULL,0,0,0.00),(13,'mirriam@nam.com','5a4be1fa34e62bb8a6ec6b91d2462f5a','driver','2024-10-02 20:52:04','','',NULL,0,0,0.00),(16,'justusmichelo@chau.edu','162b22f46101df67d0071b8acfb90435','driver','2024-10-07 12:50:51','Justus','Michelo',NULL,0,0,0.00),(18,'gerald@ictaz.org','a4f16d327329e3c1a9b32613465b3abc','admin','2024-10-07 12:54:57','Gerald','Limbando','iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFEElEQVR4nO3dQW4bQQwAQW+Q/3/ZeUAOGgc7YHqm6mxY0koNngg+39/fX0DTr+k3APw7AUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEPZ78e+e59n6Ps5w3mbI+ve+/tn9llYsPk8TGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhbHUbad3NGzmz//M8fksfmcAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGHvbyOtm93Imd102fHqO+4YVVz7WzKBIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCJreRbja7ObRjd+e8DacEExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIcw20oz13Z2bLx7xkQkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBA2uY108/bMjutEO1698h1V3ufrTGAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChrD3t5Fm92zOM3tFaXZvyW/pIxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHsufaoTMV5d4x4kQkMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBC2ehvpvCs1O+4DVcx+ovOuPQ1ujJnAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxh799GOm93p7LpMmvHZSbP8yMTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAh7N7bSOsGL9/8yOw+0I7/ueMTHba3ZAJDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIRN3kaa3d3ZYcf+ynlPaV1iH+hr9DsygSFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwu69jTT7iXZc6Jm9+jN7x2jdYdtyJjCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9j7t5FYUdmFWje7NXXeJtYiExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIeze20g7zN4H2vEdzV4Smt1bWjf46iYwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY6m2k2W2PWdduuvzIzftqg1tTJjCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9jqbaQdZvdXztvdufl5rjtsa8oEhjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIm9xG4l07LvSsq9xw2mHws5vAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhtpH+d7O7Oztefccu1I73mdiaMoEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMImt5ES2x7jdtzdOe/J73hKO7am1i2+TxMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs/W2k2R2O81S2Z9ZVdqF2PPnXP7sJDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9lRWQ4C/mcAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGML+AM0t+HksKNqNAAAAAElFTkSuQmCC',0,0,0.00),(19,'justusmichelo@natec.zm','d892676d56a3b0ccb7f268b8bbb319df','driver','2024-10-07 12:56:20','Justus','Michelo','iVBORw0KGgoAAAANSUhEUgAAAUAAAAFACAIAAABC8jL9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAE/klEQVR4nO3dMW4cMRBFQa/h+19ZDh2KMKbdfpyqWJB2R/PA6IOfr6+vH0DTz+0PAPw9AUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEPbr8Oc+n8/o57jD+TJk4nlO/PWJrYt36cThk3cCQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCEna6Rzt13V8vucmhCZbfkXfqWExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIez5NdK53TtydpcuEyuf3eXQrte+S05gCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoawzTUSJ3Z3S/znnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGHWSPeY2Bjdd4vSZZzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhm2ukNy9ddr/7+W5p4mamCa99l5zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhz6+RJm7ouc/Eymf3d07wLn3LCQxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAEPZ57aUyFZVFjhdphRMYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCHs9G6kN29i3nyP0e43Orf7fi4+JScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY6RqpYmITM7Ge2d0YndvdGPEtJzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ9gnMSKp3CR0LvHYr1S56eqQExjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIex0jVS5I2diY7S7cPI8n/2d5xL/TScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY5t1I9y2c7Gz4x5zAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhm2ukN7vvzqGJb3Su8ho//uSdwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYadrpN2tScV99xjd99cnLG6hnMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIQJGMIEDGG/Hv+NlVtqzlU2MRMmlkP33cx0zt1IwB8ChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAhTMAQ9vwa6dzuguS+1dR932hit7Tr8c/pBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCNtcI73ZffcD7e6BJr57YuHkBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCLNGusfEemZi5TOxxKpsth7nBIYwAUOYgCFMwBAmYAgTMIQJGMIEDGEChjABQ5iAIUzAECZgCNtcIyXunln35luUKsuhif/RIScwhAkYwgQMYQKGMAFDmIAhTMAQJmAIEzCECRjCBAxhAoYwAUPY82ukyoKkYne78+bF2OLG6JwTGMIEDGEChjABQ5iAIUzAECZgCBMwhAkYwgQMYQKGMAFDmIAh7PPmuQnUOYEhTMAQJmAIEzCECRjCBAxhAoYwAUOYgCFMwBAmYAgTMIT9BhXL/nnVtqz4AAAAAElFTkSuQmCC',0,0,0.00);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicle_classes`
--

DROP TABLE IF EXISTS `vehicle_classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicle_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `toll_fee` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicle_classes`
--

LOCK TABLES `vehicle_classes` WRITE;
/*!40000 ALTER TABLE `vehicle_classes` DISABLE KEYS */;
INSERT INTO `vehicle_classes` VALUES (1,'Class 1','Light vehicles, 3,500 - 6,500 Kg, motor cars, vans, mini buses',15.00),(2,'Class 2','Buses with 24 seats and above',20.00),(3,'Class 3','Medium heavy vehicles (16,501 - 30,000 Kg), 2/3 axles',25.00),(4,'Class 4','Large heavy vehicles (30,000 - 56,000 Kg), 3/4 axles',40.00),(5,'Class 5','Large heavy vehicles, more than 56,000 Kg',80.00),(6,'Class 6','Extra large vehicles, 70,000 Kg, 5+ axles',160.00);
/*!40000 ALTER TABLE `vehicle_classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vehicles`
--

DROP TABLE IF EXISTS `vehicles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vehicle_number` varchar(50) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `class_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vehicles`
--

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-10-07 15:27:46
