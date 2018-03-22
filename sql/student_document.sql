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

/*Table structure for table `student_document` */

DROP TABLE IF EXISTS `student_document`;

CREATE TABLE `student_document` (
  `student_document_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) DEFAULT NULL,
  `document_type_id` int(11) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_file` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`student_document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `student_document` */

insert  into `student_document`(`student_document_id`,`student_id`,`document_type_id`,`document_name`,`document_file`,`created_at`) values (1,5,5,'Test4','jpg','2017-03-17 15:05:31'),(2,5,2,'test','jpg','2017-03-17 15:07:46'),(3,5,6,'Pankaj','226_dimmy.jpg','2017-03-17 15:11:38');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
