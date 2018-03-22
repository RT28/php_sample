-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 21, 2016 at 02:14 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

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
-- Table structure for table `free_counselling_sessions`
--

DROP TABLE IF EXISTS `free_counselling_sessions`;
CREATE TABLE IF NOT EXISTS `free_counselling_sessions` (
  `id` int(11) NOT NULL,
  `skype_id` varchar(50) DEFAULT NULL,
  `student_id` int(11) NOT NULL,
  `srm_id` int(11) DEFAULT NULL,
  `consultant_id` int(11) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` int(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `free_counselling_sessions`
--

INSERT INTO `free_counselling_sessions` (`id`, `skype_id`, `student_id`, `srm_id`, `consultant_id`, `start_time`, `end_time`, `status`, `created_by`, `updated_at`, `updated_by`, `created_at`) VALUES
(1, 'rddh', 6, 3, NULL, '2016-12-23 11:00:00', '2016-12-23 12:00:00', 0, 6, '2016-12-21 10:38:44', 6, '2016-12-21 10:38:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `free_counselling_sessions`
--
ALTER TABLE `free_counselling_sessions`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`), ADD KEY `srm_id` (`srm_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `free_counselling_sessions`
--
ALTER TABLE `free_counselling_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `free_counselling_sessions`
--
ALTER TABLE `free_counselling_sessions`
ADD CONSTRAINT `free_counselling_sessions user_login foreign key` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
