-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 05, 2017 at 02:47 PM
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
-- Table structure for table `student_partneremployee_relation`
--

CREATE TABLE `student_partneremployee_relation` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `parent_employee_id` int(11) NOT NULL,
  `access_list` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `comment_by_consultant` text NOT NULL,
  `assigned_work_status` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_partneremployee_relation`
--

INSERT INTO `student_partneremployee_relation` (`id`, `student_id`, `consultant_id`, `parent_employee_id`, `access_list`, `start_date`, `end_date`, `comment_by_consultant`, `assigned_work_status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 2, 3, 4, '1,2,3', '2017-09-05', '2017-09-30', 'test', 0, '2017-09-05 12:37:28', 'iyad-partner_login', '2017-09-05 12:37:28', 'iyad-partner_login');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_partneremployee_relation`
--
ALTER TABLE `student_partneremployee_relation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_employee_id` (`parent_employee_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `consultant_id` (`consultant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_partneremployee_relation`
--
ALTER TABLE `student_partneremployee_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_partneremployee_relation`
--
ALTER TABLE `student_partneremployee_relation`
  ADD CONSTRAINT `student_partneremployee_relation_ibfk_1` FOREIGN KEY (`parent_employee_id`) REFERENCES `partner_login` (`id`),
  ADD CONSTRAINT `student_partneremployee_relation_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `student` (`student_id`),
  ADD CONSTRAINT `student_partneremployee_relation_ibfk_3` FOREIGN KEY (`consultant_id`) REFERENCES `consultant` (`consultant_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
