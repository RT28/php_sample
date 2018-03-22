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
-- Table structure for table `associate_consultants`
--

CREATE TABLE `associate_consultants` (
  `id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `parent_consultant_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `associate_consultants`
--

INSERT INTO `associate_consultants` (`id`, `consultant_id`, `parent_consultant_id`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 4, 3, '2017-01-23 03:07:27', 3, '2017-01-23 03:07:27', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `associate_consultants`
--
ALTER TABLE `associate_consultants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultant_id` (`consultant_id`),
  ADD KEY `parent_consultant_id` (`parent_consultant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `associate_consultants`
--
ALTER TABLE `associate_consultants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `associate_consultants`
--
ALTER TABLE `associate_consultants`
  ADD CONSTRAINT `associate_consultants partner_login foreign key` FOREIGN KEY (`consultant_id`) REFERENCES `partner_login` (`id`),
  ADD CONSTRAINT `associate_consultants partner_login foreign key 1` FOREIGN KEY (`parent_consultant_id`) REFERENCES `partner_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
