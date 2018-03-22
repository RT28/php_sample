-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2016 at 11:13 AM
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
-- Table structure for table `institute`
--

CREATE TABLE IF NOT EXISTS `institute` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(30) NOT NULL,
  `adress` varchar(200) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` varchar(20) NOT NULL,
  `tests_offered` varchar(20) NOT NULL,
  `contact_details` varchar(20) NOT NULL,
  `website` varchar(50) NOT NULL,
  `description` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country_id` (`country_id`,`state_id`,`city_id`),
  KEY `state_id` (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `institute`
--

INSERT INTO `institute` (`id`, `name`, `email`, `adress`, `country_id`, `state_id`, `city_id`, `tests_offered`, `contact_details`, `website`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(9, 'test Institute 1', 'institute@gmail.com', 'test', 4, 3, 'mumbai', '1,2', '8898851910', 'www.jamboreeindia.com/', 'test', '2016-11-30 11:36:53', 'admin-employee_login', '2016-11-30 11:36:53', 'admin-employee_login'),
(10, 'IMFS', 'info@imfs.co.in', '801, 8th floor, Diamond Plaza, Chabildas Road,', 4, 3, 'Dadar west', '2,1,5', '+91 22 24320102 / 04', 'www.imfs.co.in', 'The Institute of Management & Foreign Studies was founded in 1987, with the charter of providing students the option of studying abroad at the best of institutions. In 1987, that meant only one destination, America! And entry into the highly venerated universities in this Mecca of learning required students to fulfill many requirements, one of which is to do well in entrance examinations such as the GRE® (Graduate Record Examination) / GMAT® (Graduate Management Aptitude Test) / SAT® (Scholastic', '2016-12-01 05:54:17', 'admin-employee_login', '2016-12-01 05:54:17', 'admin-employee_login');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `institute`
--
ALTER TABLE `institute`
  ADD CONSTRAINT `institute_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `institute_ibfk_2` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
