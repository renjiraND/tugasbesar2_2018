-- MySQL dump 10.13  Distrib 5.7.21, for Win64 (x86_64)
--
-- Host: localhost    Database: probook
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.37-MariaDB

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
-- Table structure for table `book`
--

DROP TABLE IF EXISTS `book`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book` (
  `idbook` int(11) NOT NULL,
  `bookname` varchar(100) NOT NULL,
  `author` varchar(45) NOT NULL,
  `description` varchar(300) NOT NULL,
  `image` varchar(45) NOT NULL DEFAULT '../res/book_cover.png',
  PRIMARY KEY (`idbook`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book`
--

LOCK TABLES `book` WRITE;
/*!40000 ALTER TABLE `book` DISABLE KEYS */;
INSERT INTO `book` VALUES (1,'Information Architecture for the World Wide Web','Mark Manson','Information Architecture is related into world wide web with operating system that will recognize OSI Layer in data transaction with credit card but no visa detected. you do this! and read this book without your parent because this book is can readed under 13 years old.','../res/book_cover/book_1.jpg'),(2,'Windows Powershell for Developers','Thareq M Y H','PowerShell is a task-based command line and scripting language built on .NET. Powershell helps system administrators and power-users rapidly automate task that manage OS. So this book will teach you how use powershell effectively!','../res/book_cover/book_2.jpg'),(3,'Useless Git Commit Messages','J.K Bowling','Many people can\'t use git commit, so this book is ...... useless too.','../res/book_cover/book_3.jpg'),(4,'Writing code that Nobody Else Can Read','Lebron James','In this world, every programmer love to writing code but his friend can\'t read that code. it so sucks bro! please if you read this you will make a clean code :(','../res/book_cover/book_4.jpg'),(5,'Hoping for the Right Interview Question','John English','While we don\'t recommend having a canned response for every interview question (in fact, please don\'t), we do recommend spending some time getting comfortable with what you might be asked, what hiring managers are really looking for in your responses, and what it takes to show that you\'re the right ','../res/book_cover/book_5.jpg'),(6,'Hoping This Works','George Hill','Hoping this work :( please, i don\'t know how this is work :(, that is sentence that always programmer said when code and always get an error. So you must read this book! So you can feel what programmer feel when he do code.','../res/book_cover/book_6.jpg');
/*!40000 ALTER TABLE `book` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order` (
  `idorder` int(11) NOT NULL AUTO_INCREMENT,
  `buyer` varchar(16) NOT NULL,
  `book` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `review` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`idorder`),
  KEY `fk_order_buyer_idx` (`buyer`),
  KEY `fk_order_book_idx` (`book`),
  CONSTRAINT `fk_order_book` FOREIGN KEY (`book`) REFERENCES `book` (`idbook`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_order_buyer` FOREIGN KEY (`buyer`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` VALUES (10,'BobMcSaggy',1,4,'2018-11-26',4,'goks\r\n');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token` (
  `access_token` varchar(10) NOT NULL,
  `granted` varchar(16) NOT NULL,
  `expiry_time` datetime NOT NULL,
  `browser` varchar(120) NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`access_token`),
  KEY `fk_granted_username_idx` (`granted`),
  CONSTRAINT `fk_granted_username` FOREIGN KEY (`granted`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token`
--

LOCK TABLES `token` WRITE;
/*!40000 ALTER TABLE `token` DISABLE KEYS */;
/*!40000 ALTER TABLE `token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `username` varchar(16) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `picture` varchar(45) DEFAULT NULL,
  `card_number` varchar(16) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('BobMcSaggy','Bobbi Macan Sugeng','BobMcSaggy@gmail.com','kalpanak','AddressMcStreet No. 10, CityMcTown','082208220822','../res/profile_picture/BobMcSaggy.jpg','123412341234');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-28  7:20:17
