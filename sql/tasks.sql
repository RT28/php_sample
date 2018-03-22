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
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `srm_id` int(11) NOT NULL,
  `task_category_id` int(11) NOT NULL,
  `task_list_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text,
  `notified` varchar(50) NOT NULL,
  `additional` varchar(255) NOT NULL,
  `standard_alert` varchar(20) NOT NULL,
  `specific_alert` varchar(20) NOT NULL,
  `responsibility` varchar(20) NOT NULL,
  `others` varchar(255) NOT NULL,
  `due_date` date DEFAULT NULL,
  `comments` text,
  `attachment` varchar(255) DEFAULT NULL,
  `action` int(5) NOT NULL,
  `verifybycounselor` int(5) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `student_id`, `consultant_id`, `srm_id`, `task_category_id`, `task_list_id`, `title`, `description`, `notified`, `additional`, `standard_alert`, `specific_alert`, `responsibility`, `others`, `due_date`, `comments`, `attachment`, `action`, `verifybycounselor`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(2, 21, 4, 0, 2, 3, 'Passport Copy and Valid visa\'s', 'Upload Passport and valid visa copy and complete this task.', '1,2,3,4', 'roan@brighter-prep.com', '', '1', '2', 'Parents/ friend/Sibling', '2017-07-01', 'Assigned to student', NULL, 1, 1, 1, 'karan@brighter-prep.com-partner_login', '2017-06-28 14:37:42', 'karan@brighter-prep.com-partner_login', '2017-07-02 13:10:01'),
(3, 22, 4, 0, 1, 2, 'Language Proficiency', 'Test Test', '1,2,3,4', 'susan@brighter-prep.com', '', '1', '0', '', NULL, 'Test Test', NULL, 1, 1, 2, 'karan@brighter-prep.com-partner_login', '2017-07-02 10:30:03', 'karan@brighter-prep.com-partner_login', '2017-07-02 14:03:29'),
(4, 8, 0, 1, 2, 0, 'test', 'test', '1,2,3,4', 'roan@brighter-prep.com', '', '1', '2', 'others', '2017-07-19', 'tes', NULL, 0, 0, 0, 'kalyani@brighter-prep.com-partner_login', '2017-07-04 14:05:17', 'kalyani@brighter-prep.com-partner_login', '2017-07-05 13:09:56'),
(5, 10, 4, 0, 2, 3, 'Passport Copy and Valid visa\'s', 'Submit Passport', '1,2', '', '', '0', '2', 'dsdsads', '2017-07-15', 'test', NULL, 0, 0, 2, 'karan@brighter-prep.com-partner_login', '2017-07-05 08:59:38', 'student-user_login', '2017-07-05 11:40:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_category_id` (`task_category_id`),
  ADD KEY `task_list_id` (`task_list_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
