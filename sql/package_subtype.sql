-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2016 at 11:41 AM
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
-- Table structure for table `package_subtype`
--

CREATE TABLE IF NOT EXISTS `package_subtype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `package_type_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `limit_count` int(11) NOT NULL,
  `fees` int(11) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `currency` int(11) NOT NULL,
  `limit_type` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `rank` int(11) NOT NULL,
  `package_offerings` varchar(100) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_type_id` (`package_type_id`),
  KEY `currency` (`currency`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `package_subtype`
--

INSERT INTO `package_subtype` (`id`, `package_type_id`, `name`, `limit_count`, `fees`, `description`, `currency`, `limit_type`, `status`, `rank`, `package_offerings`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Hourly Package', 1, 250, 'Customize your package', 1, 1, 1, 1, '1,2,3,4,5,6,7,8', '1', '1', '2016-11-02 13:49:34', '2016-11-02 13:49:34'),
(2, 1, '5 Hours Package', 5, 1100, '5 Hours of consulting', 1, 1, 1, 2, '1,3,4,5,7,8,9,15', '1', '1', '2016-11-02 14:36:11', '2016-11-02 14:36:11'),
(3, 1, 'School Package - 1 school', 1, 2900, 'School Package - 1 school', 1, 2, 1, 3, '1,3,4,5,7,8,9,15', '1', '1', '2016-11-02 14:37:29', '2016-11-02 14:37:29'),
(4, 1, 'School Package - 2 schools', 2, 3500, 'School Package - 2 schools', 1, 2, 1, 3, '1,3,4,5,7,8,9,15', '1', '1', '2016-11-02 14:37:29', '2016-11-02 14:37:29'),
(5, 1, 'School Package - 3 schools', 3, 4100, 'School Package - 3 schools', 1, 2, 1, 3, '1,3,4,5,7,8,9,15', '1', '1', '2016-11-02 14:37:29', '2016-11-02 14:37:29'),
(6, 1, 'School Package - 4 schools', 4, 4700, 'School Package - 4 schools', 1, 2, 1, 3, '1,3,4,5,7,8,9,15', '1', '1', '2016-11-02 14:37:29', '2016-11-02 14:37:29'),
(7, 1, 'School Package - 5 schools', 5, 5300, 'School Package - 5 schools', 1, 2, 1, 3, '1,3,4,5,7,8,9,15', '1', '1', '2016-11-02 14:37:29', '2016-11-02 14:37:29'),
(9, 2, 'test', 3, 2, 'test', 1, 1, 1, 1, '3', 'admin-employee_login', 'admin-employee_login', '2016-12-01 10:40:53', '2016-12-01 10:40:53');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `package_subtype`
--
ALTER TABLE `package_subtype`
  ADD CONSTRAINT `currency package subtype fk` FOREIGN KEY (`currency`) REFERENCES `currency` (`id`),
  ADD CONSTRAINT `package type fk` FOREIGN KEY (`package_type_id`) REFERENCES `package_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
