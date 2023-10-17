
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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
