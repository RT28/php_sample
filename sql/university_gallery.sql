-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2017 at 03:05 PM
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
-- Table structure for table `university_gallery`
--

CREATE TABLE `university_gallery` (
  `id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `photo_type` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `status` int(2) NOT NULL,
  `active` int(1) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_at` varchar(50) DEFAULT NULL,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` varchar(50) NOT NULL,
  `reviewed_by` varchar(50) DEFAULT NULL,
  `reviewed_at` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `university_gallery`
--

INSERT INTO `university_gallery` (`id`, `university_id`, `photo_type`, `filename`, `status`, `active`, `created_by`, `created_at`, `updated_by`, `updated_at`, `reviewed_by`, `reviewed_at`) VALUES
(1, 58, 'cover_photo', 'cover1493109651.jpg', 1, 1, '1', '2017-04-25 08:40:25', '1', '2017-04-25 08:40:51', NULL, NULL),
(2, 58, 'logo', 'cover1493109652.jpg', 1, 1, '1', '2017-04-25 08:40:25', '1', '2017-04-25 08:40:52', NULL, NULL),
(3, 58, 'photos', 'P11493109625.jpg', 1, 1, '1', '2017-04-25 08:40:25', '1', '2017-04-25 08:40:25', NULL, NULL),
(4, 58, 'photos', 'P21493109625.jpg', 1, 1, '1', '2017-04-25 08:40:25', '1', '2017-04-25 08:40:25', NULL, NULL),
(5, 58, 'photos', 'P31493109625.jpg', 1, 1, '1', '2017-04-25 08:40:25', '1', '2017-04-25 08:40:25', NULL, NULL),
(6, 58, 'photos', 'P41493109625.jpg', 1, 1, '1', '2017-04-25 08:40:25', '1', '2017-04-25 08:40:25', NULL, NULL),
(7, 58, 'photos', 'P51493109625.jpg', 1, 1, '1', '2017-04-25 08:40:25', '1', '2017-04-25 08:40:25', NULL, NULL),
(8, 58, 'cover_photo', 'cover1493110351.jpg', 0, 0, '1', '2017-04-25 08:52:31', '1', '2017-04-25 08:52:31', NULL, NULL),
(9, 58, 'logo', 'cover1493110352.jpg', 0, 0, '1', '2017-04-25 08:52:32', '1', '2017-04-25 08:52:32', NULL, NULL),
(10, 58, 'photos', 'P11493110352.jpg', 0, 0, '1', '2017-04-25 08:52:32', '1', '2017-04-25 08:52:32', NULL, NULL),
(11, 58, 'photos', 'P21493110352.jpg', 0, 0, '1', '2017-04-25 08:52:32', '1', '2017-04-25 08:52:32', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `university_gallery`
--
ALTER TABLE `university_gallery`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `university_gallery`
--
ALTER TABLE `university_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
