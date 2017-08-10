-- MySQL dump 10.16  Distrib 10.1.25-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: auto_planet
-- ------------------------------------------------------
-- Server version	10.1.25-MariaDB-1~xenial

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
-- Table structure for table `bill`
--

DROP TABLE IF EXISTS `bill`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobsheet_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `bill_date` datetime NOT NULL,
  `billing_address` text CHARACTER SET latin1 NOT NULL,
  `billing_contact` varchar(100) CHARACTER SET latin1 NOT NULL,
  `payment_mode` varchar(100) CHARACTER SET latin1 NOT NULL,
  `reg_no` varchar(100) DEFAULT NULL,
  `chassis_no` varchar(200) DEFAULT NULL,
  `round_off` decimal(10,4) DEFAULT NULL,
  `grand_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill`
--

LOCK TABLES `bill` WRITE;
/*!40000 ALTER TABLE `bill` DISABLE KEYS */;
INSERT INTO `bill` VALUES (1,128,'Nisar','2017-08-08 00:00:00','','8547257874','1','KL-07-BS-8068','',0.0000,5725.00),(4,127,'muhsin','2017-08-10 00:00:00','','9847665036','1','KL-10-AE-6630','',0.0000,29452.00);
/*!40000 ALTER TABLE `bill` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_charges`
--

DROP TABLE IF EXISTS `bill_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `job_description` text NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_charges`
--

LOCK TABLES `bill_charges` WRITE;
/*!40000 ALTER TABLE `bill_charges` DISABLE KEYS */;
INSERT INTO `bill_charges` VALUES (1,2,'Mechanical - ',5000.00,450.00,5900.00),(2,2,'Dent Removal - ',2500.00,225.00,2950.00),(3,2,'Polishing - ',890.00,80.10,1050.20),(7,4,'Mechanical - ',5000.00,450.00,5900.00),(8,4,'Dent Removal - ',2500.00,225.00,2950.00),(9,4,'Polishing - ',890.00,80.10,1050.20);
/*!40000 ALTER TABLE `bill_charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bill_parts`
--

DROP TABLE IF EXISTS `bill_parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bill_parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bill_id` int(11) NOT NULL,
  `part_name` text NOT NULL,
  `rate` decimal(10,2) NOT NULL,
  `tax` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bill_parts`
--

LOCK TABLES `bill_parts` WRITE;
/*!40000 ALTER TABLE `bill_parts` DISABLE KEYS */;
INSERT INTO `bill_parts` VALUES (1,1,'Test Part',2500.00,362.50,2,5725.00),(2,2,'Test Part',2500.00,350.00,2,6400.00),(3,2,'Wiper Blade',275.00,38.50,2,704.00),(4,2,'Headlamp Assembly',3000.00,420.00,1,3840.00),(5,2,'Taillamp',2150.00,301.00,3,8256.00),(6,2,'Air Filter',275.00,38.50,1,352.00),(12,4,'Test Part',2500.00,350.00,2,6400.00),(13,4,'Wiper Blade',275.00,38.50,2,704.00),(14,4,'Headlamp Assembly',3000.00,420.00,1,3840.00),(15,4,'Taillamp',2150.00,301.00,3,8256.00),(16,4,'Air Filter',275.00,38.50,1,352.00);
/*!40000 ALTER TABLE `bill_parts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `expenses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `purpose` varchar(200) CHARACTER SET latin1 NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_on` date NOT NULL,
  `bill_no` varchar(50) CHARACTER SET latin1 NOT NULL,
  `notes` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=303 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `expenses`
--

LOCK TABLES `expenses` WRITE;
/*!40000 ALTER TABLE `expenses` DISABLE KEYS */;
INSERT INTO `expenses` VALUES (152,'parts sai',6170.00,'2013-08-26','0001',''),(153,'thayyil cement apm',3000.00,'2013-09-01','',''),(154,'parts sai',1635.00,'2013-09-02','',''),(155,'parts AM',1930.00,'2013-09-02','','REAR SKIRT PANEL ALTO 800'),(156,'EXPENSE  ',7910.00,'2013-09-02','','ALL EXPENSE 02-09-2013'),(157,'EXPEN',5500.00,'2013-09-03','',''),(158,'MALAPPURAM PAINT SHOP',2500.00,'2013-09-04','',''),(159,'WASHING',150.00,'2013-09-04','',''),(160,'EXPENSE',1620.00,'2013-09-04','',''),(161,'outside parts',380.00,'2013-09-05','',''),(162,'industrial expense',340.00,'2013-09-05','',''),(163,'EXPENSE',1240.00,'2013-09-05','',''),(164,'outside parts',3600.00,'2013-09-06','',''),(165,'EXPENSE',50.00,'2013-09-06','',''),(166,'outside parts',907.00,'2013-09-06','',''),(167,'WASHING',300.00,'2013-09-06','',''),(168,'EXPENSE',5590.00,'2013-09-07','',''),(169,'PETROL',100.00,'2013-09-07','',''),(170,'SALARY',14530.00,'2013-09-07','',''),(171,'outside parts',1655.00,'2013-09-09','',''),(172,'CORIER',100.00,'2013-09-09','',''),(173,'SALARY',500.00,'2013-09-07','','ANOOP PAINTER'),(174,'THANGAL PAINT SHOP',20000.00,'2013-09-09','',''),(175,'WASTE',2500.00,'2013-09-09','','50 KG'),(176,'SALARY',750.00,'2013-09-10','',''),(177,'parts sai MPM',298.00,'2013-09-10','',''),(178,'cargo charge',50.00,'2013-09-10','','able auto parts'),(179,'KURI MPM',20000.00,'2013-09-10','',''),(180,'outside parts',19840.00,'2013-09-11','',''),(181,'industrial expense',320.00,'2013-09-11','',''),(182,'WASHING',300.00,'2013-09-11','',''),(183,'WASHING',150.00,'2013-09-11','',''),(184,'food expense',200.00,'2013-09-11','',''),(185,'cargo charge',30.00,'2013-09-11','',''),(186,'carbade',150.00,'2013-09-12','',''),(187,'parts sai MPM',4048.00,'2013-09-12','',''),(188,'water',50.00,'2013-09-12','',''),(189,'PETROL',100.00,'2013-09-12','',''),(190,'outside parts',15.00,'2013-09-12','',''),(191,'outside parts',950.00,'2013-09-12','',''),(192,'parts sai MPM',140.00,'2013-09-13','',''),(193,'outside parts',880.00,'2013-09-13','',''),(194,'SALARY advance',3500.00,'2013-09-13','',''),(195,'parts sai',3356.00,'2013-09-12','',''),(196,'fuel - diesel arif',100.00,'2013-09-01','',''),(197,'fuel - diesel arif',100.00,'2013-09-10','',''),(198,'cargo charge',50.00,'2013-09-13','',''),(199,'outside parts',2365.00,'2013-09-13','',''),(200,'wheel alighment',180.00,'2013-09-13','',''),(201,'outside parts',6108.00,'2013-09-14','',''),(202,'sks parcel',30.00,'2013-09-14','',''),(203,'onam kit',1600.00,'2013-09-14','',''),(204,'BONUS',2500.00,'2013-09-14','',''),(205,'SALARY',14850.00,'2013-09-14','',''),(206,'outside parts',3650.00,'2013-09-16','',''),(207,'fuel - diesel arif',100.00,'2013-09-16','',''),(208,'HALOGEN BULB',100.00,'2013-09-16','',''),(209,'oxygen gas',375.00,'2013-09-14','',''),(210,'SALARY advance',500.00,'2013-09-17','',''),(211,'fuel - diesel arif',100.00,'2013-09-17','',''),(212,'outside parts',2540.00,'2013-09-18','',''),(213,'industrial expense',200.00,'2013-09-18','',''),(214,'SALARY',100.00,'2013-09-09','',''),(215,'outside parts',1500.00,'2013-09-18','',''),(216,'WASHING',150.00,'2013-09-18','',''),(217,'SALARY advance',500.00,'2013-09-18','','ARIF'),(218,'outside parts',2080.00,'2013-09-19','','ABLE'),(219,'outside parts',380.00,'2013-09-19','','HINDUSTAN CALICUT'),(220,'outside parts',450.00,'2013-09-19','','TOOL WORLD'),(221,'outside parts',585.00,'2013-09-19','','POOKKATTIL'),(222,'outside parts',330.00,'2013-09-19','','PANDI'),(223,'outside parts',700.00,'2013-09-19','','OLD BUMPER ZEN'),(224,'food expense',516.00,'2013-09-19','',''),(225,'HALOGEN BULB',200.00,'2013-09-19','',''),(226,'PETROL',100.00,'2013-09-19','',''),(227,'PETROL',200.00,'2013-09-19','',''),(228,'outside parts',850.00,'2013-09-20','',''),(229,'industrial expense',100.00,'2013-09-20','',''),(230,'outside parts',2320.00,'2013-09-20','','HEAD LIGHT ALTO'),(231,'outside parts',600.00,'2013-09-20','',''),(232,'WASTE',375.00,'2013-09-20','',''),(233,'water',50.00,'2013-09-20','',''),(234,'- BOSCH  parts',20000.00,'2013-09-20','',''),(235,'carbade',150.00,'2013-09-20','',''),(236,'SALARY',1500.00,'2013-09-20','','TRAINEE MECHANIC'),(237,'outside parts',370.00,'2013-09-20','','TOOL WORLD'),(238,'SALARY advance',1000.00,'2013-09-20','','UNAIS'),(239,'outside parts',1516.00,'2013-09-20','','ALTO AM RUNNING BOARD'),(240,'outside parts',130.00,'2013-09-21','','PANDI'),(241,'outside PAINTS',2000.00,'2013-09-21','','SEEQUENZE PMNA'),(242,'outside parts',2300.00,'2013-09-21','','OIL PMNA'),(243,'SALARY',500.00,'2013-09-21','','ANOOP'),(244,'outside parts',120.00,'2013-09-21','','SHAJI COOLING'),(245,'SALARY advance',2700.00,'2013-09-21','',''),(246,'outside parts',70.00,'2013-09-22','','GRINDING WHEEL, BOLT'),(247,'SALARY advance',200.00,'2013-09-22','','ARIF'),(248,'SALARY',650.00,'2013-09-22','','ACHAYAN MPM'),(249,'SALARY advance',500.00,'2013-09-22','','GIREESH SKY HIGH'),(250,'grinder bush ',60.00,'2013-09-23','',''),(251,'steering bush optra parts advance',500.00,'2013-09-23','',''),(252,'carbade',225.00,'2013-09-23','',''),(253,'SALARY advance',800.00,'2013-09-23','','sudharshan'),(254,'outside parts',200.00,'2013-09-23','','radiator tank'),(255,'parts sai',8025.00,'2013-09-23','',''),(256,'association membership',680.00,'2013-09-23','',''),(257,'ac gas ',560.00,'2013-09-23','',''),(258,'grinder repair',450.00,'2013-09-24','',''),(259,'industrial expense',320.00,'2013-09-24','',''),(260,'water',50.00,'2013-09-24','',''),(261,'outside parts',529.00,'2013-09-24','',''),(262,'polish pad',250.00,'2013-09-24','',''),(263,'SALARY',500.00,'2013-09-24','','mkb murali'),(264,'photostat',25.00,'2013-09-24','',''),(265,'hack saw blade',20.00,'2013-09-24','',''),(266,'SALARY advance',200.00,'2013-09-24','','arif'),(267,'photostat',47.00,'2013-09-25','',''),(268,'alto emblem',90.00,'2013-09-25','',''),(269,'polish pad',390.00,'2013-09-25','',''),(270,'outside parts',31.00,'2013-09-25','',''),(271,'parts sai MPM',100.00,'2013-09-25','',''),(272,'outside parts',2250.00,'2013-09-25','',''),(273,'over time',1000.00,'2013-09-25','','1000 saneesh & sudharshan'),(274,'outside parts',100.00,'2013-09-25','',''),(275,'outside parts',700.00,'2013-09-26','',''),(276,'outside parts',110.00,'2013-09-26','','flex gum'),(277,'parts sai',8380.00,'2013-09-26','',''),(278,'outside parts',4250.00,'2013-09-26','','pookkattil'),(279,'food expense',100.00,'2013-09-26','',''),(280,'PETROL',100.00,'2013-09-26','',''),(281,'industrial expense',300.00,'2013-09-26','','radaitor welding'),(282,'SALARY advance',500.00,'2013-09-26','','shafeeq'),(283,'SALARY advance',2000.00,'2013-09-26','','unais painter'),(284,'carbade',150.00,'2013-09-27','',''),(285,'grinder  old repaiir',580.00,'2013-09-27','',''),(286,'outside parts',1015.00,'2013-09-27','','pookkattil'),(287,'SALARY advance',500.00,'2013-09-27','','arif'),(288,'industrial expense',1200.00,'2013-09-27','','aluminium welding  zen 2 nos'),(289,'food expense',250.00,'2013-09-27','',''),(290,'marketing- letter writting',2000.00,'2013-09-27','',''),(291,'outside parts',5000.00,'2013-09-28','','banglore parts'),(292,'outside parts',10000.00,'2013-09-28','',''),(293,'sticker work vista',80.00,'2013-09-28','',''),(294,'WASHING',300.00,'2013-09-28','','2 nos'),(295,'outside parts',150.00,'2013-09-28','',''),(296,'outside parts',270.00,'2013-09-28','',''),(297,'SALARY advance',1700.00,'2013-09-28','',''),(298,'SALARY',600.00,'2013-09-28','',''),(299,'SALARY advance',1000.00,'2013-09-30','',''),(300,'outside parts',50.00,'2013-09-30','',''),(301,'water',100.00,'2013-09-30','',''),(302,'WASHING',350.00,'2013-09-30','','');
/*!40000 ALTER TABLE `expenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `insurance`
--

DROP TABLE IF EXISTS `insurance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `insurance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `insurance_name` varchar(200) NOT NULL,
  `gstin` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `insurance`
--

LOCK TABLES `insurance` WRITE;
/*!40000 ALTER TABLE `insurance` DISABLE KEYS */;
INSERT INTO `insurance` VALUES (1,'Reliance General Insurance Co Ltd','32AABCR6747B1ZP'),(2,'The New India Assurance Co Ltd','32AAACN4165C4ZXNI1234'),(3,'Uinted India Insurance Co Ltd','32AAACU5552C1ZS');
/*!40000 ALTER TABLE `insurance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_types`
--

DROP TABLE IF EXISTS `job_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_types`
--

LOCK TABLES `job_types` WRITE;
/*!40000 ALTER TABLE `job_types` DISABLE KEYS */;
INSERT INTO `job_types` VALUES (1,'Mechanical'),(2,'Dent Removal'),(3,'Painting'),(4,'Polishing'),(6,'Electrical');
/*!40000 ALTER TABLE `job_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobsheet_charges`
--

DROP TABLE IF EXISTS `jobsheet_charges`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobsheet_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobsheet_id` int(11) NOT NULL,
  `staff` int(11) NOT NULL,
  `job_type` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobsheet_charges`
--

LOCK TABLES `jobsheet_charges` WRITE;
/*!40000 ALTER TABLE `jobsheet_charges` DISABLE KEYS */;
INSERT INTO `jobsheet_charges` VALUES (5,111,4,2,300.00,NULL),(6,111,1,4,200.00,NULL),(7,112,2,1,6767.00,NULL),(8,112,4,1,7878.00,NULL),(10,113,2,1,123123.00,NULL),(11,113,1,1,12312.00,NULL),(38,15,2,3,1500.00,NULL),(39,15,1,1,500.00,NULL),(43,114,1,1,900.00,NULL),(44,114,2,3,5000.00,NULL),(45,115,2,1,500.00,NULL),(69,127,12,1,5000.00,''),(70,127,10,2,2500.00,''),(71,127,11,4,890.00,''),(74,129,12,2,500.00,'');
/*!40000 ALTER TABLE `jobsheet_charges` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobsheet_parts`
--

DROP TABLE IF EXISTS `jobsheet_parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobsheet_parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobsheet_id` int(11) NOT NULL,
  `part_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobsheet_parts`
--

LOCK TABLES `jobsheet_parts` WRITE;
/*!40000 ALTER TABLE `jobsheet_parts` DISABLE KEYS */;
INSERT INTO `jobsheet_parts` VALUES (15,15,1001,5),(16,15,1003,10),(17,15,10004,4),(22,114,1003,5),(23,114,1004,21),(24,128,1,2),(64,127,1,2),(65,127,2,2),(66,127,5,1),(67,127,6,3),(68,127,3,1),(71,129,7,10);
/*!40000 ALTER TABLE `jobsheet_parts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobsheets`
--

DROP TABLE IF EXISTS `jobsheets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobsheets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) CHARACTER SET latin1 NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `contact` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL,
  `reg_no` varchar(50) NOT NULL,
  `vehicle_make` varchar(200) NOT NULL,
  `vehicle_model` varchar(200) NOT NULL,
  `mileage` int(11) NOT NULL,
  `chassis_no` varchar(100) CHARACTER SET latin1 NOT NULL,
  `engine_no` varchar(100) CHARACTER SET latin1 NOT NULL,
  `promised_date` datetime NOT NULL,
  `estimated_amount` decimal(10,2) NOT NULL,
  `works_done` text CHARACTER SET latin1 NOT NULL,
  `is_claim` tinyint(4) NOT NULL DEFAULT '0',
  `insurance_id` int(11) DEFAULT NULL,
  `status` varchar(20) CHARACTER SET latin1 NOT NULL,
  `notes` text CHARACTER SET latin1 NOT NULL,
  `delivered_date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobsheets`
--

LOCK TABLES `jobsheets` WRITE;
/*!40000 ALTER TABLE `jobsheets` DISABLE KEYS */;
INSERT INTO `jobsheets` VALUES (115,'hasna','','9633314567','2013-08-26 00:00:00','kl-10-x-26','','',5000,'','','2013-08-27 00:00:00',500.00,'',0,NULL,'close','',NULL),(116,'ABDUSSALAM','KADUNGAPURAM','9656621464','2013-07-03 00:00:00','KL-53-L-704','','',14030,'','','2013-07-03 00:00:00',1000.00,'',0,NULL,'0','OIL CHANGE',NULL),(117,'Ashraf','','9847105701','2013-08-29 00:00:00','KL-13-T-4308','','',10000,'','','2013-08-29 00:00:00',2000.00,'',0,NULL,'0','1.Power window switch\n2.A/C belt\n3.Fog lamb bulb\n4.Brake light bulb\n5.Alternator belt','2016-12-29'),(118,'Salam','Kallan kunnan(H)\r\nAngadippuram','9037288559','2013-08-29 00:00:00','KL-10-J-808','','',12000,'','','2013-08-29 00:00:00',40.00,'',0,NULL,'0','General checkup',NULL),(119,'Ajeesh','Sreelakam(H)\r\nThootha','9895134925','2013-08-25 00:00:00','KL-51-D-4446','','',1200,'','','2013-08-25 00:00:00',3500.00,'',0,NULL,'0','Rer door LH',NULL),(120,'Haneefa','Mannengal Kannamthodi(H)\r\nOnnaputa','8593990824','2013-08-25 00:00:00','KL-53-B-8638','','',189443,'','','2013-08-25 00:00:00',8300.00,'',0,NULL,'0','Power window to check\r\nHarde brake to check',NULL),(121,'Krishna Raj','Krishna Kripa(H)\r\nPalode','9847696788','2013-08-25 00:00:00','KL-10-N-7790','','',20000,'','','2013-08-25 00:00:00',1700.00,'',0,NULL,'0','Oil leake\r\nGeneral check\r\nFront brake O/A',NULL),(122,'Ram','Thirurkkad','9037941525','2013-08-26 00:00:00','KL-54-9016','','',63209,'','','2013-08-26 00:00:00',750.00,'',0,NULL,'0','W/A\r\nCenter lock check\r\nsicerce check',NULL),(123,'Saleem','kachinikkad','9037941525','2013-08-24 00:00:00','KL-11-AK-1306','','',23456,'','','2013-08-24 00:00:00',4000.00,'',0,NULL,'0','',NULL),(124,'Thangal','Thirurkkad','9961404313','2013-08-24 00:00:00','KL-53-7345','','',12345,'','','2013-08-24 00:00:00',6850.00,'',0,NULL,'0','Patm check\r\n',NULL),(125,'BAVA','Angadippuram','9288703783','2013-08-21 00:00:00','KL-10-Q-8094','','',26391,'','','2013-08-21 00:00:00',7000.00,'',0,NULL,'0','Ball joint R/A\r\nStealing bon O/H\r\nLH stock O/H\r\nW/A\r\nFront brake O/H\r\nRH Stock O/H',NULL),(126,'Abilash  ITL motors','ITL Motors','9037941525','2013-08-26 00:00:00','KL-10-P-1304','','',158000,'','','2013-08-26 00:00:00',1800.00,'',0,NULL,'0','Oil leack\r\nFront brake O/H\r\nOil change',NULL),(127,'muhsin','angadippuram','9847665036','2016-12-29 00:00:00','KL-10-AE-6630','','',456,'','','2016-12-29 00:00:00',100.00,'',1,2,'close','','2016-12-29'),(128,'Nisar','','8547257874','2017-08-08 00:00:00','KL-07-BS-8068','','',85000,'','','2017-08-10 00:00:00',0.00,'',0,NULL,'close','','2017-08-24'),(129,'dfgdf','','234234','2017-08-09 00:00:00','KL-13-T-4308','Ford','Figo',234234,'','','2017-08-10 00:00:00',0.00,'',0,0,'complete','','2017-08-10'),(130,'dfgdf','','34534344','2017-08-10 00:00:00','34543','','',34534,'','','2017-08-13 00:00:00',0.00,'',1,1,'open','',NULL);
/*!40000 ALTER TABLE `jobsheets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET latin1 NOT NULL,
  `password` varchar(200) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login`
--

LOCK TABLES `login` WRITE;
/*!40000 ALTER TABLE `login` DISABLE KEYS */;
INSERT INTO `login` VALUES (1,'autoplanet','6a3684e5ffe98ea04a5f877ef0f163dd'),(2,'admin','4fa514e99e7e1ded1442f9e8741c8b46');
/*!40000 ALTER TABLE `login` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parts`
--

DROP TABLE IF EXISTS `parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_no` varchar(200) NOT NULL,
  `hsn_code` varchar(200) NOT NULL,
  `part_name` varchar(200) DEFAULT NULL,
  `quantity` int(5) NOT NULL,
  `dealer_price` decimal(10,2) NOT NULL,
  `mrp` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parts`
--

LOCK TABLES `parts` WRITE;
/*!40000 ALTER TABLE `parts` DISABLE KEYS */;
INSERT INTO `parts` VALUES (1,'','','Test Part',25,1500.00,2500.00,''),(2,'','','Wiper Blade',8,250.00,275.00,'Wiper blades'),(3,'','','Air Filter',10,250.00,275.00,''),(4,'1122','sdsdf','Fuel Filter',25,1500.00,1750.00,''),(5,'','','Headlamp Assembly',35,2800.00,3000.00,'Headlamp Assembly'),(6,'','','Taillamp',10,2000.00,2150.00,'Headlamp Assembly'),(7,'XYZ1243','HSS111','All New Part With Lamps',50,875.00,900.00,'This is a full description of the part name.'),(8,'888','hsn888','part888',0,1800.00,825.00,'Blahblah');
/*!40000 ALTER TABLE `parts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parts_stock`
--

DROP TABLE IF EXISTS `parts_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parts_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `part_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parts_stock`
--

LOCK TABLES `parts_stock` WRITE;
/*!40000 ALTER TABLE `parts_stock` DISABLE KEYS */;
INSERT INTO `parts_stock` VALUES (1,1,6),(2,5,24),(3,4,10),(4,3,24),(5,6,52),(6,2,7);
/*!40000 ALTER TABLE `parts_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_modes`
--

DROP TABLE IF EXISTS `payment_modes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_modes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mode` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_modes`
--

LOCK TABLES `payment_modes` WRITE;
/*!40000 ALTER TABLE `payment_modes` DISABLE KEYS */;
INSERT INTO `payment_modes` VALUES (1,'Cash'),(2,'Credit');
/*!40000 ALTER TABLE `payment_modes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff`
--

DROP TABLE IF EXISTS `staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET latin1 NOT NULL,
  `role` int(11) NOT NULL,
  `address` text CHARACTER SET latin1 NOT NULL,
  `contact` varchar(100) CHARACTER SET latin1 NOT NULL,
  `email` varchar(200) CHARACTER SET latin1 NOT NULL,
  `notes` text CHARACTER SET latin1 NOT NULL,
  `created_on` date NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
INSERT INTO `staff` VALUES (1,'Shafi',1,'Angadippuram,\r\nMalappuram','98765467','shafi@test.com','kjhuyuh asdasdas dasd asd adasdasdqwdq qdqwdqwdqwd.','2013-08-14',0.00),(6,'arif painter',2,'0','8893613300','','','2013-09-11',10500.00),(7,'saneesh',1,'0','9747315461','','','2013-09-11',16000.00),(8,'unaise',2,'0','9656048336','','','2013-09-11',13500.00),(9,'udayan',1,'0','9745986850','','','2013-09-11',10000.00),(10,'shafeeque',1,'0','9744064630','','','2013-09-11',12000.00),(11,'sudharshan',1,'0','9562532129','','','2013-09-11',9000.00),(12,'outside worker',1,'0','9037941525','','','2013-09-11',9000.00);
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `staff_roles`
--

DROP TABLE IF EXISTS `staff_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_roles`
--

LOCK TABLES `staff_roles` WRITE;
/*!40000 ALTER TABLE `staff_roles` DISABLE KEYS */;
INSERT INTO `staff_roles` VALUES (1,'Mechanic'),(2,'Painter');
/*!40000 ALTER TABLE `staff_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wages`
--

DROP TABLE IF EXISTS `wages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `staff` int(11) NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `created_on` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wages`
--

LOCK TABLES `wages` WRITE;
/*!40000 ALTER TABLE `wages` DISABLE KEYS */;
INSERT INTO `wages` VALUES (2,1750.50,2,'hihiuhihih','2013-08-02'),(3,2000.90,1,'knuhiuhiuhhuihihihi','2013-08-25'),(4,1500.00,2,'Partial','2013-09-08'),(5,3000.00,2,'','2013-09-08'),(6,600.00,12,'subash tinker','2013-09-02'),(7,350.00,12,'rasheed painter','2013-09-04'),(8,500.00,6,'','2013-09-04'),(9,1000.00,12,'gireesh tinker sky high','2013-09-05'),(10,1000.00,10,'','2013-09-07'),(11,1500.00,9,'','2013-09-07'),(12,500.00,6,'','2013-09-07'),(13,500.00,12,'ANOOP PAINTER','2013-09-09'),(14,100.00,6,'','2013-09-10'),(15,550.00,12,'ACHAYAN PAINTER MPM','2013-09-10'),(16,100.00,8,'','2013-09-10'),(17,2500.00,6,'','2013-09-12'),(18,3500.00,8,'','2013-09-13'),(19,2500.00,9,'','2013-09-14'),(20,1000.00,10,'','2013-09-14'),(21,5000.00,12,'gireesh tinker sky high','2013-09-14'),(22,500.00,10,'','2013-09-14'),(23,500.00,6,'','2013-09-18'),(24,1000.00,8,'','2013-09-20'),(25,500.00,12,'ANOOP PAINTER','2013-09-21'),(26,700.00,9,'','2013-09-21'),(27,1500.00,10,'','2013-09-21'),(28,500.00,7,'','2013-09-21'),(29,200.00,6,'','2013-09-22'),(30,650.00,12,'ACHAYAN PAINTER MPM','2013-09-22'),(31,500.00,12,'gireesh tinker sky high','2013-09-22'),(32,800.00,11,'','2013-09-23'),(33,200.00,6,'','2013-09-24'),(34,500.00,12,'mkb murali','2013-09-24'),(35,500.00,10,'','2013-09-26'),(36,2000.00,8,'','2013-09-26'),(37,500.00,6,'','2013-09-27'),(38,500.00,7,'','2013-09-28'),(39,1000.00,10,'','2013-09-28'),(40,200.00,11,'','2013-09-28'),(41,600.00,12,'kannan tinker','2013-09-29'),(42,1000.00,11,'','2013-09-30');
/*!40000 ALTER TABLE `wages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-10 13:59:34
