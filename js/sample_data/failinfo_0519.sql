-- MySQL dump 10.13  Distrib 5.7.29, for Win64 (x86_64)
--
-- Host: localhost    Database: DQA_Record
-- ------------------------------------------------------
-- Server version	5.7.29

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
-- Table structure for table `fail_infomation`
--

DROP TABLE IF EXISTS `fail_infomation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fail_infomation` (
  `FID` bigint(20) NOT NULL AUTO_INCREMENT,
  `Defectmode1` text,
  `Defectmode2` text,
  `RCCA` text,
  `Issuestatus` varchar(15) DEFAULT NULL,
  `Category` varchar(10) DEFAULT NULL,
  `PIC` varchar(10) DEFAULT NULL,
  `JIRANO` varchar(10) DEFAULT NULL,
  `SPR` varchar(10) DEFAULT NULL,
  `Temp` varchar(5) DEFAULT NULL,
  `Dropcycles` varchar(3) DEFAULT NULL,
  `Drops` varchar(3) DEFAULT NULL,
  `Dropside` varchar(20) DEFAULT NULL,
  `Hit` varchar(4) DEFAULT NULL,
  `NextCheckpointDate` varchar(15) DEFAULT NULL,
  `IssuePublished` varchar(5) DEFAULT NULL,
  `ORTMFGDate` varchar(15) DEFAULT NULL,
  `ReportedDate` varchar(15) DEFAULT NULL,
  `IssueDuration` varchar(5) DEFAULT NULL,
  `Today` varchar(15) DEFAULT NULL,
  `Unitsno` varchar(3) DEFAULT NULL,
  `TestID` bigint(20) DEFAULT NULL,
  `RowID` varchar(3) DEFAULT NULL,
  `CellID` varchar(3) DEFAULT NULL,
  `Results` varchar(20) DEFAULT 'TBD',
  PRIMARY KEY (`FID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fail_infomation`
--

LOCK TABLES `fail_infomation` WRITE;
/*!40000 ALTER TABLE `fail_infomation` DISABLE KEYS */;
INSERT INTO `fail_infomation` VALUES (1,'[Battery] Pop out','Flash, No function, Camera flash broken','33333333333333AAAAAAAAAAAAAAA','Open','Design','ZEBRA','1111','2222','Cold','3','5','Front Top- Left','7','2022-04-25','Yes','2022-04-12','2022-04-10',NULL,NULL,'3',90,'2','8','EC Fail'),(2,'[Carmera] Particle inside (R-cam)','Speaker Grill,Speaker grill pop out','33333333333333333BBBBBBBBBBBBBBBBBBBBBBBBB','Close','Process','PME','1122','3344','Cold','33','44','Bottom Left','15','2022-04-27','Yes','2022-04-18','2022-04-19',NULL,NULL,'3',90,'2','8','Known Fail (Open)'),(3,'[Bluetooth] No function','','Bluetooth does not get MAC address','Monitor','Component','ZEBRA','1234','4568','Cold','23','32','Bottom Left','7','','No','','',NULL,NULL,'3',90,'2','8','Known Fail (Close)'),(4,'[Battery] Thermal issue','NFC, No function, NFC flex was cracked','前山极远碧云合,清夜一声白雪微','Close','Design','Wistron','5678','9876','Room','44','45','','','2022-05-06','Yes','2022-05-16','2022-03-03',NULL,NULL,'4',95,'3','14','Fail'),(5,'[Battery] Latch stuck','Keypad, Damaged, Keypad boss crack','欲寄相思千里月，溪边残照雨霏霏。','Open','Component','Intel','9876','8745','Room','55','54','','','2022-05-03','Yes','2022-05-12','2022-05-18',NULL,NULL,'4',95,'3','14','Fail'),(6,'[Battery] Pop out','Audio, No function, Receiver has no function','11111111111111111','','','','','','Room','','','','','','','','',NULL,NULL,'7',185,'5','47','Fail'),(7,'[Carmera] Flicker screen (F-cam)','','RRRRRRRRRRRRRRRRRRRRRRRR','Open','Design','','','','Room','','','','','2022-06-08','Yes','2022-06-20','2022-05-11',NULL,NULL,'7',185,'5','47','EC Fail'),(8,'[Sealing] Vacuum test fail','','HHHHHHHHHHHHHHHHHHHH','Closed','','PE','','','Room','','','Front Bottom- Left','10','2022-06-01','Yes','2022-04-22','2022-05-04',NULL,NULL,'7',185,'5','47','Known Fail (Close)');
/*!40000 ALTER TABLE `fail_infomation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-08 14:58:35
