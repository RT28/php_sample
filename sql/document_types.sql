/*
SQLyog Community v12.09 (32 bit)
MySQL - 10.1.19-MariaDB : Database - gotouniv_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`gotouniv_db` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `gotouniv_db`;

/*Table structure for table `document_types` */

DROP TABLE IF EXISTS `document_types`;

CREATE TABLE `document_types` (
  `document_id` int(11) NOT NULL AUTO_INCREMENT,
  `document_name` varchar(255) DEFAULT NULL,
  `document_status` enum('1','0') DEFAULT '1',
  PRIMARY KEY (`document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `document_types` */

insert  into `document_types`(`document_id`,`document_name`,`document_status`) values (1,'High School Transcripts','1'),(2,'Undergraduate Degree','1'),(3,'Master Degree','1'),(4,'Undergraduate Transcripts','1'),(5,'Master Transcripts','1'),(6,'CV/Resume','1'),(7,'Personal Statement','1'),(8,'College Essay 1','1'),(9,'College Essay 2','1'),(10,'College Essay 3','1'),(11,'Passport Copy','1'),(12,'IELTS/TOEFL Report','1'),(13,'Visa Copy','1'),(14,'Bank Letter','1'),(15,'Teacher Recommendation Letter 1','1'),(16,'Teacher Recommendation Letter 2','1'),(17,'Miscellaneous','1'),(18,'Course description/ syllabus (for transfer students)','1'),(19,'Standardized Test Score Report','1'),(20,'Financial statement form/ Financial affidavit of support (University specific)','1'),(21,'Bank statement for UK applications','1'),(22,'Medical release form','1'),(23,'No objection certificate','1'),(24,'Counselor recommendation letter','1'),(25,'School profile','1');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
