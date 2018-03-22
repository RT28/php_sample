-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2016 at 09:36 PM
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
-- Table structure for table `course_reviews_ratings`
--

CREATE TABLE IF NOT EXISTS `course_reviews_ratings` (
  `id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `university_id` int(10) NOT NULL,
  `rating` int(11) NOT NULL,
  `review` varchar(500) DEFAULT NULL,
  `favourite` int(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_reviews_ratings`
--

INSERT INTO `course_reviews_ratings` (`id`, `student_id`, `course_id`, `university_id`, `rating`, `review`, `favourite`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 5, 280, 1, 4, 'Course Rating test 1', 1, '2016-11-23 20:24:27', 5, '2016-11-23 20:27:21', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_reviews_ratings`
--
ALTER TABLE `course_reviews_ratings`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`), ADD KEY `course_id` (`course_id`), ADD KEY `university_id` (`university_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_reviews_ratings`
--
ALTER TABLE `course_reviews_ratings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `course_reviews_ratings`
--
ALTER TABLE `course_reviews_ratings`
ADD CONSTRAINT `course_reviews_ratings_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `university_course_list` (`id`),
ADD CONSTRAINT `course_reviews_ratings_ibfk_3` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`),
ADD CONSTRAINT `student_favourite_courses_users_foreign_key` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
