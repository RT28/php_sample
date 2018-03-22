-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 02, 2017 at 04:37 PM
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
-- Table structure for table `partner_employee`
--

CREATE TABLE `partner_employee` (
  `id` int(11) NOT NULL,
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
  `work_days` varchar(15) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 
--
-- Indexes for table `partner_employee`
--
ALTER TABLE `partner_employee`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_login_id` (`partner_login_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partner_employee`
--
ALTER TABLE `partner_employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `partner_employee`
--
ALTER TABLE `partner_employee`
  ADD CONSTRAINT `partner_employee_ibfk_1` FOREIGN KEY (`partner_login_id`) REFERENCES `partner_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
