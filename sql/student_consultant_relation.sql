-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2017 at 05:12 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

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
-- Table structure for table `student_consultant_relation`
--

CREATE TABLE `student_consultant_relation` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` int(11) NOT NULL,
  `updated_by` datetime NOT NULL,
  `parent_consultant_id` int(11) NOT NULL,
  `is_sub_consultant` tinyint(1) NOT NULL,
  `access_list` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `comment_by_consultant` text NOT NULL,
  `assigned_work_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_consultant_relation`
--

INSERT INTO `student_consultant_relation` (`id`, `student_id`, `consultant_id`, `created_by`, `created_at`, `updated_at`, `updated_by`, `parent_consultant_id`, `is_sub_consultant`, `access_list`, `start_date`, `end_date`, `comment_by_consultant`, `assigned_work_status`) VALUES
(1, 8, 3, 1, '2017-08-06 11:13:56', 2017, '0000-00-00 00:00:00', 0, 0, '', '0000-00-00', '0000-00-00', '', 0),
(2, 2, 3, 1, '2017-08-06 11:14:02', 2017, '0000-00-00 00:00:00', 0, 0, '', '0000-00-00', '0000-00-00', '', 0),
(3, 3, 3, 1, '2017-08-06 11:14:09', 2017, '0000-00-00 00:00:00', 0, 0, '', '0000-00-00', '0000-00-00', '', 0),
(4, 4, 3, 1, '2017-08-06 11:14:15', 2017, '0000-00-00 00:00:00', 0, 0, '', '0000-00-00', '0000-00-00', '', 0),
(5, 5, 3, 1, '2017-08-06 11:14:21', 2017, '0000-00-00 00:00:00', 0, 0, '', '0000-00-00', '0000-00-00', '', 0),
(6, 6, 3, 1, '2017-08-06 11:14:28', 2017, '0000-00-00 00:00:00', 0, 0, '', '0000-00-00', '0000-00-00', '', 0),
(7, 7, 3, 1, '2017-08-06 11:14:33', 2017, '0000-00-00 00:00:00', 0, 0, '', '0000-00-00', '0000-00-00', '', 0),
(8, 9, 9, 5, '2017-08-07 11:17:13', 2017, '0000-00-00 00:00:00', 0, 0, '', '0000-00-00', '0000-00-00', '', 0),
(9, 10, 3, 5, '2017-08-15 12:05:04', 2017, '0000-00-00 00:00:00', 0, 0, '', '0000-00-00', '0000-00-00', '', 0),
(10, 10, 9, 0, '2017-08-27 12:37:15', 2017, '0000-00-00 00:00:00', 3, 1, '1,2,3', '2017-08-29', '2017-09-08', 'tesr', 0),
(11, 3, 10, 0, '2017-08-27 12:59:27', 2017, '0000-00-00 00:00:00', 3, 1, '1,2,3', '2017-08-29', '2017-08-30', 'cxccx', 1),
(12, 2, 10, 0, '2017-08-27 12:46:49', 2017, '0000-00-00 00:00:00', 3, 1, '1,2,3', '2017-08-30', '2017-09-01', 'czc', 0),
(13, 3, 11, 0, '2017-08-27 13:21:16', 2017, '0000-00-00 00:00:00', 3, 1, '1,2,3', '2017-08-28', '2017-10-31', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_consultant_relation`
--
ALTER TABLE `student_consultant_relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `consultant_id` (`consultant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_consultant_relation`
--
ALTER TABLE `student_consultant_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_consultant_relation`
--
ALTER TABLE `student_consultant_relation`
  ADD CONSTRAINT `student_consultant_relation_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`),
  ADD CONSTRAINT `student_consultant_relation_ibfk_2` FOREIGN KEY (`consultant_id`) REFERENCES `partner_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
