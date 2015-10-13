-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bambooinvoice
-- ------------------------------------------------------
-- Server version	5.5.44-0ubuntu0.14.04.1

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
-- Current Database: `bambooinvoice`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `bambooinvoice` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bambooinvoice`;

--
-- Table structure for table `bamboo_clientcontacts`
--

DROP TABLE IF EXISTS `bamboo_clientcontacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bamboo_clientcontacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `first_name` varchar(25) DEFAULT NULL,
  `last_name` varchar(25) DEFAULT NULL,
  `title` varchar(75) DEFAULT NULL,
  `email` varchar(127) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `access_level` tinyint(1) DEFAULT '0',
  `supervisor` int(11) DEFAULT NULL,
  `last_login` int(11) DEFAULT NULL,
  `password_reset` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bamboo_clientcontacts`
--

LOCK TABLES `bamboo_clientcontacts` WRITE;
/*!40000 ALTER TABLE `bamboo_clientcontacts` DISABLE KEYS */;
INSERT INTO `bamboo_clientcontacts` VALUES (1,0,NULL,NULL,NULL,'a@a.com',NULL,'AnA=',1,NULL,1444728500,'');
/*!40000 ALTER TABLE `bamboo_clientcontacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bamboo_clients`
--

DROP TABLE IF EXISTS `bamboo_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bamboo_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(25) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `tax_status` int(1) DEFAULT '1',
  `client_notes` mediumtext,
  `tax_code` varchar(75) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bamboo_clients`
--

LOCK TABLES `bamboo_clients` WRITE;
/*!40000 ALTER TABLE `bamboo_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `bamboo_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bamboo_invoice_histories`
--

DROP TABLE IF EXISTS `bamboo_invoice_histories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bamboo_invoice_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `clientcontacts_id` varchar(255) DEFAULT NULL,
  `date_sent` date DEFAULT NULL,
  `contact_type` int(1) DEFAULT NULL,
  `email_body` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bamboo_invoice_histories`
--

LOCK TABLES `bamboo_invoice_histories` WRITE;
/*!40000 ALTER TABLE `bamboo_invoice_histories` DISABLE KEYS */;
/*!40000 ALTER TABLE `bamboo_invoice_histories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bamboo_invoice_items`
--

DROP TABLE IF EXISTS `bamboo_invoice_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bamboo_invoice_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT '0',
  `amount` decimal(11,2) DEFAULT '0.00',
  `quantity` decimal(7,2) DEFAULT '1.00',
  `work_description` mediumtext,
  `taxable` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bamboo_invoice_items`
--

LOCK TABLES `bamboo_invoice_items` WRITE;
/*!40000 ALTER TABLE `bamboo_invoice_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `bamboo_invoice_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bamboo_invoice_payments`
--

DROP TABLE IF EXISTS `bamboo_invoice_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bamboo_invoice_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) DEFAULT NULL,
  `date_paid` date DEFAULT NULL,
  `amount_paid` float(7,2) DEFAULT NULL,
  `payment_note` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bamboo_invoice_payments`
--

LOCK TABLES `bamboo_invoice_payments` WRITE;
/*!40000 ALTER TABLE `bamboo_invoice_payments` DISABLE KEYS */;
/*!40000 ALTER TABLE `bamboo_invoice_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bamboo_invoices`
--

DROP TABLE IF EXISTS `bamboo_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bamboo_invoices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) DEFAULT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `dateIssued` date DEFAULT NULL,
  `payment_term` varchar(50) DEFAULT NULL,
  `tax1_desc` varchar(50) DEFAULT NULL,
  `tax1_rate` decimal(6,3) DEFAULT NULL,
  `tax2_desc` varchar(50) DEFAULT NULL,
  `tax2_rate` decimal(6,3) DEFAULT NULL,
  `invoice_note` text,
  `days_payment_due` int(3) unsigned DEFAULT '30',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bamboo_invoices`
--

LOCK TABLES `bamboo_invoices` WRITE;
/*!40000 ALTER TABLE `bamboo_invoices` DISABLE KEYS */;
/*!40000 ALTER TABLE `bamboo_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bamboo_sessions`
--

DROP TABLE IF EXISTS `bamboo_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bamboo_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) DEFAULT '',
  `last_activity` int(10) unsigned DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `user_data` text,
  `logged_in` int(1) DEFAULT '0',
  PRIMARY KEY (`session_id`,`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bamboo_sessions`
--

LOCK TABLES `bamboo_sessions` WRITE;
/*!40000 ALTER TABLE `bamboo_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `bamboo_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bamboo_settings`
--

DROP TABLE IF EXISTS `bamboo_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bamboo_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(75) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(25) DEFAULT NULL,
  `country` varchar(25) DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `website` varchar(150) DEFAULT NULL,
  `primary_contact` varchar(75) DEFAULT NULL,
  `primary_contact_email` varchar(50) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `logo_pdf` varchar(50) DEFAULT NULL,
  `invoice_note_default` varchar(255) DEFAULT NULL,
  `currency_type` varchar(20) DEFAULT NULL,
  `currency_symbol` varchar(9) DEFAULT '$',
  `tax_code` varchar(50) DEFAULT NULL,
  `tax1_desc` varchar(50) DEFAULT NULL,
  `tax1_rate` float(6,3) DEFAULT '0.000',
  `tax2_desc` varchar(50) DEFAULT NULL,
  `tax2_rate` float(6,3) DEFAULT '0.000',
  `save_invoices` char(1) DEFAULT 'n',
  `days_payment_due` int(3) unsigned DEFAULT '30',
  `demo_flag` char(1) DEFAULT 'n',
  `display_branding` char(1) DEFAULT 'y',
  `bambooinvoice_version` varchar(9) DEFAULT NULL,
  `new_version_autocheck` char(1) DEFAULT 'n',
  `logo_realpath` char(1) DEFAULT 'n',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bamboo_settings`
--

LOCK TABLES `bamboo_settings` WRITE;
/*!40000 ALTER TABLE `bamboo_settings` DISABLE KEYS */;
INSERT INTO `bamboo_settings` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'a','a@a.com',NULL,NULL,NULL,NULL,'$',NULL,NULL,0.000,NULL,0.000,'n',30,'n','y','0.8.9','y','n');
/*!40000 ALTER TABLE `bamboo_settings` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-10-13 11:30:31
