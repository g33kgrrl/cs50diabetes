-- MySQL dump 10.14  Distrib 5.5.32-MariaDB, for Linux (i686)
--
-- Host: localhost    Database: project
-- ------------------------------------------------------
-- Server version	5.5.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bglog`
--

DROP TABLE IF EXISTS `bglog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bglog` (
  `index` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(10) unsigned NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mealtime` enum('F','BB','AB','BL','AL','BD','AD','R') COLLATE utf8_unicode_ci NOT NULL,
  `reading` int(3) unsigned NOT NULL,
  PRIMARY KEY (`index`),
  UNIQUE KEY `index` (`index`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bglog`
--

LOCK TABLES `bglog` WRITE;
/*!40000 ALTER TABLE `bglog` DISABLE KEYS */;
INSERT INTO `bglog` VALUES (25,6,'2014-12-17 05:10:14','BB',102),(26,6,'2014-12-17 06:33:13','AB',130),(27,6,'2014-12-17 06:38:53','BL',88),(28,6,'2014-12-17 06:39:22','AL',120),(29,6,'2014-12-17 06:41:19','BD',101),(30,6,'2014-12-17 06:41:31','AD',138),(31,6,'2014-12-17 07:30:09','F',93),(32,6,'2014-12-17 07:33:03','R',112),(33,6,'2014-12-19 07:18:50','F',88),(34,6,'2014-12-19 08:17:49','BL',101),(35,6,'2014-12-19 08:18:04','AL',128),(36,6,'2014-12-20 06:54:45','F',83),(37,6,'2014-12-20 06:55:56','BD',92),(38,6,'2014-12-20 06:57:34','AD',128),(39,6,'2014-12-20 07:45:18','AB',103),(40,6,'2014-12-20 07:46:21','F',99),(41,6,'2014-12-20 08:53:32','R',99),(42,6,'2014-12-20 19:18:40','F',101);
/*!40000 ALTER TABLE `bglog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `tindex` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id` int(10) unsigned NOT NULL,
  `action` enum('BUY','SELL') COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `shares` int(10) NOT NULL,
  `price` decimal(25,4) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`tindex`),
  UNIQUE KEY `tindex` (`tindex`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (1,1,'BUY','MSFT',244,40.9400,'2014-06-01 15:21:24'),(2,1,'BUY','0030.HK',81,0.1310,'2014-06-01 15:21:41'),(3,2,'BUY','IBM',54,184.3600,'2014-06-01 15:22:23'),(4,2,'BUY','VIVO',2,20.4100,'2014-06-01 15:22:50'),(5,3,'BUY','TWC',60,141.1600,'2014-06-01 14:32:18'),(6,3,'BUY','F',93,16.4400,'2014-06-01 14:32:32'),(7,4,'BUY','GOOG',17,559.8900,'2014-06-01 13:12:26'),(8,4,'BUY','BA',3,135.2500,'2014-06-01 13:12:40'),(9,4,'BUY','ARCP',6,12.4100,'2014-06-01 13:12:10'),(10,5,'BUY','JD',400,25.0000,'2014-06-01 15:29:45'),(11,6,'BUY','GM',289,34.5800,'2014-06-01 15:36:05'),(12,6,'BUY','ASTC',2,2.9200,'2014-06-01 15:37:00'),(13,7,'BUY','AAPL',15,633.0000,'2014-06-01 15:42:40'),(14,7,'BUY','BAC',33,15.1400,'2014-06-01 15:43:19'),(15,3,'SELL','TWC',40,149.2900,'2014-12-03 10:35:32'),(16,3,'BUY','MSFT',10,48.4600,'2014-12-03 10:44:20'),(17,6,'SELL','GM',289,33.2600,'2014-12-03 11:53:25'),(18,6,'BUY','MSFT',195,48.4600,'2014-12-03 11:54:11'),(19,6,'BUY','MSFT',3,48.4600,'2014-12-03 11:54:28'),(20,6,'SELL','ASTC',2,2.5800,'2014-12-03 11:54:54'),(21,6,'SELL','MSFT',98,48.4600,'2014-12-03 11:55:19'),(22,6,'BUY','BA',34,132.2800,'2014-12-03 11:56:41'),(23,6,'BUY','BA',2,132.2800,'2014-12-03 11:56:57'),(24,6,'BUY','DVN.V',50,0.1850,'2014-12-04 08:48:53'),(25,6,'BUY','DVN.V',2,0.1850,'2014-12-04 08:49:14'),(26,6,'SELL','MSFT',20,46.9500,'2014-12-13 22:44:22'),(27,6,'BUY','ABC',10,90.9800,'2014-12-14 01:18:08');
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolio`
--

DROP TABLE IF EXISTS `portfolio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portfolio` (
  `id` int(10) unsigned NOT NULL,
  `symbol` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `shares` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`,`symbol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolio`
--

LOCK TABLES `portfolio` WRITE;
/*!40000 ALTER TABLE `portfolio` DISABLE KEYS */;
INSERT INTO `portfolio` VALUES (1,'0030.HK',81),(1,'MSFT',244),(2,'IBM',54),(2,'VIVO',2),(3,'F',93),(3,'MSFT',10),(3,'TWC',20),(4,'ARCP',6),(4,'BA',3),(4,'GOOG',17),(5,'JD',400),(6,'ABC',10),(6,'BA',36),(6,'DVN.V',52),(6,'MSFT',80),(7,'AAPL',15),(7,'BAC',33);
/*!40000 ALTER TABLE `portfolio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `hash` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `cash` decimal(65,4) unsigned NOT NULL DEFAULT '0.0000',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'caesar','$1$50$GHABNWBNE/o4VL7QjmQ6x0',0.0290),(2,'hirschhorn','$1$50$lJS9HiGK6sphej8c4bnbX.',3.7400),(3,'jharvard','$1$50$RX3wnAMNrGIbgzbRYrxM1/',5488.4800),(4,'malan','$1$HA$azTGIMVlmPi9W9Y12cYSj/',1.6600),(5,'milo','$1$HA$6DHumQaK4GhpX8QE23C8V1',0.0000),(6,'skroob','$1$sIQQjZIs$nZqp1plarOYZD2Oz/uSV.1',29.3400),(7,'zamyla','$1$50$uwfqB45ANW.9.6qaQ.DcF.',5.3800);
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

-- Dump completed on 2014-12-20 12:17:52
