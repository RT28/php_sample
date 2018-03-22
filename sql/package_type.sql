-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2016 at 11:32 AM
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
-- Table structure for table `package_type`
--

CREATE TABLE IF NOT EXISTS `package_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `status` int(1) DEFAULT '1',
  `rank` int(11) NOT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(20) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `package_type`
--

INSERT INTO `package_type` (`id`, `name`, `description`, `status`, `rank`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'MBA Packages', NULL, 1, 1, '1', '2016-11-02 12:10:46', '1', '2016-11-02 12:47:26'),
(2, 'Undegraduate Packages', NULL, 1, 2, '1', '2016-11-02 12:22:56', '1', '2016-11-02 12:22:56'),
(3, 'Medicine Packages', NULL, 1, 3, '1', '2016-11-02 12:23:10', '1', '2016-11-02 12:23:10'),
(4, 'Graduate Packages', NULL, 1, 4, '1', '2016-11-02 12:23:23', '1', '2016-11-02 12:23:23'),
(5, 'Foundation Packages', NULL, 1, 5, '1', '2016-11-02 12:23:32', '1', '2016-11-02 12:23:32'),
(6, 'bffdbfdb', NULL, 0, 6, '1', '2016-11-02 12:31:28', '1', '2016-11-02 12:31:28'),
(7, 'tets', NULL, 1, 1, 'admin-employee_login', '2016-12-01 10:30:27', 'admin-employee_login', '2016-12-01 10:30:27');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
