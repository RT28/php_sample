-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2016 at 07:50 PM
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
-- Table structure for table `university_reviews_ratings`
--

CREATE TABLE IF NOT EXISTS `university_reviews_ratings` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `review` varchar(500) DEFAULT NULL,
  `rating` float NOT NULL,
  `favourite` int(1) DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `university_reviews_ratings`
--

INSERT INTO `university_reviews_ratings` (`id`, `student_id`, `university_id`, `review`, `rating`, `favourite`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 5, 1, 'Test Review', 4, 0, 5, '2016-11-21 18:57:00', 5, '2016-11-23 18:49:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `university_reviews_ratings`
--
ALTER TABLE `university_reviews_ratings`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `student_id_2` (`student_id`,`university_id`), ADD KEY `student_id` (`student_id`), ADD KEY `university_id` (`university_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `university_reviews_ratings`
--
ALTER TABLE `university_reviews_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `university_reviews_ratings`
--
ALTER TABLE `university_reviews_ratings`
ADD CONSTRAINT `university review student foreign key` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`),
ADD CONSTRAINT `university review university foreign key` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
