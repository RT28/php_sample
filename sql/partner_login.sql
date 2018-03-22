-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2016 at 07:40 AM
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
-- Table structure for table `partner_login`
--

CREATE TABLE IF NOT EXISTS `partner_login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `role_id` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partner_login`
--

INSERT INTO `partner_login` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `role_id`) VALUES
(1, 'university', 'Gp1GZ1WSp5idoXkvMRFxEgRgRW1VmwBm', '$2y$13$EgrnQmI2YepoIaNWlXgNuuo3uRlpOJgV9eFqS.MugIJIXTMGIW4EK', NULL, 'rddh@2804@gmail.com', 10, '2016-08-24 11:33:31', '2016-08-24 11:33:31', 1, 1, 5),
(2, 'partner', 'RtRKT7tBBob_z9tDtPHd1sh5_tJZU1Cn', '$2y$13$/fjoAazH/J9ygw6uKlU3PeWH9iv3vMR3Qc2WJy8JsdDEY.02kAvWm', NULL, 'gotouniversity.student@gmail.com', 10, '2016-08-24 11:34:33', '2016-08-24 11:34:33', 2, 2, 6),
(3, 'tiffany_grimsley', '_OVK75l_DqelSD7bfw4Uq-0exFCggu20', '$2y$13$ST1Cu0SsJ1tcBnVHc0MpEugfbqohcTvT3N6meYPClJ/nDet0zDO7K', 'bqm86obTavVo1ngu5OEH-ZzrsAeKCifY_1481536465', 'gotouniversity.super@gmail.com', 2, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `partner_login`
--
ALTER TABLE `partner_login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `partner_login`
--
ALTER TABLE `partner_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
