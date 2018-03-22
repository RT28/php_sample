-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 25, 2017 at 01:53 AM
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
-- Table structure for table `student_package_details`
--

CREATE TABLE `student_package_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `package_type_id` int(11) NOT NULL,
  `package_subtype_id` int(11) NOT NULL,
  `package_offerings` varchar(100) NOT NULL,
  `limit_type` int(11) NOT NULL,
  `limit_pending` int(11) NOT NULL,
  `total_fees` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_package_details`
--

INSERT INTO `student_package_details` (`id`, `student_id`, `consultant_id`, `package_type_id`, `package_subtype_id`, `package_offerings`, `limit_type`, `limit_pending`, `total_fees`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 5, 3, 1, 1, '1', 1, 7, 1600, '2017-01-23 02:14:45', 5, '2017-01-23 02:14:45', 5),
(3, 5, 3, 1, 1, '1', 1, 7, 1600, '2017-01-23 07:06:35', 5, '2017-01-23 07:06:35', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `student_package_details`
--
ALTER TABLE `student_package_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `package_type_id` (`package_type_id`),
  ADD KEY `package_subtype_id` (`package_subtype_id`),
  ADD KEY `consultant_id` (`consultant_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `student_package_details`
--
ALTER TABLE `student_package_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `student_package_details`
--
ALTER TABLE `student_package_details`
  ADD CONSTRAINT `student_package_details partner_login foreign key` FOREIGN KEY (`consultant_id`) REFERENCES `partner_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
