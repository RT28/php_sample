-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2016 at 07:04 AM
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
-- Table structure for table `student_favourite_courses`
--

CREATE TABLE IF NOT EXISTS `student_favourite_courses` (
  `id` int(10) NOT NULL,
  `student_id` int(10) NOT NULL,
  `course_id` int(10) NOT NULL,
  `university_id` int(10) NOT NULL,
  `favourite` int(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_favourite_courses`
--

INSERT INTO `student_favourite_courses` (`id`, `student_id`, `course_id`, `university_id`, `favourite`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 5, 280, 1, 0, 5, '2016-11-28 06:02:54', 5, '2016-11-28 06:02:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_favourite_courses`
--
ALTER TABLE `student_favourite_courses`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`), ADD KEY `course_id` (`course_id`), ADD KEY `university_id` (`university_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_favourite_courses`
--
ALTER TABLE `student_favourite_courses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_favourite_courses`
--
ALTER TABLE `student_favourite_courses`
ADD CONSTRAINT `student_favourite_courses_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `university_course_list` (`id`),
ADD CONSTRAINT `student_favourite_courses_ibfk_3` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`),
ADD CONSTRAINT `student_favourite_courses_student_fk` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
