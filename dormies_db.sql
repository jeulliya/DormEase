-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: dormies_db
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `activity_history`
--

DROP TABLE IF EXISTS `activity_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_history` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `activity_type` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`activity_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_history`
--

LOCK TABLES `activity_history` WRITE;
/*!40000 ALTER TABLE `activity_history` DISABLE KEYS */;
INSERT INTO `activity_history` VALUES (1,'jeulliya','Recover Database','2024-01-31 12:42:40'),(2,'jeulliya','Recover Database','2024-01-31 12:57:05'),(3,'jeulliya','Export Database','2024-01-31 13:24:26'),(4,'zeyyy','Export Database','2024-02-01 11:35:24'),(5,'jeulliya','Export Database','2024-03-01 00:02:17'),(6,'jeulliya','Export Database','2024-03-01 00:02:21'),(7,'jeulliya','Export Database','2024-02-08 03:44:41'),(8,'jeulliya','Export Database','2024-02-08 03:44:50');
/*!40000 ALTER TABLE `activity_history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dormitories`
--

DROP TABLE IF EXISTS `dormitories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dormitories` (
  `dorm_id` int(11) NOT NULL AUTO_INCREMENT,
  `images` varchar(255) DEFAULT NULL,
  `lat` decimal(18,15) DEFAULT NULL,
  `lng` decimal(18,15) DEFAULT NULL,
  `dorm_name` varchar(255) NOT NULL,
  `dorm_owner` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `rooms` int(11) DEFAULT NULL,
  `r_fee` int(11) DEFAULT NULL,
  `amenities` varchar(255) DEFAULT NULL,
  `r_avail` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `b_permit` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`dorm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dormitories`
--

LOCK TABLES `dormitories` WRITE;
/*!40000 ALTER TABLE `dormitories` DISABLE KEYS */;
INSERT INTO `dormitories` VALUES (1,'upland-dorm.jpg',14.195200424418594,120.880823731321390,'Upland Dormitory','MARIANITO MOJICA, ANUAT','United Home Subdivision (Upland)  Brgy. Kaytapos, Indang, Cavite',0,5000,'','Available','','Yes'),(2,'lolafely-dorm.jpg, l-pic1.jpg, l-pic2.jpg, l-pic3.jpg, l-pic4.jpg, l-pic5.jpg, l-pic6.jpg, l-pic7.jpg, l-pic8.jpg, l-pic9.jpg, l-pic10.jpg',14.194853283276547,120.881345611722450,'Lola Fely Dormitory','Shakespeare  Bracamonte, Asegurado','St. Agatha Village,  Brgy. Kaytapos, Indang, Cavite',30,1500,'wifi, lounge, kitchen, laundromat, study area, canteen, water, electricity, rooftop','Available','Room for 6 pax - 1500/head/month\r\nRoom for 4pax - 1800/head/month\r\nRoom for 2pax - 2200/head/month\r\nStudent/teachers can choose different types of rooms from 2 persons, 4 persons and  6 persons in each room\r\nCan accommodate up to 100+ student/employees\r\nPrice depends in pax per room, for as low as 1500 per month \r\nEach room has its own CR\r\nEach bed has its own outlet for charging of cp/laptop\r\nEach room has its own cabinet for belongings\r\nEach room has its ceiling fan (2 fans) and foams\r\nFree wifi up to 100mbps \r\nFree use of kitchen (rice cooker)\r\nWith kitchen utensils\r\nWith activity area (4th floor)\r\nElectricity and water bill included \r\nCCTV\'s inside & outside the dormitory for security purposes.\r\n1 month advance and 1 month deposit \r\nNo pets allowed\r\nNo curfew \r\nWith convenience store inside Lola Felys Dorm\r\nWith water refilling station\r\n With laundry area (rooftop) \r\n Generator incase of brownout\r\nNo visitors allowed unless family ','Yes'),(4,' buhay-dorm.jpg',14.196109429085887,120.886472364418140,'Buhay - Dela Cruz Dormitory','Herelito Erni, Buhay',' Brgy. Kaytapos, Indang, Cavite',0,0,'','Not Available','','Yes'),(5,' melesan-dorm1.jpg, melesan-dorm2.jpg',14.201159836190941,120.879740724333320,'Melesan\'s Dormitory','Divinia Creus, Chavez','Purok 1  Brgy. Bancod, Indang, Cavite',13,1500,'0','Not Available','Wifi included and water\r\nOnly electric cooker','Yes'),(6,'77-haven-dorm.jpg, 7-pic1.jpg, 7-pic2.jpg, 7-pic3.jpg, 7-pic4.jpg, 7-pic5.jpg',14.194619198301888,120.881611820638270,'77 Haven Dormitory','Concepcion Tibayan, Farro',' Brgy. Kaytapos, Indang, Cavite',4,0,'','Not Available','Ladies only\r\nWalking distance\r\nAcross 7/11\r\nAccessible to town proper, church, market, transport terminal','Yes'),(7,' bangkomabuhay-dorm.jpg',14.194307283948767,120.881720708171870,'Bangko Mabuhay Dormitory','Edwin Solis, Fojas','Agatha Village,  Brgy. Kaytapos, Indang, Cavite',6,2000,'wifi, water, electricity','Not Available','2000/head/month (3 pax)\r\nFire exit','Yes'),(9,'upperdeck-dorm1.jpg,  upperdeck-dorm2.png, u-pic2.jpg, u-pic3.jpg, u-pic4.jpg, u-pic5.jpg, u-pic6.jpg, u-pic7.jpg, u-pic8.jpg, u-pic9.jpg, u-pic10.jpg, u-pic11.jpg, u-pic12.jpg, u-pic13.jpg, u-pic14.jpg, u-pic15.jpg, u-pic16.jpg, u-pic17.jpg, u-pic18.jpg',14.194171472656850,120.881837307713240,'Upperdeck 15.com Dormitory','Mary Grace Pera, Icasiano','9082  Brgy. Kaytapos, Indang, Cavite',18,1300,'wifi, lounge, kitchen, laundromat, water, electricity, rooftop','Not Available','1300/head/month\r\n100/month for water bill\r\n10 kilowatts free for electricity\r\nEvery rooms has submeter\r\nFire Extinguisher\r\nFire Alarm\r\nFire Exit\r\n3rd floor: Kitchen, Television, and Laundry Area.\r\nEvery rooms has its own C.R.\r\nEvery room is good for 4 pax\r\nNo visitors allowed inside the room\r\nVisitors are only allowed in the lounge on the first floor.','Yes'),(10,'lozada-dorm.jpg, pic1.jpg, pic2.jpg, pic3.jpg, pic4.jpg, pic5.jpg, pic6.jpg, pic7.jpg, pic8.jpg, pic9.jpg, pic10.jpg, pic11.jpg, pic12.jpg, pic13.jpg, pic14.jpg',14.195168425363374,120.878702375373790,'H.l. Lozada Dormitory','Homer Leandro Pelargon, Lozada','025 H. Ilagan St.  Brgy. Poblacion I, Indang, Cavite',8,2500,'wifi, kitchen, water, electricity','Not Available','2500/head/month (4 pax)\r\nFemales only.','Yes'),(11,' maisonette-dorm.jpg',14.194156047846143,120.881375305922730,'MD2 Maisonette Dormitory','Michelle llamado, Manalo','St. Agatha Villlage  Brgy. Kaytapos, Indang, Cavite',6,2500,'wifi, water, electricity','Not Available','2500/head/month (3 pax)\r\nOnly one 2 pax per room, the rest is 3 pax per room\r\nAdd on appliance','Yes'),(13,'amazinggrace-dorm.jpg, a-pic1.jpg, a-pic2.jpg, a-pic3.jpg, a-pic4.jpg, a-pic5.jpg, a-pic6.jpg, a-pic7.jpg',14.194775744991306,120.881678079349750,'Amazing Grace Dormitory','Yolanda Romeroso, Penales',' Brgy. Kaytapos, Indang, Cavite',0,2300,'wifi, water, electricity','Not Available','2300/head/month (8 pax)','Yes'),(14,'pulido-dorm2.jpg, pulido-dorm1.jpg, pulido-dorm3.jpg',14.194312201338180,120.881788936130960,'Pulido Dormitory','Shella Abestado, Pulido','Agatha Viilage,  Brgy. Kaytapos, Indang, Cavite',0,1700,'wifi, water, electricity','Not Available','1700/head/month (4 pax)','Yes'),(16,' eunice-dorm.jpg',14.194798497746310,120.881792073235270,'Eunice Dormitory Rental','Javier Signo, Salinas',' Brgy. Kaytapos, Indang, Cavite',0,1800,'wifi, kitchen, water, electricity','Not Available','1800/head/month(4pax)\r\n1600/head/month (6 pax)\r\n2000/head/month (8 pax)\r\nFemales only.\r\nOnly electrical appliances are allowed in the kitchen\r\n8 pax room include AC\r\nWith CCTV\r\nGallons of water in the 1st floor\r\nLockers','Yes'),(17,' reign-dorm.jpg',14.194360590510023,120.881680475038020,'Reign\'s Dormitory','Regina Arcely Pampuan, Villeta',' Brgy. Kaytapos, Indang, Cavite',8,1750,'wifi, water, electricity',NULL,'1750/head/month (4 pax)\r\n2500/head/month (2 pax)\r\nFemales only.','Yes');
/*!40000 ALTER TABLE `dormitories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hidden_dorms`
--

DROP TABLE IF EXISTS `hidden_dorms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hidden_dorms` (
  `dorm_id` int(11) NOT NULL,
  `images` varchar(255) DEFAULT NULL,
  `lat` decimal(18,15) DEFAULT NULL,
  `lng` decimal(18,15) DEFAULT NULL,
  `dorm_name` varchar(255) DEFAULT NULL,
  `dorm_owner` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `rooms` int(11) DEFAULT NULL,
  `r_fee` int(11) DEFAULT NULL,
  `amenities` varchar(255) DEFAULT NULL,
  `r_avail` varchar(255) DEFAULT NULL,
  `b_permit` varchar(3) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`dorm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hidden_dorms`
--

LOCK TABLES `hidden_dorms` WRITE;
/*!40000 ALTER TABLE `hidden_dorms` DISABLE KEYS */;
INSERT INTO `hidden_dorms` VALUES (3,' default_image.png',0.000000000000000,0.000000000000000,'Avilla\'s Dormitory Rental','Jane Carelle Cuento, Berona',' Brgy. Kaytapos, Indang, Cavite',0,0,'','Not Available','Yes',''),(8,' default_image.png',0.000000000000000,0.000000000000000,'A Beautiful House Dormitory','Liciel Rommely Gener, Herrera','Salazar Subd.  Brgy. Kaytapos, Indang, Cavite',0,0,'','Not Available','Yes',''),(12,' default_image.png',0.000000000000000,0.000000000000000,'RMPC Property Rental','Raymundo Herrera, Pegollo',' Brgy. Kaytapos, Indang, Cavite',0,0,'','Not Available','Yes',''),(15,' salazar.jpg',14.194170778122710,120.882647133844670,'Carlo Maurino R. Salazar Dormitory','Carlo Maurino Rojales, Salazar','140 E. Salazar Compound  Brgy. Kaytapos, Indang, Cavite',0,0,'','Not Available','Yes','');
/*!40000 ALTER TABLE `hidden_dorms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hidden_users`
--

DROP TABLE IF EXISTS `hidden_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hidden_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dormitory_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  `status` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hidden_users`
--

LOCK TABLES `hidden_users` WRITE;
/*!40000 ALTER TABLE `hidden_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `hidden_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dormitory_id` int(11) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `role` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,1,'Marianito','Mojica','Anuat','marianito','$2y$10$1VRZhDXTmM6KhqRMoB/g..QUQh/MW0zxn7apF7lA874XMihTUPWYG','','Male','Dormitory Owner'),(2,2,'Shakespeare  Bracamonte','','Asegurado','shakespeare','$2y$10$6dtofN79KYwhMEW7rb1Pd.GLVZvIv6lY3T6Tb3rZbz5jrsf.Vzh8e','','Male','Dormitory Owner'),(3,3,'Jane Carelle','Cuento','Berona','jane','$2y$10$tQYa3Aqu3Zqs53VP73FK1ejf00sEtAwCX7bnT3M1LIvqKfGcSZujK','','Female','Dormitory Owner'),(4,4,'Herelito','Erni','Buhay','herelito','$2y$10$gqg1KeJUE4DpeEmbRYAryeBn/RMsd63SryTNtXeD6igAiLhY1l.Vi','','Male','Dormitory Owner'),(5,5,'Divinia','Creus','Chavez','divinia','$2y$10$.wRI0a2r3hz6/hgHyk2BV.ca0trNoK/jSXJetQwv0uWWQuvqzIN.6','','Female','Dormitory Owner'),(6,6,'Concepcion','Tibayan','Farro','concepcion','$2y$10$Wh8yy0dw4KWtSoAZUpQKIu2wWClqB2fORQmjiWFwkTY7/cPjOuGQq','','Male','Dormitory Owner'),(7,7,'Edwin','Solis','Fojas','edwin','$2y$10$oYpg9uymGvffbfW6/b0eA./dJMnFE.bK0/ISzEBK4VCql.X5HxF0a','','Male','Dormitory Owner'),(8,8,'Liciel Rommely','Gener','Herrera','liciel','$2y$10$xn5aSUxhrbXFkUvQ2iKEY.ODn7yuxkTlom1COGEcBsaFettxxHSEK','','Male','Dormitory Owner'),(9,9,'Mary Grace','Pera','Icasiano','marygrace','$2y$10$mIScg0Nahk.F85sy.bujH.xg0yyXzD/8GSbUHiiBJ9rATuVmjB.ai','','Female','Dormitory Owner'),(10,10,'Homer Leandro','Pelargon','Lozada','homerleandro','$2y$10$xCZ7D0Hvjjx12RqKB1VwFeVcY1xGPmt2HoOCSpQhlUgSPXFqQ.ME.','','Male','Dormitory Owner'),(11,11,'Michelle','llamado','Manalo','michelle','$2y$10$Za3fkFAWV9atfVcRx2RgyuVQtYtoSleSsOKdS9AcjwAi5/hdp7u6G','','Female','Dormitory Owner'),(12,12,'Raymundo','Herrera','Pegollo','raymundo','$2y$10$XC6TSXuFfqW2bU5n0gSCYuzPXW1y1jpYLQQobSf/Gr0M0/ug3knXi','','Male','Dormitory Owner'),(13,13,'Yolanda','Romeroso','Penales','yolanda','$2y$10$537jbsZHAGOnWaRNmTQ9Zua2B7Pqu3A37AKqHmjvSFw0sIE67FnmS','','Female','Dormitory Owner'),(14,14,'Shella','Abestado','Pulido','shella','$2y$10$wsSKUtqnmNyw1q41vL9kNePKxyeAZsTSk9eF1jW0Xbdh7/QgwsF7G','','Female','Dormitory Owner'),(15,15,'Carlo Maurino','Rojales','Salazar','carlo','$2y$10$/bP566HEY1TX.Iz1R/zyXO2NkD9tDv2mmJKIwmjSciExCHCpAKiyS','','Male','Dormitory Owner'),(16,16,'Javier','Signo','Salinas','javier','$2y$10$DeqBJo06zUwKC0gfk3O1leAV4COSEQs02ZdGfvioe71hNc1nvI8Zq','','Male','Dormitory Owner'),(17,17,'Regina Arcely','Pampuan','Villeta','regina','$2y$10$ZhFlBKRhOmHLB87sb1GfO.vJFkEMmGBL2LKMbaKBR8iL/ZTLtZH8q','','Female','Dormitory Owner'),(18,0,'Julia Cristine','R.','Tadeo','jeulliya','$2y$10$NqsBu0eTEA2CMOlSErSa8ueR/Ej2WJVW5W2E3jCiSfaUPnA2Bssmi','juliacristine.tadeo31@gmail.com','Female','Admin'),(19,0,'Zandrine','S.','Cañete','zeyyy','$2y$10$Yu873jmihOqx9T1Y33geUOnJH7wxkgdBbAK9D409jVkOcLFNB.ueq','zandrine.cañete@cvsu.edu.ph','Female','Admin');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'dormies_db'
--

--
-- Dumping routines for database 'dormies_db'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-02-08 11:45:00
