-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 19, 2016 at 10:30 AM
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
-- Table structure for table `featured_universities`
--

CREATE TABLE IF NOT EXISTS `featured_universities` (
  `id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `featured_universities`
--

INSERT INTO `featured_universities` (`id`, `university_id`, `rank`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 72, 1, 1, 1, '2016-12-19 07:13:41', '2016-12-19 07:13:41'),
(2, 129, 2, 1, 1, '2016-12-19 07:13:58', '2016-12-19 07:13:58'),
(3, 5, 3, 1, 1, '2016-12-19 07:14:18', '2016-12-19 07:14:18'),
(4, 2, 4, 1, 1, '2016-12-19 07:14:27', '2016-12-19 07:14:27'),
(5, 49, 5, 1, 1, '2016-12-19 07:14:37', '2016-12-19 07:14:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `featured_universities`
--
ALTER TABLE `featured_universities`
  ADD PRIMARY KEY (`id`), ADD KEY `university_id` (`university_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `featured_universities`
--
ALTER TABLE `featured_universities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `featured_universities`
--
ALTER TABLE `featured_universities`
ADD CONSTRAINT `featured_universities university foreign key` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
