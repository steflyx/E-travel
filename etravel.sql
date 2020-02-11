-- Progettazione Web 
DROP DATABASE if exists etravel; 
CREATE DATABASE etravel; 
USE etravel; 
-- MySQL dump 10.13  Distrib 5.6.20, for Win32 (x86)
--
-- Host: localhost    Database: etravel
-- ------------------------------------------------------
-- Server version	5.6.20

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
-- Table structure for table `chasing`
--

DROP TABLE IF EXISTS `chasing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chasing` (
  `userChaser` int(11) NOT NULL,
  `userChased` int(11) NOT NULL,
  PRIMARY KEY (`userChaser`,`userChased`),
  KEY `chaser` (`userChaser`),
  KEY `chased` (`userChased`),
  CONSTRAINT `chased` FOREIGN KEY (`userChased`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `chaser` FOREIGN KEY (`userChaser`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chasing`
--

LOCK TABLES `chasing` WRITE;
/*!40000 ALTER TABLE `chasing` DISABLE KEYS */;
INSERT INTO `chasing` VALUES (6,7),(7,6),(9,6);
/*!40000 ALTER TABLE `chasing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evento`
--

DROP TABLE IF EXISTS `evento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evento` (
  `idevento` int(11) NOT NULL AUTO_INCREMENT,
  `autore` int(11) DEFAULT NULL,
  `titolo` varchar(45) DEFAULT NULL,
  `descrizione` text,
  `luogo` int(11) DEFAULT NULL,
  `inizio` date DEFAULT NULL,
  `fine` date DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `fotoEvento` varchar(100) DEFAULT 'default',
  PRIMARY KEY (`idevento`),
  KEY `userAuthorEvent` (`autore`),
  KEY `luogoEvento` (`luogo`),
  KEY `luogoEvento1` (`luogo`),
  CONSTRAINT `luogoEvento1` FOREIGN KEY (`luogo`) REFERENCES `luogo` (`idluogo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `userAuthorEvent` FOREIGN KEY (`autore`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evento`
--

LOCK TABLES `evento` WRITE;
/*!40000 ALTER TABLE `evento` DISABLE KEYS */;
INSERT INTO `evento` VALUES (1,6,'Lorem ipsum',' Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',6,'2017-02-19','2017-02-21','2017-01-23 23:04:48','submit.png'),(2,6,'prova','sasss',NULL,NULL,NULL,'2017-01-23 23:45:57','default'),(3,6,'prova2','aaaa',NULL,NULL,NULL,'2017-01-23 23:48:26','default'),(4,6,'prova3','aaaaaa',NULL,'2017-01-25',NULL,'2017-01-23 23:49:51','default'),(5,6,'Prova','Ciao',1,'2017-01-19','2017-02-20','2017-01-27 19:23:48','settingsIcon.png'),(6,6,'Prova2','aaaaa',NULL,NULL,NULL,'2017-01-27 19:25:06','orologioSfondo.png'),(7,6,'Prova222','ssssssssss',NULL,NULL,NULL,'2017-01-27 19:31:53','default'),(8,6,'Provavava','aaaaaa',NULL,NULL,NULL,'2017-01-28 21:44:58','default'),(9,6,'Provvvvvvv','aaaa',NULL,NULL,NULL,'2017-01-28 22:24:59','default'),(10,6,'Proorororor','ssssss',NULL,NULL,NULL,'2017-01-28 23:24:56','messageIcon.jpg'),(11,7,'aaaaaa','aaaa',NULL,NULL,NULL,'2017-01-28 23:42:09','default'),(12,6,'Lorem ipsum',' Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ',8,'2017-02-03','2017-02-06','2017-01-29 12:10:37','sfondo3.jpg');
/*!40000 ALTER TABLE `evento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `foto`
--

DROP TABLE IF EXISTS `foto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `foto` (
  `user` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user`,`url`),
  KEY `userFoto` (`user`),
  CONSTRAINT `userFoto` FOREIGN KEY (`user`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `foto`
--

LOCK TABLES `foto` WRITE;
/*!40000 ALTER TABLE `foto` DISABLE KEYS */;
INSERT INTO `foto` VALUES (6,'fbIcon.png','2017-01-23 22:59:40'),(6,'instIcon.jpg','2017-01-23 23:00:37'),(6,'linguaIcon.png','2017-01-29 11:47:48'),(6,'sfondo1.jpg','2017-01-29 12:33:33'),(6,'submit.png','2017-01-23 23:01:25'),(7,'goIcon.png','2017-01-28 23:54:18'),(7,'hotIcon.ico','2017-01-28 23:52:19');
/*!40000 ALTER TABLE `foto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `luogo`
--

DROP TABLE IF EXISTS `luogo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `luogo` (
  `idluogo` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idluogo`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `luogo`
--

LOCK TABLES `luogo` WRITE;
/*!40000 ALTER TABLE `luogo` DISABLE KEYS */;
INSERT INTO `luogo` VALUES (1,'Roma'),(2,'Torino'),(3,'Hong Kong'),(4,'Pisa'),(5,'Venezia'),(6,'Milano'),(7,'Firenze'),(8,'Genova'),(9,'Aosta'),(10,'Malta'),(11,'Bologna'),(12,'Campobasso'),(13,'Cagliari'),(14,'dddd'),(15,'Palermo'),(16,'Potenza'),(17,'Ancona'),(18,'Catanzaro'),(19,'Perugia'),(20,'New York'),(21,'Sydney'),(22,'Los Angeles'),(23,'Trento'),(24,'Napoli'),(25,'Pechino');
/*!40000 ALTER TABLE `luogo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messaggio`
--

DROP TABLE IF EXISTS `messaggio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messaggio` (
  `destinatario` int(11) NOT NULL,
  `mittente` int(11) NOT NULL,
  `testo` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `visualizzato` tinyint(4) DEFAULT '0',
  `idMessaggio` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idMessaggio`),
  KEY `userDestinatario` (`destinatario`),
  KEY `userMittente` (`mittente`),
  CONSTRAINT `userDestinatario` FOREIGN KEY (`destinatario`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `userMittente` FOREIGN KEY (`mittente`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messaggio`
--

LOCK TABLES `messaggio` WRITE;
/*!40000 ALTER TABLE `messaggio` DISABLE KEYS */;
INSERT INTO `messaggio` VALUES (7,6,'aaaaa','2017-01-25 11:15:08',1,1),(7,6,'ciao','2017-01-25 11:16:26',1,2),(7,6,'ciao2','2017-01-25 11:17:08',1,3),(6,7,'bbbbb','2017-01-25 11:18:12',1,4),(7,6,'ffff','2017-01-25 11:18:27',1,5),(7,6,'aaaaaa','2017-01-25 11:21:11',1,6),(6,7,'hhhhh','2017-01-25 11:21:25',1,7),(7,6,'aaaa','2017-01-25 11:27:18',1,8),(7,6,'aaaaa','2017-01-25 11:29:16',1,9),(7,6,'ddddd','2017-01-25 11:29:35',1,10),(7,6,'eeeeee','2017-01-25 11:29:38',1,11),(7,6,'ssssssss','2017-01-25 11:29:42',1,12),(6,7,'jjjjj','2017-01-25 11:29:53',1,13),(6,7,'ciao','2017-01-25 11:33:59',1,14),(7,6,'ciao anche a te','2017-01-25 11:34:15',1,15),(7,6,'aaaa','2017-01-27 10:40:03',0,16),(6,7,'bbbbb','2017-01-27 10:42:11',1,17),(7,6,'aaaaaa','2017-01-27 11:10:02',0,18),(6,7,'gggg','2017-01-27 11:24:14',1,19),(6,7,'hhhhh','2017-01-27 11:28:46',1,20),(7,6,'aaaa','2017-01-27 11:30:52',0,22),(7,6,'jjjjjju','2017-01-27 11:31:23',0,23),(6,7,'mmmmmm','2017-01-27 11:32:20',1,24),(6,7,'yyyyy','2017-01-27 12:15:03',1,25),(6,7,'uuuu','2017-01-27 12:15:03',1,26),(6,8,'llllll','2017-01-27 12:15:03',1,27),(8,6,'Ciao','2017-01-27 19:25:34',0,28),(6,7,'aaaa','2017-01-28 12:41:47',1,29),(7,6,'fwefweerfw','2017-01-28 22:46:34',0,30),(6,7,'dqdqwwdq','2017-01-28 22:46:49',1,31),(6,7,'ssadsaaas','2017-01-28 22:49:27',1,32),(7,6,'dddqdq','2017-01-28 22:49:37',0,33),(6,7,'ytyyyy','2017-01-29 11:49:16',1,34),(7,6,'aaadasda','2017-01-29 11:56:50',0,35);
/*!40000 ALTER TABLE `messaggio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orologio`
--

DROP TABLE IF EXISTS `orologio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orologio` (
  `idorologio` int(11) NOT NULL AUTO_INCREMENT,
  `autore` int(11) DEFAULT NULL,
  `luogo` int(11) DEFAULT NULL,
  `fusorario` int(11) DEFAULT NULL,
  PRIMARY KEY (`idorologio`),
  KEY `userOrologio` (`autore`),
  KEY `luogoOrologio` (`luogo`),
  CONSTRAINT `luogoOrologio` FOREIGN KEY (`luogo`) REFERENCES `luogo` (`idluogo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `userOrologio` FOREIGN KEY (`autore`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orologio`
--

LOCK TABLES `orologio` WRITE;
/*!40000 ALTER TABLE `orologio` DISABLE KEYS */;
INSERT INTO `orologio` VALUES (1,6,1,1),(2,6,3,8),(3,6,20,-8),(4,6,21,10),(5,6,22,-10),(6,7,1,1),(7,6,25,10);
/*!40000 ALTER TABLE `orologio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `partecipazione`
--

DROP TABLE IF EXISTS `partecipazione`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partecipazione` (
  `evento` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`evento`,`user`),
  KEY `eventoPartecipazione` (`evento`),
  KEY `userPartecipazione` (`user`),
  CONSTRAINT `eventoPartecipazione` FOREIGN KEY (`evento`) REFERENCES `evento` (`idevento`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `userPartecipazione` FOREIGN KEY (`user`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `partecipazione`
--

LOCK TABLES `partecipazione` WRITE;
/*!40000 ALTER TABLE `partecipazione` DISABLE KEYS */;
INSERT INTO `partecipazione` VALUES (1,6),(2,6),(3,6),(4,6),(5,6),(7,6),(8,6),(9,6),(9,7),(10,6),(10,7),(11,7),(12,6);
/*!40000 ALTER TABLE `partecipazione` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `idpost` int(11) NOT NULL AUTO_INCREMENT,
  `autore` int(11) DEFAULT NULL,
  `testo` text,
  `luogo` int(11) DEFAULT NULL,
  `tag` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpost`),
  KEY `userAuthor` (`autore`),
  KEY `userTagged` (`tag`),
  KEY `luogoPost` (`luogo`),
  KEY `luogoPost1` (`luogo`),
  CONSTRAINT `luogoPost1` FOREIGN KEY (`luogo`) REFERENCES `luogo` (`idluogo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `userAuthor` FOREIGN KEY (`autore`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `userTagged` FOREIGN KEY (`tag`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
INSERT INTO `post` VALUES (1,6,'ciao',NULL,NULL,'2017-01-19 22:00:29'),(2,6,'Ciao',4,NULL,'2017-01-23 23:03:37'),(3,6,'Ciaone',5,7,'2017-01-23 23:03:55'),(4,7,'ok',NULL,NULL,'2017-01-24 12:25:26'),(5,6,'aaaaa',NULL,NULL,'2017-01-24 21:59:14'),(6,6,'ccccccc',NULL,NULL,'2017-01-25 21:59:04'),(7,6,'ciaoProva',NULL,NULL,'2017-01-27 18:57:08'),(8,6,'ciaoProvaLuog',1,7,'2017-01-27 18:57:34'),(9,6,'CiaoProvaProva',NULL,NULL,'2017-01-27 19:06:22'),(10,6,'Ciao',NULL,NULL,'2017-01-28 10:59:44'),(11,6,'Ciao',NULL,NULL,'2017-01-28 19:42:03'),(12,6,'Prova',NULL,NULL,'2017-01-28 21:36:44'),(13,6,'aaaaa',NULL,NULL,'2017-01-28 21:45:32'),(14,7,'aaaa',NULL,NULL,'2017-01-28 23:30:42'),(15,6,' Lorem ipsum dolor sit amet, consectetur adipisci elit, sed eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur. Quis aute iure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ',1,7,'2017-01-29 12:01:33');
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `preferiti`
--

DROP TABLE IF EXISTS `preferiti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `preferiti` (
  `userPreferring` int(11) NOT NULL,
  `userPreferito` int(11) NOT NULL,
  PRIMARY KEY (`userPreferring`,`userPreferito`),
  KEY `userPrefer` (`userPreferring`),
  KEY `userPreferred` (`userPreferito`),
  CONSTRAINT `userPrefer` FOREIGN KEY (`userPreferring`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `userPreferred` FOREIGN KEY (`userPreferito`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `preferiti`
--

LOCK TABLES `preferiti` WRITE;
/*!40000 ALTER TABLE `preferiti` DISABLE KEYS */;
INSERT INTO `preferiti` VALUES (6,7),(6,8);
/*!40000 ALTER TABLE `preferiti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tappa`
--

DROP TABLE IF EXISTS `tappa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tappa` (
  `idtappa` int(11) NOT NULL AUTO_INCREMENT,
  `viaggio` int(11) DEFAULT NULL,
  `luogo` int(11) DEFAULT NULL,
  `commento` text,
  `mezzo` int(11) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `positionX` int(11) DEFAULT NULL,
  `positionY` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idtappa`),
  KEY `tappaViaggio` (`viaggio`),
  KEY `luogoTappa` (`luogo`),
  KEY `tappaViaggio1` (`viaggio`),
  KEY `luogoTappa1` (`luogo`),
  CONSTRAINT `luogoTappa1` FOREIGN KEY (`luogo`) REFERENCES `luogo` (`idluogo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `tappaViaggio1` FOREIGN KEY (`viaggio`) REFERENCES `viaggio` (`idviaggio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tappa`
--

LOCK TABLES `tappa` WRITE;
/*!40000 ALTER TABLE `tappa` DISABLE KEYS */;
INSERT INTO `tappa` VALUES (19,13,9,NULL,NULL,NULL,0,0,'2017-01-24 11:42:48'),(20,13,1,NULL,NULL,NULL,147,177,'2017-01-24 11:42:48'),(21,13,10,NULL,NULL,NULL,301,367,'2017-01-24 11:42:48'),(22,14,6,NULL,NULL,NULL,68,62,'2017-01-24 11:59:09'),(23,15,11,'Bellissimo posto!',0,'2017-01-29',113,94,'2017-01-27 18:58:37'),(24,15,12,NULL,NULL,'2017-02-03',201,185,'2017-01-27 18:58:37'),(25,16,13,NULL,3,'2017-01-07',66,250,'2017-01-27 19:00:13'),(26,17,13,NULL,1,'2017-01-28',70,258,'2017-01-27 19:07:22'),(27,17,12,NULL,NULL,'2017-02-05',202,182,'2017-01-27 19:07:22'),(28,18,5,NULL,5,'2017-03-03',147,62,'2017-01-27 19:13:21'),(29,20,6,NULL,4,'2017-01-30',70,60,'2017-01-27 19:26:19'),(30,21,7,NULL,NULL,'2017-01-18',114,119,'2017-01-27 19:28:12'),(31,22,8,NULL,NULL,'2017-02-09',58,104,'2017-01-27 19:29:15'),(32,23,15,NULL,NULL,'2017-01-08',170,290,'2017-01-27 19:31:38'),(33,24,16,NULL,NULL,'2017-03-08',227,217,'2017-01-27 19:34:45'),(36,26,6,'CIao',5,'2017-02-05',74,59,'2017-01-28 12:58:50'),(37,26,19,'Ciaooo',4,'2017-02-07',148,136,'2017-01-28 12:58:50'),(38,27,17,NULL,NULL,'2017-02-03',167,124,'2017-01-28 21:44:46'),(39,28,9,'Che freddo!',5,'2017-02-08',28,51,'2017-01-28 23:32:08'),(40,28,15,'Che caldo!',1,'2017-02-15',171,300,'2017-01-28 23:32:08'),(41,29,23,NULL,NULL,NULL,117,38,'2017-01-28 23:54:37'),(42,30,24,NULL,NULL,NULL,187,214,'2017-01-28 23:55:10'),(43,31,6,'Non vedo l\'ora!',0,'2017-01-31',71,60,'2017-01-29 12:03:53'),(44,31,7,NULL,1,'2017-02-04',121,118,'2017-01-29 12:03:53'),(45,31,1,NULL,5,'2017-02-07',149,182,'2017-01-29 12:03:53'),(46,31,16,NULL,3,'2017-02-14',228,216,'2017-01-29 12:03:53'),(47,31,15,NULL,1,'2017-02-20',174,291,'2017-01-29 12:03:53');
/*!40000 ALTER TABLE `tappa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `dataNascita` date DEFAULT NULL,
  `luogoOrigine` int(11) DEFAULT NULL,
  `luogoPreferito` int(11) DEFAULT NULL,
  `preferenzaCompagnia` int(11) DEFAULT '-1',
  `preferenzaClima` int(11) DEFAULT '-1',
  `preferenzaMezzo` int(11) DEFAULT '-1',
  `preferenzaViaggio` int(11) DEFAULT '-1',
  `fotoProfilo` varchar(100) DEFAULT 'default',
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `username_UNIQUE` (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `userLuogoOrigine` (`luogoOrigine`),
  KEY `luogoOrigine1` (`luogoOrigine`),
  KEY `luogoPreferito` (`luogoPreferito`),
  CONSTRAINT `luogoOrigine1` FOREIGN KEY (`luogoOrigine`) REFERENCES `luogo` (`idluogo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `luogoPreferito` FOREIGN KEY (`luogoPreferito`) REFERENCES `luogo` (`idluogo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (6,'Stef19','stefano.agresti19@gmail.com','1Pwebpweb','Steflix','1996-12-19',1,4,1,1,1,1,'sfondo0.jpg'),(7,'Pweb','pweb@gmail.com','1Pwebpweb','Pweb','1992-09-21',NULL,NULL,-1,-1,-1,-1,'fbIcon.png'),(8,'Stef199','stefano.agresti199@gmail.com','1Pwebpweb','Stef',NULL,1,NULL,-1,-1,-1,-1,'default'),(9,'Prova','adssjadjs.asjdasads@sdad.co','1Pwebpweb','PPPPPP',NULL,NULL,NULL,-1,-1,-1,-1,'default');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `viaggio`
--

DROP TABLE IF EXISTS `viaggio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `viaggio` (
  `idviaggio` int(11) NOT NULL AUTO_INCREMENT,
  `autore` int(11) DEFAULT NULL,
  `compagnia` tinyint(4) DEFAULT NULL,
  `tag` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idviaggio`),
  KEY `userAuthorViaggio` (`autore`),
  KEY `userTaggedViaggio` (`tag`),
  CONSTRAINT `userAuthorViaggio` FOREIGN KEY (`autore`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `userTaggedViaggio` FOREIGN KEY (`tag`) REFERENCES `user` (`idUser`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `viaggio`
--

LOCK TABLES `viaggio` WRITE;
/*!40000 ALTER TABLE `viaggio` DISABLE KEYS */;
INSERT INTO `viaggio` VALUES (13,6,0,NULL,'2017-01-24 11:42:48'),(14,6,1,NULL,'2017-01-24 11:59:09'),(15,6,0,NULL,'2017-01-27 18:58:37'),(16,6,0,NULL,'2017-01-27 19:00:13'),(17,6,0,NULL,'2017-01-27 19:07:22'),(18,6,0,NULL,'2017-01-27 19:13:21'),(20,6,0,NULL,'2017-01-27 19:26:19'),(21,6,0,NULL,'2017-01-27 19:28:12'),(22,6,0,NULL,'2017-01-27 19:29:15'),(23,6,0,NULL,'2017-01-27 19:31:38'),(24,6,0,NULL,'2017-01-27 19:34:45'),(26,6,0,NULL,'2017-01-28 12:58:50'),(27,6,0,NULL,'2017-01-28 21:44:46'),(28,7,0,NULL,'2017-01-28 23:32:08'),(29,7,0,NULL,'2017-01-28 23:54:37'),(30,7,1,NULL,'2017-01-28 23:55:10'),(31,6,1,7,'2017-01-29 12:03:53');
/*!40000 ALTER TABLE `viaggio` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-29 13:40:56
