-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2017 at 03:00 PM
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
-- Table structure for table `access_control`
--

CREATE TABLE `access_control` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `controller` varchar(100) NOT NULL,
  `actions` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_control`
--

INSERT INTO `access_control` (`id`, `name`, `controller`, `actions`) VALUES
(1, 'Add/Update Tests', 'students', 'tests'),
(2, 'View Student Information', 'students', 'view'),
(3, 'Update Student Profile', 'students', 'update'),
(4, 'Download All Documents', 'students', 'download-all'),
(5, 'Upload Documents', 'students', 'upload-documents'),
(6, 'Download Documents', 'students', 'download'),
(8, 'Task Update', 'students', 'update'),
(9, 'Task Delete', 'students', 'delete'),
(10, 'Add Task', 'students', 'create'),
(11, 'Task Reminder', 'students', 'reminder'),
(12, 'Employee/Trainer List', 'students', 'index'),
(13, 'Assign Employee/Trainer ', 'students', 'create'),
(14, 'Update Employee/Trainer', 'students', 'index'),
(15, 'Deactivate Employee/Trainer ', 'students', 'delete'),
(16, 'Shortlist/Unlist Universities', 'students', 'shortlistuniversities'),
(17, 'Shortlist Programs', 'students', 'shortlistprograms'),
(20, 'Remove Shortlisted Programs', 'students', 'remove-from-shortlist');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_control`
--
ALTER TABLE `access_control`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_control`
--
ALTER TABLE `access_control`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
