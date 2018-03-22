-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2016 at 10:18 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `collegexperts`
--

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` int(100) NOT NULL,
  `country` int(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `parent_email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `srm` int(11) NOT NULL,
  `consultant` int(11) NOT NULL,
  `package` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `city` (`city`),
  KEY `city_2` (`city`),
  KEY `city_3` (`city`),
  KEY `country` (`country`),
  KEY `state` (`state`),
  KEY `student_id` (`student_id`),
  KEY `srm` (`srm`,`consultant`,`package`),
  KEY `srm_2` (`srm`,`consultant`,`package`),
  KEY `consultant` (`consultant`,`package`),
  KEY `consultant_2` (`consultant`,`package`),
  KEY `package` (`package`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `student_id`, `first_name`, `last_name`, `nationality`, `date_of_birth`, `gender`, `address`, `street`, `city`, `state`, `country`, `pincode`, `email`, `parent_email`, `phone`, `parent_phone`, `created_by`, `updated_by`, `created_at`, `updated_at`, `srm`, `consultant`, `package`) VALUES
(8, 4, 'John', 'Doe', 'Indian', '1992-10-13', 'M', 'Address', 'Streeet', 'Mumbai', 3, 4, '124587', 'gotouniversity.super@gmail.com', 'gotouniversity.super@gmail.com', '48789856', '48789856', NULL, NULL, '2016-10-11 03:31:45', '2016-10-11 03:31:45', 1, 2, 3),
(10, 5, 'Student', 'Gotouniversity', 'Indian', '1989-03-15', 'M', 'Address', 'Streeet', 'Mumbai', 3, 4, '400089', 'gotouniversity.student@gmail.com', 'gotouniversity.student@gmail.com', '48789856', '12345678', NULL, NULL, '2016-10-11 09:24:44', '2016-10-11 09:24:44', 1, 2, 2),
(11, 6, 'Riddhi', 'T', 'Indian', '2010-06-01', 'M', 'Address', 'Streeet', 'Mumbai', 3, 4, '124587', 'rddh2804@gmail.com', 'gotouniversity.super@gmail.com', '48789856', '12345678', NULL, NULL, '2016-10-11 18:57:41', '2016-10-11 18:57:41', 3, 1, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_3` FOREIGN KEY (`package`) REFERENCES `package_type` (`id`),
  ADD CONSTRAINT `country` FOREIGN KEY (`country`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `state` FOREIGN KEY (`state`) REFERENCES `state` (`id`),
  ADD CONSTRAINT `student foreign key` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`),
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`srm`) REFERENCES `srm` (`id`),
  ADD CONSTRAINT `student_ibfk_2` FOREIGN KEY (`consultant`) REFERENCES `consultant` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
