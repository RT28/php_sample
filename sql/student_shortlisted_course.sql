-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2016 at 09:34 AM
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
-- Table structure for table `student_shortlisted_course`
--

CREATE TABLE IF NOT EXISTS `student_shortlisted_course` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_shortlisted_course`
--
ALTER TABLE `student_shortlisted_course`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`), ADD KEY `university_id` (`university_id`), ADD KEY `course_id` (`course_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_shortlisted_course`
--
ALTER TABLE `student_shortlisted_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_shortlisted_course`
--
ALTER TABLE `student_shortlisted_course`
ADD CONSTRAINT `student_shortlisted_course university foreign key` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`),
ADD CONSTRAINT `student_shortlisted_course university_course_list foreign key` FOREIGN KEY (`course_id`) REFERENCES `university_course_list` (`id`),
ADD CONSTRAINT `student_shortlisted_course user_login foreign key` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
