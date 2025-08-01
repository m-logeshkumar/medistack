-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: medi_stack
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `appointments`
--

DROP TABLE IF EXISTS `appointments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `appointments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `patient_id` int NOT NULL,
  `doctor_id` int NOT NULL,
  `appointment_date` datetime NOT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `patient_id` (`patient_id`),
  KEY `doctor_id` (`doctor_id`),
  CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `appointments`
--

LOCK TABLES `appointments` WRITE;
/*!40000 ALTER TABLE `appointments` DISABLE KEYS */;
INSERT INTO `appointments` VALUES (1,2,1,'2025-04-02 15:00:00','Pending','2025-03-31 09:37:20'),(2,9,1,'2025-04-03 18:00:00','Pending','2025-03-31 10:32:52'),(3,2,10,'2025-04-05 17:00:00','Pending','2025-03-31 11:16:55'),(4,9,1,'2025-04-04 18:00:00','Pending','2025-03-31 13:29:46'),(5,9,7,'2025-07-02 21:12:00','Pending','2025-07-02 15:42:40');
/*!40000 ALTER TABLE `appointments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chats`
--

DROP TABLE IF EXISTS `chats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `message` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('doctor','patient') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chats`
--

LOCK TABLES `chats` WRITE;
/*!40000 ALTER TABLE `chats` DISABLE KEYS */;
INSERT INTO `chats` VALUES (1,1,'care your health','2025-03-31 11:50:22','doctor'),(2,9,'ok sir','2025-03-31 11:50:49','patient'),(3,1,'hi','2025-04-04 06:41:38','doctor'),(4,1,'Hello','2025-06-10 05:42:49','doctor'),(5,10,'hi','2025-07-02 15:33:48','doctor');
/*!40000 ALTER TABLE `chats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `patients` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `age` int NOT NULL,
  `gender` enum('Male','Female','Other') NOT NULL,
  `medical_history` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  CONSTRAINT `patients_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,9,'lee@gmail.com','123456789',34,'Female',' No'),(2,2,'alice@gmail.com','1234567890',30,'Female','No known medical history'),(3,4,'sarah.lee@gmail.com','9876543210',28,'Female','Allergic to penicillin'),(4,6,'emma.wilson@email.com','5556677889',35,'Female','History of asthma'),(5,8,'olivia.martin@email.com','1122334455',40,'Female','Diabetic, Type 2'),(8,11,'smith@gmail.com','9311934492',35,'Male','No known medical history'),(9,12,'dass@gmail.com','9311383765',22,'Male','No known history');
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescriptions`
--

DROP TABLE IF EXISTS `prescriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prescriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `doctor_id` int DEFAULT NULL,
  `patient_id` int DEFAULT NULL,
  `medication` text NOT NULL,
  `dosage` text NOT NULL,
  `instructions` text NOT NULL,
  `date_issued` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `doctor_id` (`doctor_id`),
  KEY `patient_id` (`patient_id`),
  CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`),
  CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescriptions`
--

LOCK TABLES `prescriptions` WRITE;
/*!40000 ALTER TABLE `prescriptions` DISABLE KEYS */;
INSERT INTO `prescriptions` VALUES (1,10,9,'Paracetamol','200mg','Take one tablet every 10 hours for pain relief ','2025-03-31 11:19:50'),(2,1,8,'Paracetamol','200mg','Take one tablet every 10 hours for pain relief ','2025-03-31 13:27:49'),(3,10,9,'Paracetamol','200mg','none','2025-07-02 15:34:40');
/*!40000 ALTER TABLE `prescriptions` ENABLE KEYS */;
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
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('doctor','patient') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'John Doe','johndoe@gmail.com','$2y$10$zbT16QSaU87Xd/RlvqmDlORFXf.aZCuYfsramBM5HxCdHixFz4BCO','doctor'),(2,'Alice Smith','alice@gmail.com','$2y$10$NCcOAEr6miSUdRf56pOmPOaB8rX1CogSD5owNKiEM.fSD22VDTOIK','patient'),(3,'Bob Johnson','bob.johnson@email.com','$2y$10$doe4rJ4X9HX9dbctZY32quNKMxi1ysh.pyw9rvI7PgZ0WuORjdVOe','doctor'),(4,'Sarah Lee','sarah.lee@gmail.com','$2y$10$9NnK33uczvjQEQuGBHVH0uYxKuCV21m3uRGD4hddlkayXXS7YPjXC','patient'),(5,'Michael Brown','mike.brown@example.com','$2y$10$G.8J5a2UKOoixR8c8PcA4OWzaKIYixpdApmv4EQRHB7j5HnBbsqBm','doctor'),(6,'Emma Wilson','emma.wilson@email.com','$2y$10$1HkedNcwtH1imZU2Xvz0pu4pyMyur/8ToXRnexghL68enYZWnUHDy','patient'),(7,'Daniel Clark','daniel.clark@mail.com','$2y$10$2mlURZ5vwqFd.lpxaZ9ye.NYBD7y3gTgI9iGjuOObvNFV0yewbzue','doctor'),(8,'Olivia Martin','olivia.martin@email.com','$2y$10$qab.97HrA0hWL3/lXFMaZeoEvvD9cCHGVWaozHJmo29zdREPXZ.Oq','patient'),(9,'lee','lee@gmail.com','$2y$10$6EGhejAGyPYUWZ9RUZce7e8tc9QAlenCw02uJVJ4j/kE8DmkdPVM6','patient'),(10,'Tom','tom@gmail.com','$2y$10$topiR4aglwCRqTtErIsj4OK/w2AEtMq6iPyE3ZOqjATanc0vLdUUK','doctor'),(11,'Smith','smith@gmail.com','$2y$10$4O9rRUod9HrUCKDGeajnvuwnMixSX5a.KRR2UC1hWS1AE72ztzNhO','patient'),(12,'Dass','dass@gmail.com','$2y$10$MK8.V.VUQql1YyZNIL5ovu6WsIoPHqgHaHjg5DDw/3hccXZo6kzB2','patient');
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

-- Dump completed on 2025-07-26 23:57:22
