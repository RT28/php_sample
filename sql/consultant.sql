-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2017 at 04:48 PM
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
-- Table structure for table `consultant`
--

CREATE TABLE `consultant` (
  `id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `parent_partner_login_id` int(11) NOT NULL,
  `partner_login_id` int(11) NOT NULL,
  `title` tinyint(1) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `code` int(5) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `country_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `pincode` int(5) NOT NULL,
  `address` varchar(255) NOT NULL,
  `speciality` varchar(500) DEFAULT NULL,
  `description` text,
  `experience` int(11) NOT NULL,
  `skills` varchar(500) DEFAULT NULL,
  `work_hours_start` varchar(20) NOT NULL,
  `work_hours_end` varchar(20) NOT NULL,
  `work_days` varchar(10) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultant`
--

INSERT INTO `consultant` (`id`, `consultant_id`, `parent_partner_login_id`, `partner_login_id`, `title`, `first_name`, `last_name`, `date_of_birth`, `email`, `gender`, `code`, `mobile`, `country_id`, `state_id`, `city_id`, `pincode`, `address`, `speciality`, `description`, `experience`, `skills`, `work_hours_start`, `work_hours_end`, `work_days`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 43, 43, 0, 1, 'Kalyani', 'Vera', '2017-07-25', 'kalyani@brighter-prep.com', 'f', 1, '', 1, 1, 1, 0, '', NULL, NULL, 0, NULL, '', '', '', NULL, NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 53, 0, 0, 3, 'Kalyani', 'Verma', '2017-07-25', 'kalyani1@brighter-prep.com', 'F', 355, '123456789', 4, 0, 0, 0, '', '20', '8888888', 8, '88888888', '', '', '', 53, 53, '2017-07-24 11:17:00', '2017-07-24 11:17:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultant`
--
ALTER TABLE `consultant`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country` (`country_id`),
  ADD KEY `consultant_id` (`consultant_id`),
  ADD KEY `parent_id` (`parent_partner_login_id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `city_id` (`city_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultant`
--
ALTER TABLE `consultant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultant`
--
ALTER TABLE `consultant`
  ADD CONSTRAINT `consultant_ibfk_1` FOREIGN KEY (`consultant_id`) REFERENCES `partner_login` (`id`),
  ADD CONSTRAINT `consultant_ibfk_2` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
