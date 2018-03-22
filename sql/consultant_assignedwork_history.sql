-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2017 at 04:19 PM
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
-- Table structure for table `consultant_assignedwork_history`
--

CREATE TABLE `consultant_assignedwork_history` (
  `id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `assignedwork_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `comments` text NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultant_assignedwork_history`
--

INSERT INTO `consultant_assignedwork_history` (`id`, `consultant_id`, `assignedwork_id`, `status`, `comments`, `created_at`, `created_by`) VALUES
(1, 9, 17, 0, 'test', '2017-09-04 10:30:37', 'iyad-partner_login'),
(5, 9, 15, 0, 'test', '2017-09-04 10:44:53', 'iyad-partner_login'),
(6, 10, 12, 0, 'aaaaaaaa', '2017-09-04 10:45:53', 'sara123-partner_login'),
(7, 10, 11, 2, 'Done. Mail sent', '2017-09-04 13:46:07', 'sara123-partner_login'),
(8, 10, 11, 2, 'done', '2017-09-04 13:47:23', 'sara123-partner_login'),
(9, 10, 12, 2, 'done', '2017-09-04 13:47:45', 'sara123-partner_login');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultant_assignedwork_history`
--
ALTER TABLE `consultant_assignedwork_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `consultant_id` (`consultant_id`),
  ADD KEY `assignedwork_id` (`assignedwork_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultant_assignedwork_history`
--
ALTER TABLE `consultant_assignedwork_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultant_assignedwork_history`
--
ALTER TABLE `consultant_assignedwork_history`
  ADD CONSTRAINT `consultant_assignedwork_history_ibfk_1` FOREIGN KEY (`consultant_id`) REFERENCES `student_consultant_relation` (`consultant_id`),
  ADD CONSTRAINT `consultant_assignedwork_history_ibfk_2` FOREIGN KEY (`assignedwork_id`) REFERENCES `student_consultant_relation` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
