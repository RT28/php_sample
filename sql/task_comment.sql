-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2017 at 04:28 PM
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
-- Table structure for table `task_comment`
--

CREATE TABLE `task_comment` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `srm_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `action` int(5) NOT NULL,
  `status` int(5) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_comment`
--

INSERT INTO `task_comment` (`id`, `task_id`, `student_id`, `consultant_id`, `srm_id`, `comment`, `action`, `status`, `created_by`, `created_at`) VALUES
(1, 5, 10, 0, 0, 'test', 0, 2, 'student-user_login', '2017-07-05 10:40:20'),
(2, 5, 10, 0, 0, 'test', 1, 2, 'student-user_login', '2017-07-05 10:40:55'),
(3, 6, 10, 0, 0, 'Test ', 2, 0, 'student-user_login', '2017-07-05 10:43:19'),
(4, 5, 10, 0, 0, 'test', 0, 2, 'student-user_login', '2017-07-05 11:40:11'),
(5, 5, 10, 0, 0, 'test', 0, 2, 'student-user_login', '2017-07-05 11:40:54'),
(6, 4, 0, 0, 1, 'tes', 0, 0, 'kalyani@brighter-prep.com-partner_login', '2017-07-05 13:09:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_comment`
--
ALTER TABLE `task_comment`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_comment`
--
ALTER TABLE `task_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
