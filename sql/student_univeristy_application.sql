-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2017 at 11:56 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gotouniv_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `student_univeristy_application`
--

CREATE TABLE `student_univeristy_application` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `srm_id` int(11) NOT NULL,
  `consultant_id` int(11) DEFAULT NULL,
  `university_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `start_term` varchar(50) NOT NULL,
  `status` int(2) DEFAULT '0',
  `remarks` varchar(500) DEFAULT NULL,
  `summary` text,
  `active` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `updated_by_role` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_univeristy_application`
--
ALTER TABLE `student_univeristy_application`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `srm_id` (`srm_id`),
  ADD KEY `consultant_id` (`consultant_id`),
  ADD KEY `university_id` (`university_id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `status_2` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_univeristy_application`
--
ALTER TABLE `student_univeristy_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_univeristy_application`
--
ALTER TABLE `student_univeristy_application`
  ADD CONSTRAINT `student_university_application user_login foreign key` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
