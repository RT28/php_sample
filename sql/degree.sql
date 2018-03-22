-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2016 at 12:16 PM
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
-- Table structure for table `degree`
--

CREATE TABLE IF NOT EXISTS `degree` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(30) NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`id`, `name`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Agriculture & Veterniary', 'admin-employee_login', '2016-11-30 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(2, 'Ethnic Studies', 'srm-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(3, 'Sciences', 'editor-employee_logi', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(4, 'Visual & Performing Arts', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(5, 'Education', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(6, 'Engineering', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(7, 'Engineering-Related Technology', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(8, 'English & Literature', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(9, 'General & Interdisciplinary Studies', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(10, 'Military Science & Protective Services', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(11, 'Foreign Languages', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(12, 'Parks & Recreation Resources', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(13, 'Philosophy, Religion, & Theology', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(14, 'Public Affairs & Law', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(15, 'Religious Affiliation', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(16, 'Social Sciences', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(17, 'Men''s Sprots', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(18, 'Women''s Sports', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(19, 'Medical & Allied health Care', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(20, 'Applied Sciences and Professions', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(21, 'Arts, Design and Architecture', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(22, 'Business & Management', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(23, 'Computer Science & IT', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(24, 'Environmental Studies & Earth Sciences', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(25, 'Hospitality, Leisure and Sports', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(26, 'Humanities', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(27, 'Journalism and Media', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(28, 'Natural Sciences and Matematics', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00'),
(30, 'test', 'admin-employee_login', '0000-00-00 00:00:00', 'admin-employee_login', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
