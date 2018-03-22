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
-- Table structure for table `partner_assignedwork_history`
--

CREATE TABLE `partner_assignedwork_history` (
  `id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `parent_employee_id` int(11) NOT NULL,
  `assignedwork_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `comments` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partner_assignedwork_history`
--

INSERT INTO `partner_assignedwork_history` (`id`, `consultant_id`, `parent_employee_id`, `assignedwork_id`, `status`, `comments`, `created_at`, `created_by`) VALUES
(1, 3, 4, 1, 0, 'test', '2017-09-05 12:37:28', 'iyad-partner_login');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partner_assignedwork_history`
--
ALTER TABLE `partner_assignedwork_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultant_id` (`consultant_id`),
  ADD KEY `assignedwork_id` (`assignedwork_id`),
  ADD KEY `parent_employee_id` (`parent_employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partner_assignedwork_history`
--
ALTER TABLE `partner_assignedwork_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `partner_assignedwork_history`
--
ALTER TABLE `partner_assignedwork_history`
  ADD CONSTRAINT `partner_assignedwork_history_ibfk_1` FOREIGN KEY (`consultant_id`) REFERENCES `consultant` (`consultant_id`),
  ADD CONSTRAINT `partner_assignedwork_history_ibfk_2` FOREIGN KEY (`assignedwork_id`) REFERENCES `student_partneremployee_relation` (`id`),
  ADD CONSTRAINT `partner_assignedwork_history_ibfk_3` FOREIGN KEY (`parent_employee_id`) REFERENCES `partner_employee` (`partner_login_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
