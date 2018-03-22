-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2016 at 12:42 PM
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
-- Table structure for table `standard_tests`
--

CREATE TABLE IF NOT EXISTS `standard_tests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `test_category_id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `source` varchar(60) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `test_category_id` (`test_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `standard_tests`
--

INSERT INTO `standard_tests` (`id`, `test_category_id`, `name`, `source`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 'TOEFL', 'https://www.ets.org/toefl/', '2016-11-16 01:47:00', 1, '2016-11-16 01:48:00', 1),
(2, 2, 'IELTS', 'https://www.ielts.org/', '2016-11-16 01:48:00', 1, '2016-11-16 01:49:00', 1),
(3, 1, 'SAT', 'https://collegereadiness.collegeboard.org/sat', '2016-11-16 12:51:00', 1, '2016-11-16 12:52:00', 1),
(4, 1, 'ACT', 'www.act.org/the-act/testprep', '2016-11-16 12:51:00', 1, '2016-11-16 12:52:00', 1),
(5, 1, 'GRE', 'https://www.ets.org/gre/revised_general/about', '2016-11-17 12:51:00', 1, '2016-11-19 12:52:00', 1),
(6, 1, 'GMAT', 'www.gmat.com/', '2016-11-16 12:51:00', 1, '2016-11-16 12:58:00', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `standard_tests`
--
ALTER TABLE `standard_tests`
  ADD CONSTRAINT `standard_tests_ibfk_1` FOREIGN KEY (`test_category_id`) REFERENCES `test_category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
