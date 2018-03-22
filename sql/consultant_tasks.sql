-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2017 at 01:20 PM
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
-- Table structure for table `consultant_tasks`
--

CREATE TABLE `consultant_tasks` (
  `id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `task_category_id` int(11) NOT NULL,
  `task_list_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text,
  `due_date` date DEFAULT NULL,
  `comments` text,
  `attachment` varchar(255) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultant_tasks`
--

INSERT INTO `consultant_tasks` (`id`, `consultant_id`, `task_category_id`, `task_list_id`, `title`, `description`, `due_date`, `comments`, `attachment`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 2, 4, 'Test', 'test', '2017-06-01', NULL, 'University Dashboard1496219674.docx', 0, 'susan@brighter-prep.com-partner_login', '2017-05-31 08:34:34', '2', '2017-05-31 08:34:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `consultant_tasks`
--
ALTER TABLE `consultant_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_category_id` (`task_category_id`),
  ADD KEY `task_list_id` (`task_list_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `consultant_tasks`
--
ALTER TABLE `consultant_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
