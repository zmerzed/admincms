-- MySQL dump 10.13  Distrib 8.0.34, for Linux (aarch64)
--
-- Host: localhost    Database: simsa
-- ------------------------------------------------------
-- Server version	8.0.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `product_logs`
--

DROP TABLE IF EXISTS `product_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `product_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mode` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `product_id` int NOT NULL,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_logs`
--

LOCK TABLES `product_logs` WRITE;
/*!40000 ALTER TABLE `product_logs` DISABLE KEYS */;
INSERT INTO `product_logs` VALUES (1,'in',1,1,'2023-10-16'),(2,'in',50,1,'2023-10-16'),(3,'out',10,1,'2023-10-16'),(4,'in',5,5,'2023-10-16'),(5,'out',4,5,'2023-10-16'),(6,'in',5,12,'2023-10-17'),(7,'out',2,12,'2023-10-17'),(8,'in',1,1,'2023-10-17'),(9,'out',1,1,'2023-10-17'),(10,'in',10,1,'2023-10-17'),(12,'out',5,1,'2023-10-17'),(13,'out',20,1,'2023-10-28'),(14,'out',1,16,'2023-11-10'),(15,'in',1,1,'2023-11-10'),(16,'in',20,4,'2023-11-10'),(17,'in',5,3,'2023-11-11'),(18,'in',3,17,'2023-11-11'),(19,'in',1,17,'2023-11-11'),(20,'in',1,17,'2023-11-11'),(21,'out',1,17,'2023-11-11'), (29,'out',1,1,'2023-9-17'),
;
/*!40000 ALTER TABLE `product_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(100) NOT NULL,
  `quantity` int NOT NULL,
  `low_quantity_level` int NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `is_delete` smallint DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Coca Cola Bundle',60,10,'drinks','2023-09-15','2023-11-10',NULL,NULL),(2,'Potato',11,5,'kitchen','2023-09-15','2023-09-15',NULL,NULL),(3,'Table Plate',8,15,'kitchen','2023-09-15','2023-11-11',NULL,NULL),(4,'Shrimp package',24,10,'kitchen','2023-09-15','2023-11-10',NULL,NULL),(5,'Nestea Drink',101,40,'drinks','2023-09-15','2023-11-10',NULL,NULL),(8,'UFC Ketchup',33,10,'kitchen','2023-09-15','2023-09-15',NULL,NULL),(9,'Japanese Knife',33,5,'kitchen','2023-09-15','2023-09-15',NULL,NULL),(10,'Magnolia Hotdog',22,11,'kitchen','2023-09-15','2023-09-15',NULL,NULL),(11,'1 Dozen Egg',22,13,'kitchen','2023-09-15','2023-09-15',NULL,NULL),(12,'Tempura Pack',25,20,'kitchen','2023-09-15','2023-10-17',NULL,NULL),(16,'Purefoods French Fries',10,10,'kitchen','2023-01-18','2023-11-10',NULL,NULL),(17,'Magnolia Chicken Nuggets',5,10,'kitchen','2023-10-01','2023-11-11',NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(100) DEFAULT NULL,
  `access_level` int DEFAULT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 ;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin','password','+639945181366',1,NULL,NULL),(2,'guest','guestuser','password','+639945181366',2,'2023-09-26','2023-10-17');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-11-11 11:55:00
