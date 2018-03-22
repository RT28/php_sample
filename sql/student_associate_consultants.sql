-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2017 at 01:54 AM
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
-- Table structure for table `student_associate_consultants`
--

CREATE TABLE `student_associate_consultants` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `parent_consultant_id` int(11) NOT NULL,
  `associate_consultant_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_associate_consultants`
--

INSERT INTO `student_associate_consultants` (`id`, `student_id`, `parent_consultant_id`, `associate_consultant_id`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(3, 5, 3, 4, 3, '2017-01-23 05:56:34', 3, '2017-01-23 05:56:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_associate_consultants`
--
ALTER TABLE `student_associate_consultants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `parent_consultant_id` (`parent_consultant_id`),
  ADD KEY `associate_consultant_id` (`associate_consultant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_associate_consultants`
--
ALTER TABLE `student_associate_consultants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_associate_consultants`
--
ALTER TABLE `student_associate_consultants`
  ADD CONSTRAINT `student_associate_consultant partner_login foreign_key` FOREIGN KEY (`parent_consultant_id`) REFERENCES `partner_login` (`id`),
  ADD CONSTRAINT `student_associate_consultant partner_login_1 foreign_key` FOREIGN KEY (`associate_consultant_id`) REFERENCES `partner_login` (`id`),
  ADD CONSTRAINT `student_associate_consultant user_login foreign_key` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
