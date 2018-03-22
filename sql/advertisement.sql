-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2017 at 12:54 PM
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
-- Table structure for table `advertisement`
--

CREATE TABLE `advertisement` (
  `id` int(11) NOT NULL,
  `pagename` varchar(255) NOT NULL,
  `imagetitle` varchar(255) NOT NULL,
  `imageadvert` varchar(255) NOT NULL,
  `advertisementcode` text,
  `rank` int(5) NOT NULL,
  `section` varchar(10) NOT NULL,
  `height` int(5) NOT NULL,
  `width` int(5) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `timing` int(10) NOT NULL,
  `redirectlink` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `advertisement`
--

INSERT INTO `advertisement` (`id`, `pagename`, `imagetitle`, `imageadvert`, `advertisementcode`, `rank`, `section`, `height`, `width`, `startdate`, `enddate`, `timing`, `redirectlink`, `status`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'university', 'Test', 'ad1495883623.gif', 'Test', 1, 'right', 150, 150, '2017-05-29', '2017-08-31', 600, 'http://www.stanford.edu/', 1, '2017-05-27 11:13:43', 'admin-employee_login', '2017-05-29 10:25:01', 'admin-employee_login'),
(2, 'university', 'Test 2', 'ad14956279181496053087.gif', '', 2, 'right', 150, 150, '2017-05-28', '2018-06-30', 600, 'http://www.stanford.edu/', 1, '2017-05-29 10:18:07', 'admin-employee_login', '2017-05-29 10:25:10', 'admin-employee_login'),
(3, 'university', 'Test 3', 'P41496053203.jpg', '', 3, 'right', 150, 150, '2017-05-29', '2017-05-31', 600, 'http://www.stanford.edu/', 1, '2017-05-29 10:20:03', 'admin-employee_login', '2017-05-29 10:25:21', 'admin-employee_login'),
(4, 'programfinder', 'Program Ad 1', 'ad14956279181496054743.gif', '', 1, 'right', 300, 300, '2017-05-28', '2017-06-30', 600, 'http://www.stanford.edu/', 1, '2017-05-29 10:45:43', 'admin-employee_login', '2017-05-29 10:49:57', 'admin-employee_login'),
(5, 'programfinder', 'Program Ad 2', 'article-11496054793.jpg', '', 2, 'right', 120, 150, '2017-05-28', '2017-06-30', 600, 'http://www.stanford.edu/', 1, '2017-05-29 10:46:33', 'admin-employee_login', '2017-05-29 10:46:33', '1'),
(6, 'programfinder', 'Program Ad 3', 'ad14956279181496054831.gif', '', 3, 'top', 120, 120, '2017-05-28', '2017-06-30', 600, 'http://www.stanford.edu/', 1, '2017-05-29 10:47:10', 'admin-employee_login', '2017-05-29 10:47:11', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `advertisement`
--
ALTER TABLE `advertisement`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `advertisement`
--
ALTER TABLE `advertisement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
