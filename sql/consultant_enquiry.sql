-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 25, 2017 at 11:22 AM
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
-- Table structure for table `consultant_enquiry`
--

CREATE TABLE `consultant_enquiry` (
  `id` int(11) NOT NULL,
  `title` tinyint(1) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `code` int(5) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `country_id` int(11) NOT NULL,
  `speciality` varchar(500) DEFAULT NULL,
  `description` text,
  `experience` int(11) NOT NULL,
  `skills` varchar(500) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `comment` text NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultant_enquiry`
--

INSERT INTO `consultant_enquiry` (`id`, `title`, `first_name`, `last_name`, `email`, `gender`, `code`, `mobile`, `country_id`, `speciality`, `description`, `experience`, `skills`, `status`, `comment`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kalyani', 'Verma', 'kalyani@gotouniversity.com', 'F', 91, '123456789', 83, '21,22', 'asas', 12, 'asasas', 1, 'Done ', NULL, NULL, '2017-07-25 08:17:30', '2017-07-25 08:17:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultant_enquiry`
--
ALTER TABLE `consultant_enquiry`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country` (`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultant_enquiry`
--
ALTER TABLE `consultant_enquiry`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
