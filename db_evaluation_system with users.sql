CREATE DATABASE  IF NOT EXISTS `db_evaluation_system` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `db_evaluation_system`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: localhost    Database: db_evaluation_system
-- ------------------------------------------------------
-- Server version	5.7.13-log

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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table',1),('2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_appraisal`
--

DROP TABLE IF EXISTS `tbl_appraisal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_appraisal` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_appraisal` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_property` int(11) unsigned NOT NULL,
  `id_appraiser` int(11) unsigned NOT NULL,
  `appraisal_status` tinyint(1) NOT NULL COMMENT '0=Available for Appraisal\n1=Requested for Appraisal\n2=Appraisal Completed\n3=Re-appraise\n4=Publish\n5=Sold',
  `remarks` varchar(255) DEFAULT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_appraisal`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_appraisal`
--

LOCK TABLES `tbl_appraisal` WRITE;
/*!40000 ALTER TABLE `tbl_appraisal` DISABLE KEYS */;
INSERT INTO `tbl_appraisal` VALUES ('2018-02-28 14:46:29','2018-02-28 07:11:53',3,3,5,2,'Pa appraise po',0),('2018-02-28 16:59:57','2018-03-01 06:40:17',4,4,5,2,'',0),('2018-03-02 12:25:39','2018-03-02 04:28:53',5,5,5,2,'Please appraise',0);
/*!40000 ALTER TABLE `tbl_appraisal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_appraisal_details`
--

DROP TABLE IF EXISTS `tbl_appraisal_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_appraisal_details` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_appraisal_details` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_appraisal` int(11) unsigned NOT NULL,
  `id_comparable_property` int(11) unsigned NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_appraisal_details`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_appraisal_details`
--

LOCK TABLES `tbl_appraisal_details` WRITE;
/*!40000 ALTER TABLE `tbl_appraisal_details` DISABLE KEYS */;
INSERT INTO `tbl_appraisal_details` VALUES ('2018-02-28 15:11:53','0000-00-00 00:00:00','0000-00-00 00:00:00',97,3,97,NULL),('2018-02-28 15:11:53','0000-00-00 00:00:00','0000-00-00 00:00:00',98,3,98,NULL),('2018-02-28 15:11:53','0000-00-00 00:00:00','0000-00-00 00:00:00',99,3,99,NULL),('2018-03-01 14:40:17','0000-00-00 00:00:00','0000-00-00 00:00:00',101,4,101,NULL),('2018-03-01 14:40:17','0000-00-00 00:00:00','0000-00-00 00:00:00',102,4,102,NULL),('2018-03-01 14:40:17','0000-00-00 00:00:00','0000-00-00 00:00:00',103,4,103,NULL),('2018-03-02 12:28:53','0000-00-00 00:00:00','0000-00-00 00:00:00',104,5,104,NULL),('2018-03-02 12:28:53','0000-00-00 00:00:00','0000-00-00 00:00:00',105,5,105,NULL),('2018-03-02 12:28:53','0000-00-00 00:00:00','0000-00-00 00:00:00',106,5,106,NULL);
/*!40000 ALTER TABLE `tbl_appraisal_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_appraisal_property_picture`
--

DROP TABLE IF EXISTS `tbl_appraisal_property_picture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_appraisal_property_picture` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL,
  `id_property_picture` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_property` int(11) unsigned NOT NULL,
  `picture_path` varchar(255) NOT NULL,
  PRIMARY KEY (`id_property_picture`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_appraisal_property_picture`
--

LOCK TABLES `tbl_appraisal_property_picture` WRITE;
/*!40000 ALTER TABLE `tbl_appraisal_property_picture` DISABLE KEYS */;
INSERT INTO `tbl_appraisal_property_picture` VALUES ('2018-03-02 17:33:31',NULL,4,4,'assets/image/appraise/20180302053331.jpg'),('2018-03-02 17:33:38',NULL,5,4,'assets/image/appraise/20180302053338.jpg'),('2018-03-02 17:33:49',NULL,6,4,'assets/image/appraise/20180302053349.jpg');
/*!40000 ALTER TABLE `tbl_appraisal_property_picture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_appraise_property`
--

DROP TABLE IF EXISTS `tbl_appraise_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_appraise_property` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL,
  `id_appraise_property` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_appraisal` int(11) NOT NULL,
  `inspection_date` date DEFAULT NULL,
  `appraisal_date` date DEFAULT NULL,
  `id_house_model` int(11) DEFAULT NULL,
  `registry_of_deeds` varchar(255) DEFAULT NULL,
  `number_of_storeys` int(11) DEFAULT NULL,
  `effective_age` int(11) DEFAULT NULL,
  `total_ecolife` int(11) DEFAULT NULL,
  `remaining_ecolife` int(11) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `house_value` double NOT NULL,
  `ave_lot_value` double DEFAULT NULL,
  `total_lot_value` double DEFAULT NULL,
  `total_house_value` double DEFAULT NULL,
  `total_property_value` double DEFAULT NULL,
  PRIMARY KEY (`id_appraise_property`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_appraise_property`
--

LOCK TABLES `tbl_appraise_property` WRITE;
/*!40000 ALTER TABLE `tbl_appraise_property` DISABLE KEYS */;
INSERT INTO `tbl_appraise_property` VALUES ('2018-02-28 15:11:53','0000-00-00 00:00:00',8,3,'2018-02-28','2018-02-28',3,'1',2,5,20,15,'',0,40000,2000000,37500,2037500),('2018-03-01 14:40:17','0000-00-00 00:00:00',9,4,'2018-03-01','2018-03-01',3,'1',2,5,20,15,'',0,60000,6000000,37500,6037500),('2018-03-02 12:28:53','0000-00-00 00:00:00',10,5,'2018-03-01','2018-03-02',2,'Markina',2,5,30,25,'',50000,9166.67,458333.5,41666.67,500000.17);
/*!40000 ALTER TABLE `tbl_appraise_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_appraiser`
--

DROP TABLE IF EXISTS `tbl_appraiser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_appraiser` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_appraiser` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) NOT NULL,
  `contact_num` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `last_signedin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ind_deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_appraiser`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_appraiser`
--

LOCK TABLES `tbl_appraiser` WRITE;
/*!40000 ALTER TABLE `tbl_appraiser` DISABLE KEYS */;
INSERT INTO `tbl_appraiser` VALUES ('2018-02-13 05:10:55','0000-00-00 00:00:00',4,5,'John','','Doe',NULL,NULL,NULL,'0000-00-00 00:00:00',0),('2018-02-27 14:28:33','0000-00-00 00:00:00',5,6,'Paul','','Cruz',NULL,NULL,'assets/image/avatar/20180227022833.jpg','0000-00-00 00:00:00',0);
/*!40000 ALTER TABLE `tbl_appraiser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_barangay`
--

DROP TABLE IF EXISTS `tbl_barangay`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_barangay` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_barangay` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `barangay_code` varchar(45) NOT NULL,
  `barangay_description` varchar(255) NOT NULL,
  `id_city` int(11) unsigned NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_barangay`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_barangay`
--

LOCK TABLES `tbl_barangay` WRITE;
/*!40000 ALTER TABLE `tbl_barangay` DISABLE KEYS */;
INSERT INTO `tbl_barangay` VALUES ('2018-02-10 15:02:11','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'MRKN HGHTS','Marikina Heights',1,0),('2018-02-10 15:03:03','0000-00-00 00:00:00','0000-00-00 00:00:00',2,'CPCN 1','Concepcion Uno',1,0),('2018-02-10 15:09:32','0000-00-00 00:00:00','0000-00-00 00:00:00',3,'CPCN 2','Concepcion Dos',1,0),('2018-02-28 14:40:39','0000-00-00 00:00:00','0000-00-00 00:00:00',4,'PC','Pedro Cruz',4,0);
/*!40000 ALTER TABLE `tbl_barangay` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_city`
--

DROP TABLE IF EXISTS `tbl_city`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_city` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_city` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `city_code` varchar(45) NOT NULL,
  `city_description` varchar(255) NOT NULL,
  `id_province` int(11) unsigned NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_city`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_city`
--

LOCK TABLES `tbl_city` WRITE;
/*!40000 ALTER TABLE `tbl_city` DISABLE KEYS */;
INSERT INTO `tbl_city` VALUES ('2018-02-10 14:36:44','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'MRKN','Marikina',1,0),('2018-02-10 15:05:23','0000-00-00 00:00:00','0000-00-00 00:00:00',2,'MND','Mandaluyong',1,0),('2018-02-10 15:05:39','0000-00-00 00:00:00','0000-00-00 00:00:00',3,'PSG','Pasig',1,0),('2018-02-28 14:40:18','2018-02-28 06:40:25','0000-00-00 00:00:00',4,'SJ','San Juan',1,0);
/*!40000 ALTER TABLE `tbl_city` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_comparable_property`
--

DROP TABLE IF EXISTS `tbl_comparable_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_comparable_property` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_comparable_property` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `property_name` varchar(255) NOT NULL,
  `id_property_location` int(11) NOT NULL,
  `property_type` tinyint(1) NOT NULL,
  `lot_value` double NOT NULL,
  `id_appraiser` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_comparable_property`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_comparable_property`
--

LOCK TABLES `tbl_comparable_property` WRITE;
/*!40000 ALTER TABLE `tbl_comparable_property` DISABLE KEYS */;
INSERT INTO `tbl_comparable_property` VALUES ('2018-02-28 15:11:53','0000-00-00 00:00:00',97,'Polinar',130,1,40000,0),('2018-02-28 15:11:53','0000-00-00 00:00:00',98,'Alaysa',131,1,10000,0),('2018-02-28 15:11:53','0000-00-00 00:00:00',99,'Dela Cruz',132,1,70000,0),('2018-03-01 14:40:17','0000-00-00 00:00:00',101,'Gestiada',135,1,10000,0),('2018-03-01 14:40:17','0000-00-00 00:00:00',102,'Cruz',136,1,80000,0),('2018-03-01 14:40:17','0000-00-00 00:00:00',103,'Villareal',137,1,90000,0),('2018-03-02 12:28:53','0000-00-00 00:00:00',104,'Dansalan',139,1,9000,0),('2018-03-02 12:28:53','0000-00-00 00:00:00',105,'Dansalan2',140,1,8500,0),('2018-03-02 12:28:53','0000-00-00 00:00:00',106,'Dansalan 3',141,1,10000,0);
/*!40000 ALTER TABLE `tbl_comparable_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_house_model`
--

DROP TABLE IF EXISTS `tbl_house_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_house_model` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_house_model` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `house_model` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_house_model`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_house_model`
--

LOCK TABLES `tbl_house_model` WRITE;
/*!40000 ALTER TABLE `tbl_house_model` DISABLE KEYS */;
INSERT INTO `tbl_house_model` VALUES ('2018-02-13 12:29:53','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'Cottage','Cottage',0),('2018-02-13 12:31:46','0000-00-00 00:00:00','0000-00-00 00:00:00',2,'Bungalow','Bungalow',0),('2018-02-13 12:32:22','0000-00-00 00:00:00','0000-00-00 00:00:00',3,'Mansion','Mansion',0);
/*!40000 ALTER TABLE `tbl_house_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_property`
--

DROP TABLE IF EXISTS `tbl_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_property` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_property` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `property_name` varchar(255) NOT NULL,
  `id_seller` int(11) unsigned NOT NULL,
  `id_property_location` int(11) unsigned NOT NULL,
  `property_type` tinyint(1) NOT NULL COMMENT '0=Lot\n1=House and Lot',
  `property_status` tinyint(1) NOT NULL COMMENT '0=Available for Appraisal\n1=Requested for Appraisal\n2=Appraisal Completed\n3=Re-appraise\n4=Publish\n5=Sold',
  `tct_number` varchar(255) NOT NULL,
  `lot_area` double NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_property`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_property`
--

LOCK TABLES `tbl_property` WRITE;
/*!40000 ALTER TABLE `tbl_property` DISABLE KEYS */;
INSERT INTO `tbl_property` VALUES ('2018-02-28 14:41:36','2018-02-28 07:11:53','0000-00-00 00:00:00',3,'Cruz Property',1,117,1,4,'1',50,0),('2018-02-28 16:59:47','2018-03-01 06:40:17','0000-00-00 00:00:00',4,'Navarro',1,133,1,4,'2',100,0),('2018-03-02 12:25:20','2018-03-02 04:28:53','0000-00-00 00:00:00',5,'DMCI',1,138,1,4,'1234ABC',50,0),('2018-03-03 01:16:09','0000-00-00 00:00:00','0000-00-00 00:00:00',6,'Paul Property',2,142,1,0,'123456789',100,0),('2018-03-03 01:16:33','0000-00-00 00:00:00','2018-03-02 18:49:02',7,'Paul Property',2,143,1,0,'123456789',100,1);
/*!40000 ALTER TABLE `tbl_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_property_location`
--

DROP TABLE IF EXISTS `tbl_property_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_property_location` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_property_location` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(255) DEFAULT NULL,
  `id_barangay` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_property_location`)
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_property_location`
--

LOCK TABLES `tbl_property_location` WRITE;
/*!40000 ALTER TABLE `tbl_property_location` DISABLE KEYS */;
INSERT INTO `tbl_property_location` VALUES ('2018-02-28 14:41:36','0000-00-00 00:00:00',117,'521 D. Santiago St., San Juan City Pedro Cruz San Juan Metro Manila National Capital Region',4),('2018-02-28 15:11:53','0000-00-00 00:00:00',130,'Polinar Pedro Cruz San Juan Metro Manila National Capital Region',4),('2018-02-28 15:11:53','0000-00-00 00:00:00',131,'Alaysa Pedro Cruz San Juan Metro Manila National Capital Region',4),('2018-02-28 15:11:53','0000-00-00 00:00:00',132,'Dela Cruz Pedro Cruz San Juan Metro Manila National Capital Region',4),('2018-02-28 16:59:47','0000-00-00 00:00:00',133,'San Juan Pedro Cruz San Juan Metro Manila National Capital Region',4),('2018-03-01 14:40:17','0000-00-00 00:00:00',135,'Gestiada Pedro Cruz San Juan Metro Manila National Capital Region',4),('2018-03-01 14:40:17','0000-00-00 00:00:00',136,'Cruz Pedro Cruz San Juan Metro Manila National Capital Region',4),('2018-03-01 14:40:17','0000-00-00 00:00:00',137,'Villareal Pedro Cruz San Juan Metro Manila National Capital Region',4),('2018-03-02 12:25:20','0000-00-00 00:00:00',138,'24J Sycamore Marikina Heights Marikina Metro Manila National Capital Region',1),('2018-03-02 12:28:53','0000-00-00 00:00:00',139,'123J Marikina Heights Marikina Metro Manila National Capital Region',1),('2018-03-02 12:28:53','0000-00-00 00:00:00',140,'1E Marikina Heights Marikina Metro Manila National Capital Region',1),('2018-03-02 12:28:53','0000-00-00 00:00:00',141,'34I Marikina Heights Marikina Metro Manila National Capital Region',1),('2018-03-03 01:16:09','0000-00-00 00:00:00',142,'17 Street Marikina Heights Marikina Metro Manila National Capital Region',1),('2018-03-03 01:16:33','0000-00-00 00:00:00',143,'17 Street Marikina Heights Marikina Metro Manila National Capital Region',1);
/*!40000 ALTER TABLE `tbl_property_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_province`
--

DROP TABLE IF EXISTS `tbl_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_province` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_province` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `province_code` varchar(45) NOT NULL,
  `province_description` varchar(255) NOT NULL,
  `id_region` int(11) unsigned NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_province`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_province`
--

LOCK TABLES `tbl_province` WRITE;
/*!40000 ALTER TABLE `tbl_province` DISABLE KEYS */;
INSERT INTO `tbl_province` VALUES ('2018-02-10 14:35:00','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'MM','Metro Manila',1,0);
/*!40000 ALTER TABLE `tbl_province` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_region`
--

DROP TABLE IF EXISTS `tbl_region`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_region` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_region` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `region_code` varchar(45) NOT NULL,
  `region_description` varchar(255) NOT NULL,
  `ind_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_region`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_region`
--

LOCK TABLES `tbl_region` WRITE;
/*!40000 ALTER TABLE `tbl_region` DISABLE KEYS */;
INSERT INTO `tbl_region` VALUES ('2018-02-10 13:15:13','0000-00-00 00:00:00','0000-00-00 00:00:00',1,'NCR','National Capital Region',0);
/*!40000 ALTER TABLE `tbl_region` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_sell_property`
--

DROP TABLE IF EXISTS `tbl_sell_property`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_sell_property` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT NULL,
  `id_sell_property` int(11) NOT NULL AUTO_INCREMENT,
  `id_appraisal` int(11) NOT NULL,
  `price` double NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `counter` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_sell_property`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_sell_property`
--

LOCK TABLES `tbl_sell_property` WRITE;
/*!40000 ALTER TABLE `tbl_sell_property` DISABLE KEYS */;
INSERT INTO `tbl_sell_property` VALUES ('2018-02-28 15:47:29',NULL,1,3,2038000,'PASOK MGA SUKI PRESYONG DIVISORIA',1),('2018-03-02 12:34:44',NULL,2,5,600000,'Please contact me',0),('2018-03-02 17:34:28',NULL,3,4,6038000,'BILI NA!',0);
/*!40000 ALTER TABLE `tbl_sell_property` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_seller`
--

DROP TABLE IF EXISTS `tbl_seller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_seller` (
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `delete_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `id_seller` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `middle_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) NOT NULL,
  `contact_number` varchar(45) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `last_signedin` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ind_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `ind_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_seller`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_seller`
--

LOCK TABLES `tbl_seller` WRITE;
/*!40000 ALTER TABLE `tbl_seller` DISABLE KEYS */;
INSERT INTO `tbl_seller` VALUES ('2018-02-08 16:56:49','2018-02-27 18:30:17','0000-00-00 00:00:00',1,4,'juan','','dela  cruz',NULL,NULL,NULL,'0000-00-00 00:00:00',0,1),('2018-03-03 01:13:33','2018-03-02 17:14:58','0000-00-00 00:00:00',2,9,'John Paul','','Escala',NULL,NULL,NULL,'0000-00-00 00:00:00',0,1),('2018-03-03 02:50:11','0000-00-00 00:00:00','0000-00-00 00:00:00',3,10,'Lhen','','Balderas',NULL,NULL,NULL,'0000-00-00 00:00:00',0,0);
/*!40000 ALTER TABLE `tbl_seller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `create_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_type` tinyint(1) NOT NULL COMMENT '0-admin\n1-appraiser\n2-seller',
  `ind_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('2018-02-13 05:10:55','0000-00-00 00:00:00',0,'admin@gmail.com','$2y$10$ca2eanzRzw4NJZBmETJ72u.1TqX1BtWmUPXbW9Wh8Z0vhQnokNG7W','BRJ0eFDzkuJopWj1L6YZ5T46JvCWClwRTmZjgBYZYGzgOfsx3fG3df8uI2JR',0,0),('2018-02-08 16:56:49','0000-00-00 00:00:00',4,'jd@gmail.com','$2y$10$JmjppASARHTZOj4pOfSGHuwNASzCRSdC/e4idjiSECUqtYlCDM1i2','D04xah6hoNRcBMQHwtdNRqb5HI8MmfHnghazSbG64Xe0VhwPFwt5NYrdtNCK',2,0),('2018-02-13 05:10:55','0000-00-00 00:00:00',5,'jdoe@gmail.com','$2y$10$ca2eanzRzw4NJZBmETJ72u.1TqX1BtWmUPXbW9Wh8Z0vhQnokNG7W','PxE3QQnRHL0dUdpGh3GEkFjmaBIrzvG14g48jrzatZd9lJAgVvgvnGzMCrJm',1,0),('2018-02-27 14:28:33','0000-00-00 00:00:00',6,'p@c.com','$2y$10$G0v5ekL356lFbTW1QgPE8uIzd7FaNv0AjH2nkYG8v1dkJLVdzPpZ.','NtKDNYXYchDCOdhtW61WyGBLzJl5KqtHG4qafPFd0t2364Nvz1yBndWjr2fn',1,0),('2018-02-28 13:09:21','2018-02-27 16:00:00',7,'pacruz@yahoo.com','$2y$10$G0v5ekL356lFbTW1QgPE8uIzd7FaNv0AjH2nkYG8v1dkJLVdzPpZ.','r9ZzBPBvY95HnkXbqwDfa8en7nEZJU9InKScHSammtNkpxjigDJ1JXJjNz8Y',0,0),('2018-03-03 01:13:33','0000-00-00 00:00:00',9,'jpescala@gmail.com','$2y$10$NHLfelPc68PwuCcZI0pjce9f8duIhzxqP2lErXH8GZ8rGfQZy.17.','nf5uvNjnnuQnPrwQthL86B0NvVIEMFheVRzEia7W6fm6vmC1G2bYg0jr3M6c',2,0),('2018-03-03 02:50:11','0000-00-00 00:00:00',10,'lhen@gmail.com','$2y$10$s2MusZnFM0TNQQX6MsxUNuBFNzE4jfMWYJLDir8NttELeBdMMQ3LG',NULL,2,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'db_evaluation_system'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-03-03 11:27:46
