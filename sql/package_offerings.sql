-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2016 at 06:49 PM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `collegexperts`
--

-- --------------------------------------------------------

--
-- Table structure for table `package_offerings`
--

CREATE TABLE IF NOT EXISTS `package_offerings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package_offerings`
--

INSERT INTO `package_offerings` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Selection of School', '', 1, '2016-11-02 12:48:45', '2016-11-02 12:48:45', 1, 1),
(2, 'Essay Editing', '', 1, '2016-11-02 12:50:07', '2016-11-02 12:50:07', 1, 1),
(3, 'GMAT Test Strategy', '', 1, '2016-11-02 12:50:17', '2016-11-02 12:50:17', 1, 1),
(4, 'CV/Resume', '', 1, '2016-11-02 12:50:27', '2016-11-02 12:50:27', 1, 1),
(5, 'Personal Statement', '', 1, '2016-11-02 12:50:39', '2016-11-02 12:50:39', 1, 1),
(6, 'Rejection Review', '', 1, '2016-11-02 12:50:47', '2016-11-02 12:50:47', 1, 1),
(7, 'Interview Prep', '', 1, '2016-11-02 12:50:56', '2016-11-02 12:50:56', 1, 1),
(8, 'Reference Letters', '', 1, '2016-11-02 12:51:07', '2016-11-02 12:51:07', 1, 1),
(9, 'Essay Brainstorming', '', 1, '2016-11-02 12:51:41', '2016-11-02 12:51:41', 1, 1),
(10, 'SAT/ACT Test Strategy', '', 1, '2016-11-02 12:52:01', '2016-11-02 12:52:01', 1, 1),
(11, 'Application Guidance', '', 1, '2016-11-02 12:52:22', '2016-11-02 12:52:22', 1, 1),
(12, 'UCAS advice', '', 1, '2016-11-02 12:52:52', '2016-11-02 12:52:52', 1, 1),
(13, 'Test Strategy', '', 1, '2016-11-02 12:53:02', '2016-11-02 12:53:02', 1, 1),
(14, 'Interview/MMI Prep', '', 1, '2016-11-02 12:53:19', '2016-11-02 12:53:19', 1, 1),
(15, 'Extra Curricular review', '', 1, '2016-11-02 14:34:47', '2016-11-02 14:34:47', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `package_offerings`
--
ALTER TABLE `package_offerings`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `package_offerings`
--
ALTER TABLE `package_offerings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
