-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2016 at 07:19 AM
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
-- Table structure for table `student_standard_test_detail`
--

DROP TABLE IF EXISTS `student_standard_test_detail`;
CREATE TABLE IF NOT EXISTS `student_standard_test_detail` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `verbal_score` int(11) DEFAULT NULL,
  `quantitative_score` int(11) DEFAULT NULL,
  `integrated_reasoning_score` int(11) DEFAULT NULL,
  `data_interpretation_score` int(11) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_standard_test_detail`
--

INSERT INTO `student_standard_test_detail` (`id`, `student_id`, `test_name`, `verbal_score`, `quantitative_score`, `integrated_reasoning_score`, `data_interpretation_score`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 'GRE', 50, 50, 50, 50, 4, 4, '2016-10-11 06:33:56', '2016-10-11 06:33:56'),
(2, 5, 'GRE', 100, 100, NULL, NULL, 5, 5, '2016-12-20 05:46:34', '2016-12-20 05:46:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_standard_test_detail`
--
ALTER TABLE `student_standard_test_detail`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_standard_test_detail`
--
ALTER TABLE `student_standard_test_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_standard_test_detail`
--
ALTER TABLE `student_standard_test_detail`
ADD CONSTRAINT `student_foreign_key_2` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
