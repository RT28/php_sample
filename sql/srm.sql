-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2016 at 06:10 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gotouniv_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `srm`
--

CREATE TABLE IF NOT EXISTS `srm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `srm_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `country` int(11) NOT NULL,
  `speciality` varchar(500) DEFAULT NULL,
  `description` text,
  `experience` int(11) NOT NULL,
  `skills` varchar(500) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country`),
  KEY `srm_id` (`srm_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `srm`
--

INSERT INTO `srm` (`id`, `srm_id`, `name`, `email`, `gender`, `mobile`, `country`, `speciality`, `description`, `experience`, `skills`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 3, 'John', 'john_papa@gmail.com', 'M', '456465568', 1, 'Essay, US Universities', NULL, 3, NULL, NULL, NULL, '2016-10-03 06:41:38', '2016-10-03 06:41:38');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `srm`
--
ALTER TABLE `srm`
  ADD CONSTRAINT `srm_ibfk_2` FOREIGN KEY (`srm_id`) REFERENCES `employee_login` (`id`),
  ADD CONSTRAINT `srm_ibfk_1` FOREIGN KEY (`country`) REFERENCES `employee_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
