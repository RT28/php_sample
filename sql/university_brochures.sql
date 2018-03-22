-- phpMyAdmin SQL Dump
-- version 4.0.10.7
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 17, 2017 at 05:13 AM
-- Server version: 5.5.47-cll
-- PHP Version: 5.4.31

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
-- Table structure for table `university_brochures`
--

CREATE TABLE IF NOT EXISTS `university_brochures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `university_id` int(11) NOT NULL,
  `document_type` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `active` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `reviewed_by` int(11) NOT NULL,
  `reviewed_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=4 ;

--
-- Dumping data for table `university_brochures`
--

INSERT INTO `university_brochures` (`id`, `university_id`, `document_type`, `title`, `filename`, `status`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`, `reviewed_by`, `reviewed_at`) VALUES
(1, 58, 'brouchres', 'Brochures', '732_University Dashboard.docx', 1, 1, 1, '2017-05-13 13:27:23', 0, '0000-00-00 00:00:00', 1, '2017-05-13 13:27:41'),
(2, 58, 'university_application', 'University Application', '745_Automated Counselor allocation to Student  Logic.docx', 1, 1, 1, '2017-05-13 13:27:23', 0, '0000-00-00 00:00:00', 1, '2017-05-13 13:27:41'),
(3, 58, 'other', 'Others', '615_University Dashboard.docx', 1, 1, 1, '2017-05-13 13:27:23', 0, '0000-00-00 00:00:00', 1, '2017-05-13 13:27:41');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
