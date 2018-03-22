-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 22, 2016 at 07:03 AM
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
CREATE DATABASE IF NOT EXISTS `collegexperts` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `collegexperts`;

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `from_type` int(20) NOT NULL,
  `to_id` int(100) NOT NULL,
  `to_type` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` int(1) NOT NULL DEFAULT '0',
  `time_stamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `from_id`, `from_type`, `to_id`, `to_type`, `message`, `is_read`, `time_stamp`) VALUES
(1, 1, 4, 1, 3, 'hello', 0, '2016-10-06 12:27:25'),
(2, 1, 3, 1, 4, 'vfvfv', 0, '2016-10-06 12:53:07'),
(3, 1, 3, 1, 4, 'cdfvf', 0, '2016-10-06 12:54:32'),
(4, 1, 3, 1, 4, 'vfvfvf', 0, '2016-10-06 12:58:25'),
(5, 1, 3, 1, 4, 'fvfvfvf', 0, '2016-10-06 12:58:38'),
(6, 1, 3, 1, 4, 'vfvfvf', 0, '2016-10-06 12:58:54'),
(7, 1, 4, 1, 3, 'vfvfv', 0, '2016-10-06 12:59:31'),
(8, 1, 3, 1, 4, 'vfvfvf', 0, '2016-10-06 13:00:38'),
(9, 1, 3, 1, 4, 'vfvfv', 0, '2016-10-06 13:01:43'),
(10, 1, 4, 1, 3, 'vfvfv', 0, '2016-10-06 13:01:51'),
(11, 1, 3, 1, 4, 'vfvfvfd', 0, '2016-10-06 13:01:57'),
(12, 5, 4, 3, 3, 'Hello', 0, '2016-10-11 20:22:44'),
(13, 5, 4, 3, 3, 'Hello', 0, '2016-10-11 20:23:09'),
(14, 5, 4, 3, 3, 'Hello', 0, '2016-10-11 20:27:18'),
(15, 5, 4, 3, 3, 'Hello', 0, '2016-10-11 20:27:55'),
(16, 5, 4, 3, 3, 'Some very vert long message to test overflow and alignment horizontally and vertically', 0, '2016-10-11 20:28:27'),
(17, 5, 4, 3, 3, 'Some very vert long message to test overflow and alignment horizontally and vertically', 0, '2016-10-11 20:29:18'),
(18, 5, 4, 3, 3, 'Some very vert long message to test overflow and alignment horizontally and vertically', 0, '2016-10-11 20:29:20'),
(19, 5, 4, 3, 3, 'Some very vert long message to test overflow and alignment horizontally and vertically', 0, '2016-10-11 20:29:22'),
(20, 5, 4, 3, 3, 'Some very vert long message to test overflow and alignment horizontally and vertically', 0, '2016-10-11 20:29:25'),
(21, 5, 4, 3, 3, 'Some very vert long message to test overflow and alignment horizontally and vertically', 0, '2016-10-11 20:29:27'),
(22, 5, 4, 3, 3, 'Hello', 0, '2016-10-11 20:31:46'),
(23, 3, 3, 5, 4, 'Hi go to university', 0, '2016-10-11 21:53:26'),
(24, 5, 4, 3, 3, 'Hello SRM', 0, '2016-10-11 21:56:20'),
(25, 5, 4, 3, 3, 'Hello SRM', 0, '2016-10-11 21:56:59'),
(26, 5, 4, 3, 3, 'Hello SRM', 0, '2016-10-11 21:58:24'),
(27, 3, 3, 4, 4, 'Hi John Doe', 0, '2016-10-11 21:59:07'),
(28, 4, 4, 3, 3, 'Hi SRM', 0, '2016-10-11 22:00:07'),
(29, 4, 4, 3, 3, 'test', 0, '2016-10-12 00:23:22'),
(30, 6, 4, 3, 3, 'Hello', 0, '2016-10-12 11:04:41'),
(31, 3, 3, 6, 4, 'HI', 0, '2016-10-12 11:04:46'),
(32, 3, 3, 6, 4, 'Hi Riddhi', 0, '2016-10-12 13:33:12'),
(33, 6, 4, 3, 3, 'Hi SRM', 0, '2016-10-12 13:33:19'),
(34, 3, 3, 6, 4, 'hello', 0, '2016-10-12 15:28:37');

-- --------------------------------------------------------

--
-- Table structure for table `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`id`, `name`, `state_id`, `country_id`) VALUES
(1, 'Stanford', 1, 1),
(2, 'Mumbai', 3, 4),
(3, 'Cambridge', 4, 1),
(4, 'Los Angeles', 1, 1),
(5, 'San Fransisco', 1, 1),
(6, 'San Diego', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `consultant`
--

CREATE TABLE IF NOT EXISTS `consultant` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `country` int(11) NOT NULL,
  `speciality` varchar(500) DEFAULT NULL,
  `description` text,
  `experience` int(11) NOT NULL,
  `skills` varchar(500) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `consultant`
--

INSERT INTO `consultant` (`id`, `name`, `email`, `gender`, `mobile`, `country`, `speciality`, `description`, `experience`, `skills`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Jill Clarke', 'jill_clarke@gmail.com', 'F', '45456', 1, 'SOP, Essays', NULL, 8, NULL, NULL, NULL, '2016-10-03 06:42:39', '2016-10-03 06:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `consultant_calendar`
--

CREATE TABLE IF NOT EXISTS `consultant_calendar` (
  `id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `student_appointment_id` int(11) DEFAULT NULL,
  `event_type` int(11) NOT NULL,
  `appointment_status` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `consultant_notifications`
--

CREATE TABLE IF NOT EXISTS `consultant_notifications` (
  `id` int(11) NOT NULL,
  `consultant_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `from_role` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`) VALUES
(1, 'United States'),
(2, 'Canada'),
(3, 'Great Britain'),
(4, 'India'),
(5, 'China'),
(6, 'Singapore'),
(7, 'Australia');

-- --------------------------------------------------------

--
-- Table structure for table `degree`
--

CREATE TABLE IF NOT EXISTS `degree` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `duration` int(2) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `degree`
--

INSERT INTO `degree` (`id`, `name`, `type`, `duration`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Bachelor of Arts (B.A.)', 2, 3, 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(2, 'Bachelors in Aeronautics', 2, 4, 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `degree_level`
--

CREATE TABLE IF NOT EXISTS `degree_level` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `degree_level`
--

INSERT INTO `degree_level` (`id`, `name`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Under Graduate', 1, '2016-09-24 06:23:18', 1, '2016-09-24 06:23:45'),
(2, 'Post Graduate', 1, '2016-09-24 06:23:35', 1, '2016-09-24 06:23:35'),
(3, 'Diploma', 1, '2016-09-24 06:23:52', 1, '2016-09-24 06:23:52'),
(4, 'Doctoral', 1, '2016-09-24 06:24:01', 1, '2016-09-24 06:24:01');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `employee_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `address`, `street`, `city`, `state`, `country`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'admin', 'admin', '2016-08-01', 'M', 'address', 'street', 'Mumbai', 1, 1, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00'),
(2, 2, 'editor', 'editor', '2016-08-24', 'M', 'address', 'street', 'California', 3, 4, 0, '0000-00-00 00:00:00', 1, '2016-09-24 06:14:31'),
(3, 3, 'srm', 'srm', '2016-08-24', 'F', 'address', 'street', 'Mumbai', 1, 4, 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employee_login`
--

CREATE TABLE IF NOT EXISTS `employee_login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `auth_key` varchar(255) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_login`
--

INSERT INTO `employee_login` (`id`, `username`, `role_id`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'admin', 1, '5hWkWLknpa58_h-d3joZauQbAIXChgWO', '$2y$13$Otq0KVyzAC.B1H5HNJdus./5nusVxAy9.TXVWj3c0WNWfL9AYNvrC', '', 'admin@gmail.com', 10, '2016-08-24 11:10:37', '2016-08-24 11:10:37', 1, 1),
(2, 'editor', 2, 'nHKJB130i3BAbyOnf9qOojDx3TWzoLSf', '$2y$13$TwTmQJ0cOtUdKVLNYFy4R.sVWJu5LNBV8RCjnGh2V9ZiDo7ROfgz2', NULL, 'editor@gmail.com', 10, '2016-08-24 11:25:19', '2016-08-24 11:25:19', 2, 2),
(3, 'srm', 3, '_yrFIhkbjiDiMuU12tzxd1mIrhKLyweZ', '$2y$13$L7z3UO0mCffhXNknNKCWAuXCNEywOcFSzva5U8z7T3b5NwrUbA4fq', NULL, 'gotouniversity.super@gmail.com', 10, '2016-08-24 11:27:08', '2016-08-24 11:27:08', 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE IF NOT EXISTS `majors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `name`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'Anthropology Honors', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(2, 'Art History', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(3, 'Asian Studies', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00'),
(4, 'Aeronautics and Astronautics', 1, '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1471935561),
('m130524_201442_init', 1471935631);

-- --------------------------------------------------------

--
-- Table structure for table `others`
--

CREATE TABLE IF NOT EXISTS `others` (
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `others`
--

INSERT INTO `others` (`name`, `value`) VALUES
('course_type', 'Full Time, Part Time, Offline'),
('establishment', 'Public,Private'),
('event_type', 'Reminder,Availability,Appointment/Meeting, Other'),
('institution_type', 'University,College'),
('intake', 'Spring 2017,Fall 2017'),
('languages', 'English,Chinese,French');

-- --------------------------------------------------------

--
-- Table structure for table `partner`
--

CREATE TABLE IF NOT EXISTS `partner` (
  `id` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partner`
--

INSERT INTO `partner` (`id`, `partner_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `address`, `street`, `city`, `state`, `country`) VALUES
(1, 1, 'university', 'university', '2016-08-11', 'M', 'address', 'street', 1, 1, 1),
(2, 2, 'partner', 'partner', '2016-08-03', 'F', 'address', 'street', 1, 1, 1);

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
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `partner_id` int(11) NOT NULL,
  `role_id` smallint(6) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partner_login`
--

INSERT INTO `partner_login` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `partner_id`, `role_id`) VALUES
(1, 'university', 'Gp1GZ1WSp5idoXkvMRFxEgRgRW1VmwBm', '$2y$13$EgrnQmI2YepoIaNWlXgNuuo3uRlpOJgV9eFqS.MugIJIXTMGIW4EK', NULL, 'gotouniversity.super@gmail.com', 10, '2016-08-24 11:33:31', '2016-08-24 11:33:31', 1, 1, 1, 5),
(2, 'partner', 'RtRKT7tBBob_z9tDtPHd1sh5_tJZU1Cn', '$2y$13$/fjoAazH/J9ygw6uKlU3PeWH9iv3vMR3Qc2WJy8JsdDEY.02kAvWm', NULL, 'gotouniversity.super@gmail.com', 10, '2016-08-24 11:34:33', '2016-08-24 11:34:33', 2, 2, 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `srm`
--

CREATE TABLE IF NOT EXISTS `srm` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `gender` varchar(1) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `country` int(11) NOT NULL,
  `speciality` varchar(500) DEFAULT NULL,
  `description` text,
  `experience` int(11) NOT NULL,
  `skills` varchar(500) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `srm`
--

INSERT INTO `srm` (`id`, `name`, `email`, `gender`, `mobile`, `country`, `speciality`, `description`, `experience`, `skills`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'John', 'john_papa@gmail.com', 'M', '456465568', 1, 'Essay, US Universities', NULL, 3, NULL, NULL, NULL, '2016-10-03 06:41:38', '2016-10-03 06:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `srm_calendar`
--

CREATE TABLE IF NOT EXISTS `srm_calendar` (
  `id` int(11) NOT NULL,
  `srm_id` int(11) NOT NULL,
  `student_appointment_id` int(11) DEFAULT NULL,
  `event_type` int(11) NOT NULL,
  `appointment_status` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `srm_calendar`
--

INSERT INTO `srm_calendar` (`id`, `srm_id`, `student_appointment_id`, `event_type`, `appointment_status`, `title`, `url`, `remarks`, `start`, `end`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 3, 1, 2, 0, 'simple appointment', '', 'simple appointment', '2016-10-22 08:00:00', '2016-10-22 09:00:00', 5, '2016-10-22 04:00:20', 5, '2016-10-22 04:00:20'),
(2, 3, NULL, 1, 0, 'unavailable', '', 'unavailable', '2016-10-23 08:00:00', '2016-10-24 09:00:00', 3, '2016-10-22 04:00:20', 3, '2016-10-22 04:00:20');

-- --------------------------------------------------------

--
-- Table structure for table `srm_notifications`
--

CREATE TABLE IF NOT EXISTS `srm_notifications` (
  `id` int(11) NOT NULL,
  `srm_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `from_role` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `srm_notifications`
--

INSERT INTO `srm_notifications` (`id`, `srm_id`, `from_id`, `from_role`, `message`, `timestamp`, `read`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 3, 5, 4, '{"message":"You have recieved a request to review an application. Click on this link to open application.","link":"http:\\/\\/localhost\\/yii2\\/gotouniversity\\/backend\\/web\\/index.php?r=university-applications\\/view&id=9"}', '0000-00-00 00:00:00', 0, NULL, NULL, NULL, NULL),
(2, 3, 5, 4, '{"message":"You have recieved a request to review an application. Click on this link to open application.","link":"http:\\/\\/localhost\\/yii2\\/gotouniversity\\/backend\\/web\\/index.php?r=university-applications\\/view&id=10"}', '0000-00-00 00:00:00', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `name`, `country_id`) VALUES
(1, 'California', 1),
(2, 'Maryland', 1),
(3, 'Maharashtra', 4),
(4, 'Massachusetts', 1),
(5, 'Hawaii', 1),
(6, 'Florida', 1),
(7, 'Texas', 1),
(8, 'Pennsylvania', 1),
(9, 'Alaska', 1),
(10, 'Minnesota', 1),
(11, 'Georgia', 1),
(12, 'New Jersey', 1),
(13, 'Louisiana', 1),
(14, 'North Carolina', 1),
(15, 'Alabama', 1),
(16, 'Arizona', 1),
(17, 'Illinois', 1),
(18, 'Virginia', 1),
(19, 'Colorado', 1),
(20, 'Michigan', 1),
(21, 'Tennessee', 1),
(22, 'Ohio', 1),
(23, 'Kentucky', 1);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `nationality` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` varchar(50) NOT NULL,
  `address` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` int(100) NOT NULL,
  `country` int(100) NOT NULL,
  `pincode` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `parent_email` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `student_id`, `first_name`, `last_name`, `nationality`, `date_of_birth`, `gender`, `address`, `street`, `city`, `state`, `country`, `pincode`, `email`, `parent_email`, `phone`, `parent_phone`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(8, 4, 'John', 'Doe', 'Indian', '1992-10-13', 'M', 'Address', 'Streeet', 'Mumbai', 3, 4, '124587', 'gotouniversity.super@gmail.com', 'gotouniversity.super@gmail.com', '48789856', '48789856', NULL, NULL, '2016-10-11 03:31:45', '2016-10-11 03:31:45'),
(9, 4, 'John', 'Doe', 'Indian', '1992-10-13', 'M', 'Address', 'Streeet', 'Mumbai', 3, 4, '124587', 'gotouniversity.super@gmail.com', 'gotouniversity.super@gmail.com', '48789856', '12345678', NULL, NULL, '2016-10-11 03:32:36', '2016-10-11 03:32:36'),
(10, 5, 'Student', 'Gotouniversity', 'Indian', '1989-03-15', 'M', 'Address', 'Streeet', 'Mumbai', 3, 4, '400089', 'gotouniversity.student@gmail.com', 'gotouniversity.student@gmail.com', '48789856', '12345678', NULL, NULL, '2016-10-11 09:24:44', '2016-10-11 09:24:44'),
(11, 6, 'Riddhi', 'T', 'Indian', '2010-06-01', 'M', 'Address', 'Streeet', 'Mumbai', 3, 4, '124587', 'rddh2804@gmail.com', 'gotouniversity.super@gmail.com', '48789856', '12345678', NULL, NULL, '2016-10-11 18:57:41', '2016-10-11 18:57:41');

-- --------------------------------------------------------

--
-- Table structure for table `student_calendar`
--

CREATE TABLE IF NOT EXISTS `student_calendar` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `srm_appointment_id` int(11) DEFAULT NULL,
  `consultant_appointment_id` int(11) DEFAULT NULL,
  `event_type` int(11) NOT NULL,
  `appointment_status` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `url` varchar(500) DEFAULT NULL,
  `remarks` varchar(200) DEFAULT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_calendar`
--

INSERT INTO `student_calendar` (`id`, `student_id`, `srm_appointment_id`, `consultant_appointment_id`, `event_type`, `appointment_status`, `title`, `url`, `remarks`, `start`, `end`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 5, 1, NULL, 2, 0, 'simple appointment', '', 'simple appointment', '2016-10-22 08:00:00', '2016-10-22 09:00:00', 5, '2016-10-22 04:40:10', 5, '2016-10-22 04:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `student_college_detail`
--

CREATE TABLE IF NOT EXISTS `student_college_detail` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `from_date` year(4) NOT NULL,
  `to_date` year(4) NOT NULL,
  `curriculum` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_college_detail`
--

INSERT INTO `student_college_detail` (`id`, `student_id`, `name`, `from_date`, `to_date`, `curriculum`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 'college', 2016, 2016, 'cdscdsc', 4, 4, '2016-10-11 05:38:22', '2016-10-11 05:38:22');

-- --------------------------------------------------------

--
-- Table structure for table `student_english_language_proficiencey_details`
--

CREATE TABLE IF NOT EXISTS `student_english_language_proficiencey_details` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `reading_score` int(11) NOT NULL,
  `writing_score` int(11) NOT NULL,
  `listening_score` int(11) NOT NULL,
  `speaking_score` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` datetime NOT NULL,
  `updated_by` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_english_language_proficiencey_details`
--

INSERT INTO `student_english_language_proficiencey_details` (`id`, `student_id`, `test_name`, `reading_score`, `writing_score`, `listening_score`, `speaking_score`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2, 4, 'IELTS', 10, 10, 10, 10, 2016, 2016, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student_notifications`
--

CREATE TABLE IF NOT EXISTS `student_notifications` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `from_role` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_notifications`
--

INSERT INTO `student_notifications` (`id`, `student_id`, `from_id`, `from_role`, `message`, `timestamp`, `read`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 5, 5, 4, '{"message":"Your application has been submitted to your Counselor\\/Consultant for review. Click on this link to view your application","link":"http:\\/\\/localhost\\/yii2\\/gotouniversity\\/frontend\\/web\\/index.php?r=university-applications\\/view&id=9"}', '0000-00-00 00:00:00', 0, NULL, NULL, NULL, NULL),
(2, 5, 5, 4, '{"message":"Your application has been submitted to your Counselor\\/Consultant for review. Click on this link to view your application","link":"http:\\/\\/localhost\\/yii2\\/gotouniversity\\/frontend\\/web\\/index.php?r=university-applications\\/view&id=10"}', '0000-00-00 00:00:00', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student_school_detail`
--

CREATE TABLE IF NOT EXISTS `student_school_detail` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `from_date` year(4) NOT NULL,
  `to_date` year(4) NOT NULL,
  `curriculum` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_school_detail`
--

INSERT INTO `student_school_detail` (`id`, `student_id`, `name`, `from_date`, `to_date`, `curriculum`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(2, 4, 'cdcd', 2016, 2016, 'dvvdv', 4, 4, '2016-10-11 05:17:24', '2016-10-11 05:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `student_srm_relation`
--

CREATE TABLE IF NOT EXISTS `student_srm_relation` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `srm_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_srm_relation`
--

INSERT INTO `student_srm_relation` (`id`, `student_id`, `srm_id`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(4, 4, 3, 5, '2016-10-11 09:17:32', 5, '2016-10-11 09:17:32'),
(5, 5, 3, 5, '2016-10-11 09:25:20', 5, '2016-10-11 09:25:20'),
(6, 6, 3, 6, '2016-10-11 18:56:39', 6, '2016-10-11 18:56:39');

-- --------------------------------------------------------

--
-- Table structure for table `student_standard_test_detail`
--

CREATE TABLE IF NOT EXISTS `student_standard_test_detail` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `test_name` varchar(255) NOT NULL,
  `verbal_score` int(11) NOT NULL,
  `quantitative_score` int(11) NOT NULL,
  `integrated_reasoning_score` int(11) NOT NULL,
  `data_interpretation_score` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_standard_test_detail`
--

INSERT INTO `student_standard_test_detail` (`id`, `student_id`, `test_name`, `verbal_score`, `quantitative_score`, `integrated_reasoning_score`, `data_interpretation_score`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 4, 'GRE', 50, 50, 50, 50, 4, 4, '2016-10-11 06:33:56', '2016-10-11 06:33:56');

-- --------------------------------------------------------

--
-- Table structure for table `student_subject_detail`
--

CREATE TABLE IF NOT EXISTS `student_subject_detail` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `maximum_marks` int(11) NOT NULL,
  `marks_obtained` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_subject_detail`
--

INSERT INTO `student_subject_detail` (`id`, `student_id`, `name`, `maximum_marks`, `marks_obtained`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(5, 4, 'Physics', 100, 75, 4, 4, '2016-10-11 05:48:34', '2016-10-11 05:48:34');

-- --------------------------------------------------------

--
-- Table structure for table `student_univeristy_application`
--

CREATE TABLE IF NOT EXISTS `student_univeristy_application` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `srm_id` int(11) NOT NULL,
  `consultant_id` int(11) DEFAULT NULL,
  `university_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `start_term` varchar(50) NOT NULL,
  `status` int(2) DEFAULT '0',
  `remarks` varchar(500) DEFAULT NULL,
  `summary` text,
  `active` int(11) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` int(11) NOT NULL,
  `updated_by_role` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student_univeristy_application`
--

INSERT INTO `student_univeristy_application` (`id`, `student_id`, `srm_id`, `consultant_id`, `university_id`, `course_id`, `start_term`, `status`, `remarks`, `summary`, `active`, `created_by`, `created_at`, `updated_by`, `updated_by_role`, `updated_at`) VALUES
(1, 5, 3, NULL, 1, 1, 'Fall 2017', 2, 'bfdfbfdbdzxb', '[{"role":5,"id":1,"time":"2016-10-17 03:58:38","comment":"Creating Sample admission"},{"role":4,"id":5,"time":"2016-10-17 04:46:16","comment":"Submit email test"},{"role":4,"id":5,"time":"2016-10-17 04:47:59","comment":"Submit eamil test"},{"role":4,"id":5,"time":"2016-10-17 04:55:31","comment":"Student email test"},{"role":4,"id":5,"time":"2016-10-17 04:58:19","comment":"vfdbfdbfdbfd"},{"role":4,"id":5,"time":"2016-10-17 05:00:32","comment":"bbfdbfdbfd"},{"role":4,"id":5,"time":"2016-10-17 05:02:05","comment":"cddsvd"}]', 1, 5, '2016-10-17 08:00:16', 5, 4, '2016-10-17 02:30:16'),
(2, 6, 3, NULL, 1, 1, 'Fall 2017', 1, 'Create new application', '', 1, 6, '2016-10-17 08:00:09', 6, 0, '2016-10-13 00:14:49'),
(3, 5, 3, NULL, 1, 55, 'Fall 2017', 8, 'Approved by university', '[{"role":0,"id":5,"time":"2016-10-17 02:46:57","comment":"Creating Sample admission"},{"role":4,"id":5,"time":"2016-10-17 02:48:43","comment":"Submit to SRM"},{"role":4,"id":5,"time":"2016-10-17 02:54:02","comment":"Testing remarks"},{"role":4,"id":5,"time":"2016-10-17 03:29:58","comment":"testing remarks 2"},{"role":3,"id":3,"time":"2016-10-17 03:32:29","comment":"Approved by SRM"},{"role":3,"id":3,"time":"2016-10-17 03:44:00","comment":"Approved by SRM"}]', 1, 5, '2016-10-17 03:44:00', 1, 5, '2016-10-16 22:14:00'),
(6, 5, 3, NULL, 1, 1, 'Fall 2017', 2, 'vbfdbfbffdbfbvdf', '[{"role":4,"id":5,"time":"2016-10-17 08:01:09","comment":"gbgbfdbgfb nv"}]', 1, 5, '2016-10-17 08:01:09', 5, 4, '2016-10-17 02:31:09'),
(7, 5, 3, NULL, 1, 1, 'Fall 2017', 2, 'bfbfdbdfbfd', '[{"role":4,"id":5,"time":"2016-10-17 08:06:45","comment":"gfdgfdgfdhbgfbhfgbhfgv"}]', 1, 5, '2016-10-17 08:06:45', 5, 4, '2016-10-17 02:36:45'),
(8, 5, 3, NULL, 1, 1, 'Fall 2017', 2, 'bgbffdfbfdbfd', '[]', 1, 5, '2016-10-17 08:08:06', 5, 4, '2016-10-17 02:38:06'),
(9, 5, 3, NULL, 1, 1, 'Fall 2017', 2, 'bgbffdfbfdbfdvfdbfdbfbfbfdbfvb', '[{"role":4,"id":5,"time":"2016-10-17 08:17:12","comment":"fbfdbfdbfdbfdbfd"}]', 1, 5, '2016-10-17 08:17:12', 5, 4, '2016-10-17 02:47:12'),
(10, 5, 3, NULL, 1, 1, 'Fall 2017', 2, 'vdsvdsvdfsvfbfdbbbb', '[{"role":4,"id":5,"time":"2016-10-17 08:19:48","comment":"vcxvsdvdsvdsv"}]', 1, 5, '2016-10-17 08:19:48', 5, 4, '2016-10-17 02:49:48'),
(11, 5, 3, NULL, 1, 1, 'Fall 2017', 1, 'cdsvdsvfdbvdfbfd', '[]', 1, 5, '2016-10-17 08:00:09', 5, 4, '2016-10-17 02:28:15');

-- --------------------------------------------------------

--
-- Table structure for table `university`
--

CREATE TABLE IF NOT EXISTS `university` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `establishment_date` int(4) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `pincode` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `fax` varchar(20) DEFAULT NULL,
  `phone_1` varchar(20) NOT NULL,
  `phone_2` varchar(20) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `contact_person_designation` varchar(50) DEFAULT NULL,
  `contact_mobile` varchar(15) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `location` point DEFAULT NULL,
  `institution_type` int(11) DEFAULT NULL,
  `establishment` int(11) DEFAULT NULL,
  `no_of_students` int(11) DEFAULT NULL,
  `no_of_undergraduate_students` int(11) DEFAULT NULL,
  `no_of_post_graduate_students` int(11) DEFAULT NULL,
  `no_of_international_students` int(11) DEFAULT NULL,
  `no_faculties` int(11) DEFAULT NULL,
  `no_of_international_faculty` int(11) DEFAULT NULL,
  `cost_of_living` int(11) DEFAULT NULL,
  `undergarduate_fees` int(11) DEFAULT NULL,
  `undergraduate_fees_international_students` int(11) DEFAULT NULL,
  `post_graduate_fees` int(11) DEFAULT NULL,
  `post_graduate_fees_international_students` int(11) DEFAULT NULL,
  `accomodation_available` bit(1) NOT NULL DEFAULT b'0',
  `hostel_strength` int(11) DEFAULT NULL,
  `institution_ranking` text,
  `video` varchar(500) DEFAULT NULL,
  `virtual_tour` varchar(500) DEFAULT NULL,
  `avg_rating` int(11) DEFAULT NULL,
  `standard_tests_required` bit(1) DEFAULT b'0',
  `standard_test_list` varchar(500) DEFAULT NULL,
  `achievements` text,
  `comments` text,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `university`
--

INSERT INTO `university` (`id`, `name`, `establishment_date`, `address`, `city_id`, `state_id`, `country_id`, `pincode`, `email`, `website`, `description`, `fax`, `phone_1`, `phone_2`, `contact_person`, `contact_person_designation`, `contact_mobile`, `contact_email`, `location`, `institution_type`, `establishment`, `no_of_students`, `no_of_undergraduate_students`, `no_of_post_graduate_students`, `no_of_international_students`, `no_faculties`, `no_of_international_faculty`, `cost_of_living`, `undergarduate_fees`, `undergraduate_fees_international_students`, `post_graduate_fees`, `post_graduate_fees_international_students`, `accomodation_available`, `hostel_strength`, `institution_ranking`, `video`, `virtual_tour`, `avg_rating`, `standard_tests_required`, `standard_test_list`, `achievements`, `comments`, `status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `reviewed_by`, `reviewed_at`) VALUES
(1, 'Stanford University', 1885, ' 450 Serra Mall', 1, 1, 1, 94305, 'gotouniversity.super@gmail.com', 'https://www.stanford.edu', '<p>Stanford University, located between San Francisco and San Jose in the heart of California&#39;s Silicon Valley, is one of the world&#39;s leading teaching and research universities. Since its opening in 1891, Stanford has been dedicated to finding solutions to big challenges and to preparing students for leadership in a complex world.</p>\r\n', '650-723-8371', '+1-866-432-7472', '', 'Graduate Admissions', 'Graduate Admissions', '+1-866-432-7472', 'gradadmissions@stanford.edu', '\0\0\0\0\0\0\0¼\nC·¶B@ÅÿáåŠ^À', 0, 0, 16112, NULL, NULL, 6994, 528, NULL, 106502, NULL, NULL, NULL, NULL, b'1', 1500, '[{"rank":"3","source":"www.webometrics.info/en/world","name":"Webometrics"},{"rank":"2","source":"http://www.topuniversities.com/universities/stanford-university","name":"Top Universities"},{"rank":"4","source":"http://www.topuniversities.com/universities/stanford-university","name":"beferf"}]', '', '', NULL, b'1', '0', '', '', 10, 1, '2016-09-09 09:19:38', 1, '2016-10-18 13:33:02', NULL, NULL),
(5, 'Massachusetts Institute of Technology', 0, ' 77 Massachusetts Ave', 3, 4, 1, 2139, 'web-query@mit.edu', 'http://web.mit.edu/', 'The mission of the Massachusetts Institute of Technology is to advance knowledge and educate students in science, technology, and other areas of scholarship that will best serve the nation and the world in the 21st century. We are also driven to bring knowledge to bear on the worldâ€™s great challenges.\r\n\r\nThe Institute is an independent, coeducational, privately endowed university, organized into five Schools (architecture and planning; engineering; humanities, arts, and social sciences; management; and science). It has some 1,000 faculty members, more than 11,000 undergraduate and graduate students, and more than 130,000 living alumni.\r\n\r\nAt its founding in 1861, MIT was an educational innovation, a community of hands-on problem solvers in love with fundamental science and eager to make the world a better place. Today, that spirit still guides how we educate students on campus and how we shape new digital learning technologies to make MIT teaching accessible to millions of learners around the world.\r\n\r\nMITâ€™s spirit of interdisciplinary exploration has fueled many scientific breakthroughs and technological advances. A few examples: the first chemical synthesis of penicillin and vitamin A. The development of radar and creation of inertial guidance systems. The invention of magnetic core memory, which enabled the development of digital computers. Major contributions to the Human Genome Project. The discovery of quarks. The invention of the electronic spreadsheet and of encryption systems that enable e-commerce. The creation of GPS. Pioneering 3D printing. The concept of the expanding universe.\r\n\r\nCurrent research and education areas include digital learning; nanotechnology; sustainable energy, the environment, climate adaptation, and global water and food security; Big Data, cybersecurity, robotics, and artificial intelligence; human health, including cancer, HIV, autism, Alzheimerâ€™s, and dyslexia; biological engineering and CRISPR technology; poverty alleviation; advanced manufacturing; and innovation and entrepreneurship.\r\n\r\nMITâ€™s impact also includes the work of our alumni. One way MIT graduates drive progress is by starting companies that deliver new ideas to the world. A recent study estimates that as of 2014, living MIT alumni have launched more than 30,000 active companies, creating 4.6 million jobs and generating roughly $1.9 trillion in annual revenue. Taken together, this "MIT Nation" is equivalent to the 10th-largest economy in the world!', '617.253.3400', '617.253.3400', '617.253.3400', 'MIT Admin', 'Admin', '617.253.3400', 'web-query@mit.edu', '\0\0\0\0\0\0\0üÜUò®5E@\0\0\0WÄQÀ', 1, 1, 11319, NULL, NULL, 5400, 500, NULL, 100000, NULL, NULL, NULL, NULL, b'1', NULL, NULL, '', '', NULL, b'0', NULL, NULL, '', 10, 1, '2016-09-10 06:52:54', 1, '2016-09-10 07:23:50', NULL, NULL),
(40, 'dscdcd', 0, 'vfvf', 2, 3, 4, 1005646, 'cdvfdv@asa.cpm', 'vfvgfbgf.com', '<p>ngnfgn</p>\r\n', '45645645', '654565', '545645', 'vfjbjkfgbj', 'jnvjkfnbjkng', '4545645', 'nbjkgnbng@jvfj.com', '\0\0\0\0\0\0\0q‡òªs3@\ré¦ƒ+8R@', 0, 0, 1000, NULL, NULL, 100, 100, 25, 250000, NULL, NULL, NULL, NULL, b'1', 700, '3', '', '', NULL, b'1', '0', '', NULL, 0, 1, '2016-09-20 13:42:33', 1, '2016-09-20 13:42:33', NULL, NULL),
(41, 'dscdcd', 0, 'vfvf', 2, 3, 4, 1005646, 'cdvfdv@asa.cpm', 'vfvgfbgf.com', '<p>bggfngfnh</p>\r\n', '45645645', '654565', '545645', 'vfjbjkfgbj', 'jnvjkfnbjkng', '4545645', 'nbjkgnbng@jvfj.com', '\0\0\0\0\0\0\0q‡òªs3@\ré¦ƒ+8R@', 0, 0, 1000, NULL, NULL, 100, 100, 25, 250000, NULL, NULL, NULL, NULL, b'1', 700, '3', '', '', NULL, b'1', '0', '', NULL, 0, 1, '2016-09-20 14:52:45', 1, '2016-09-20 14:52:45', NULL, NULL),
(42, 'gfnbgn', 0, 'gnngng', 2, 3, 4, 145252, 'nhnhn@nhjn.con', 'fbfgbgf.vghhj.com', '<p>fbfdgdbg<span style="color:#00FF00">bfbfbgfngfn</span><span style="color:#FF0000">nhgmnghmhm</span></p>\r\n', '3538396', '25235353', '35365365', 'dfcdsvdfv', 'gvfgbdfbgfh', '2553663', 'nhnhn@nhjn.con', '\0\0\0\0\0\0\0q‡òªs3@\ré¦ƒ+8R@', 0, 0, 10000, NULL, NULL, 1200, 1450, 120, 15000, NULL, NULL, NULL, NULL, b'1', 1200, '78', '', '', NULL, b'0', '0,1,2,3,4', '', NULL, 0, 1, '2016-09-21 01:27:14', 1, '2016-09-24 06:48:52', NULL, NULL),
(43, 'gfnbgn', 0, 'gnngng', 2, 3, 4, 145252, 'nhnhn@nhjn.con', 'fbfgbgf.vghhj.com', '<p>cvdsvsd</p>\r\n', '3538396', '25235353', '35365365', 'dfcdsvdfv', 'gvfgbdfbgfh', '2553663', 'nhnhn@nhjn.con', '\0\0\0\0\0\0\0q‡òªs3@\ré¦ƒ+8R@', 0, 0, 10000, NULL, NULL, 1200, 1450, 120, 15000, NULL, NULL, NULL, NULL, b'1', 1200, '78', '', '', NULL, b'0', '0,1,2,3,4', '', NULL, 0, 1, '2016-09-21 02:11:58', 1, '2016-09-23 18:41:45', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `university_admission`
--

CREATE TABLE IF NOT EXISTS `university_admission` (
  `id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `degree_level_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `intake` int(11) NOT NULL,
  `admission_link` varchar(500) NOT NULL,
  `eligibility_criteria` text NOT NULL,
  `admission_fees` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `university_admission`
--

INSERT INTO `university_admission` (`id`, `university_id`, `degree_level_id`, `start_date`, `end_date`, `intake`, `admission_link`, `eligibility_criteria`, `admission_fees`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 42, 1, '2016-08-31', '2016-10-29', 0, 'bgfngfn', 'gvbngf', 1000, 1, '2016-09-24 06:48:52', 1, '2016-09-24 06:48:52'),
(2, 42, 2, '2016-09-09', '2016-09-30', 0, 'hkjhkjhy', 'cxscdc', 1500, 1, '2016-09-24 06:48:52', 1, '2016-09-24 06:48:52'),
(3, 1, 1, '2016-09-07', '2016-09-11', 1, 'bvbv', 'vvsd', 1000, 1, '2016-10-18 13:33:02', 1, '2016-10-18 13:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `university_course_list`
--

CREATE TABLE IF NOT EXISTS `university_course_list` (
  `id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  `intake` int(11) NOT NULL,
  `language` int(50) DEFAULT NULL,
  `fees` int(11) NOT NULL,
  `duration` decimal(2,1) NOT NULL,
  `type` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `university_course_list`
--

INSERT INTO `university_course_list` (`id`, `university_id`, `degree_id`, `major_id`, `department_id`, `name`, `description`, `intake`, `language`, `fees`, `duration`, `type`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 1, 1, 1, 'Bachelor of Arts (B.A.) Anthropology Honors', '', 60, 0, 80000, '3.0', 1, 1, '2016-09-11 09:32:03', 1, '2016-10-18 13:33:02'),
(55, 40, 1, 1, 59, 'Bachelor of Arts (B.A.) Anthropology Honors', NULL, 60, NULL, 80000, '3.0', 0, 1, '2016-09-20 13:42:33', 1, '2016-09-20 13:42:33'),
(94, 41, 1, 1, 60, 'Bachelor of Arts (B.A.) Anthropology Honors', NULL, 60, NULL, 80000, '3.0', 0, 1, '2016-09-20 14:52:45', 1, '2016-09-20 14:52:45'),
(129, 42, 1, 1, 61, 'Bachelor of Arts (B.A.) Anthropology Honors', NULL, 100, NULL, 15200, '3.0', 0, 1, '2016-09-21 03:44:47', 1, '2016-09-24 06:48:52'),
(172, 43, 2, 4, 62, 'Bachelors in Aeronautics Aeronautics and Astronautics', NULL, 150, NULL, 152000, '5.0', 0, 1, '2016-09-22 23:02:58', 1, '2016-09-23 18:41:45'),
(181, 43, 1, 3, 62, 'Bachelor of Arts (B.A.) Asian Studies', NULL, 150, NULL, 152000, '5.0', 0, 1, '2016-09-22 23:05:44', 1, '2016-09-23 18:41:45'),
(182, 43, 1, 2, 80, 'Bachelor of Arts (B.A.) Art History', NULL, 540, NULL, 7000, '4.0', 0, 1, '2016-09-22 23:07:03', 1, '2016-09-23 18:41:45'),
(183, 43, 2, 4, 80, 'Bachelors in Aeronautics Aeronautics and Astronautics', NULL, 150, NULL, 152000, '5.0', 0, 1, '2016-09-22 23:07:03', 1, '2016-09-23 18:41:45'),
(184, 1, 1, 1, 2, 'Bachelor of Arts (B.A.) Anthropology Honors', '', 100, 1, 1000, '3.0', 0, 1, '2016-09-26 06:01:21', 1, '2016-10-18 13:33:02');

-- --------------------------------------------------------

--
-- Table structure for table `university_departments`
--

CREATE TABLE IF NOT EXISTS `university_departments` (
  `id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `no_of_faculty` int(11) DEFAULT NULL,
  `website_link` text,
  `description` text,
  `created_by` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `university_departments`
--

INSERT INTO `university_departments` (`id`, `university_id`, `name`, `email`, `no_of_faculty`, `website_link`, `description`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'Aeronautics & Astronautics', 'aa@stanford.com', 100, 'https://aa.stanford.edu/', 'Aeronautics & Astronautics', 1, '2016-10-18 13:33:02', 1, '2016-10-18 13:33:02'),
(2, 1, 'Anthropology', 'aa@stanford.com', 20, 'https://anthropology.stanford.edu/', 'The Department of Anthropology offers a wide range of approaches to the topics and area studies within the field, including archaeology, ecology, environmental anthropology, evolution, linguistics, medical anthropology, political economy, science and technology studies, and sociocultural anthropology. Methodologies for the study of micro- and macro-social processes are taught through the use of qualitative and quantitative approaches. The department provides students with excellent training in theory and methods to enable them to pursue graduate study in any of the above mentioned subfields of Anthropology.', 1, '2016-10-18 13:33:02', 1, '2016-10-18 13:33:02'),
(5, 5, 'Architecture', '', 50, 'http://architecture.mit.edu/', 'Architecture was one of the four original departments at MIT, and it was the first signal that MIT would not be narrowly defined in science and technology. Through recognition of architecture as a liberal discipline, the Department has long contributed to learning in the arts and humanities at MIT.\r\n\r\nThe Department conceives of architecture as a discipline as well as a profession. It is structured in five semi-autonomous discipline groups: Architectural Design; Building Technology; Computation; History, Theory and Criticism of Architecture and Art; and Art, Culture, and Technology. Each provides an architectural education that is as complex as the field itself, and all five contribute to a mutual enterprise. The department also has specialized graduate programs such as the Aga Khan Program for Islamic Architecture and the SMArchS Program Architecture and Urbanism.\r\n\r\nThe several disciplines of the Department house a substantial body of research activity. Moreover, the Department''s setting within MIT permits greater depth in such technical areas as computation, new modes of design and production, materials, structure, and energy, as well as in the arts and humanities. The Department is committed to a concern for human values and for finding appropriate roles for architecture in society. It is a place where individual creativity is cultivated and nurtured in a framework of values that are humanistically, socially, and environmentally responsible.', 1, '2016-09-10 07:23:50', 1, '2016-09-10 07:23:50'),
(59, 40, 'Anthropology', 'aa@bvf.com', 10, '1vfnbjgfbgf', ' bngfngfn', 1, '2016-09-20 13:42:33', 1, '2016-09-20 13:42:33'),
(60, 41, 'Anthropology', 'aa@bvf.com', 10, '1vfnbjgfbgf', 'ghgfh', 1, '2016-09-20 14:52:45', 1, '2016-09-20 14:52:45'),
(61, 42, 'bbfgb', 'nhnhn@nhjn.con', 110, 'gnfbnfgnfgnhg', 'vdsvsdvs', 1, '2016-09-24 06:48:52', 1, '2016-09-24 06:48:52'),
(62, 43, 'bbfgb', 'nhnhn@nhjn.con', 110, 'gnfbnfgnfgnhg', 'sacsac', 1, '2016-09-23 18:41:45', 1, '2016-09-23 18:41:45'),
(80, 43, 'test', 'nhnhn@nhjn.con', 110, 'gnfbnfgnfgnhg', 'vbvb', 1, '2016-09-23 18:41:45', 1, '2016-09-23 18:41:45');

-- --------------------------------------------------------

--
-- Table structure for table `university_notifications`
--

CREATE TABLE IF NOT EXISTS `university_notifications` (
  `id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `from_role` int(11) NOT NULL,
  `message` text NOT NULL,
  `timestamp` datetime NOT NULL,
  `read` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `auth_key` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `degree_preference` int(11) NOT NULL,
  `majors_preference` varchar(100) NOT NULL,
  `country_preference` varchar(100) NOT NULL,
  `country` int(11) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id`, `email`, `auth_key`, `password_hash`, `password_reset_token`, `degree_preference`, `majors_preference`, `country_preference`, `country`, `status`, `created_at`, `updated_at`, `created_by`, `updated_by`, `role_id`) VALUES
(4, 'gotouniversity.super@gmail.com', '6s25Dn5UbMYQsLxFDk51cS8MlaJPK-T6', '$2y$13$YYtnchsNil6ALhYZZW113.Vpuv1.sRaYcyIo0.mMZWvx6Z6tCGzqu', NULL, 2, '1', '1', 4, 10, '2016-10-10 10:12:36', '2016-10-10 10:12:36', NULL, NULL, 4),
(5, 'gotouniversity.student@gmail.com', 'mqeSBRRwRGofo-MIzANfe6195B1IIoDI', '$2y$13$kP4rYcTB9kiYaJ1qdjQiXu7BebJdoDn8by9qQIap6aGbKnPFuHlXS', NULL, 2, '1,2', '3,1,2,4', 4, 10, '2016-10-11 08:58:16', '2016-10-11 08:58:16', NULL, NULL, 4),
(6, 'rddh2804@gmail.com', 'nHgRJo6hLP7lCL27k2y4l7awANtRbuEA', '$2y$13$rZPnSjmK/IfuExyIcHBfF.pOO5zXWsHtddwGneLtqLrtaJObNFYLG', NULL, 2, '1,3', '1,2,3,4,5,6,7', 4, 10, '2016-10-11 18:55:37', '2016-10-11 18:55:37', NULL, NULL, 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`), ADD KEY `student` (`from_id`);

--
-- Indexes for table `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`), ADD KEY `country_id` (`country_id`), ADD KEY `state_id` (`state_id`), ADD KEY `id` (`id`), ADD KEY `id_2` (`id`), ADD KEY `id_3` (`id`);

--
-- Indexes for table `consultant`
--
ALTER TABLE `consultant`
  ADD PRIMARY KEY (`id`), ADD KEY `country` (`country`);

--
-- Indexes for table `consultant_calendar`
--
ALTER TABLE `consultant_calendar`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`consultant_id`);

--
-- Indexes for table `consultant_notifications`
--
ALTER TABLE `consultant_notifications`
  ADD PRIMARY KEY (`id`), ADD KEY `srm_id` (`consultant_id`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`), ADD KEY `id` (`id`);

--
-- Indexes for table `degree`
--
ALTER TABLE `degree`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`), ADD UNIQUE KEY `name_2` (`name`,`type`);

--
-- Indexes for table `degree_level`
--
ALTER TABLE `degree_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`), ADD KEY `state` (`state`), ADD KEY `country` (`country`), ADD KEY `employee_id` (`employee_id`);

--
-- Indexes for table `employee_login`
--
ALTER TABLE `employee_login`
  ADD PRIMARY KEY (`id`), ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `others`
--
ALTER TABLE `others`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `partner`
--
ALTER TABLE `partner`
  ADD PRIMARY KEY (`id`), ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `partner_login`
--
ALTER TABLE `partner_login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `srm`
--
ALTER TABLE `srm`
  ADD PRIMARY KEY (`id`), ADD KEY `country` (`country`);

--
-- Indexes for table `srm_calendar`
--
ALTER TABLE `srm_calendar`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`srm_id`);

--
-- Indexes for table `srm_notifications`
--
ALTER TABLE `srm_notifications`
  ADD PRIMARY KEY (`id`), ADD KEY `srm_id` (`srm_id`);

--
-- Indexes for table `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`), ADD KEY `country_id` (`country_id`), ADD KEY `id` (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`), ADD KEY `city` (`city`), ADD KEY `city_2` (`city`), ADD KEY `city_3` (`city`), ADD KEY `country` (`country`), ADD KEY `state` (`state`), ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_calendar`
--
ALTER TABLE `student_calendar`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_college_detail`
--
ALTER TABLE `student_college_detail`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_english_language_proficiencey_details`
--
ALTER TABLE `student_english_language_proficiencey_details`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_notifications`
--
ALTER TABLE `student_notifications`
  ADD PRIMARY KEY (`id`), ADD KEY `srm_id` (`student_id`);

--
-- Indexes for table `student_school_detail`
--
ALTER TABLE `student_school_detail`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_srm_relation`
--
ALTER TABLE `student_srm_relation`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`), ADD KEY `srm_id` (`srm_id`);

--
-- Indexes for table `student_standard_test_detail`
--
ALTER TABLE `student_standard_test_detail`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_subject_detail`
--
ALTER TABLE `student_subject_detail`
  ADD PRIMARY KEY (`id`), ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `student_univeristy_application`
--
ALTER TABLE `student_univeristy_application`
  ADD PRIMARY KEY (`id`), ADD KEY `status` (`status`), ADD KEY `student_id` (`student_id`), ADD KEY `srm_id` (`srm_id`), ADD KEY `consultant_id` (`consultant_id`), ADD KEY `consultant_id_2` (`consultant_id`), ADD KEY `university_id` (`university_id`), ADD KEY `course_id` (`course_id`), ADD KEY `status_2` (`status`);

--
-- Indexes for table `university`
--
ALTER TABLE `university`
  ADD PRIMARY KEY (`id`), ADD KEY `city_id` (`city_id`), ADD KEY `state_id` (`state_id`), ADD KEY `country_id` (`country_id`), ADD KEY `city_id_2` (`city_id`), ADD KEY `city_id_3` (`city_id`), ADD KEY `city_id_4` (`city_id`), ADD KEY `state_id_2` (`state_id`), ADD KEY `country_id_2` (`country_id`);

--
-- Indexes for table `university_admission`
--
ALTER TABLE `university_admission`
  ADD PRIMARY KEY (`id`), ADD KEY `university_index` (`university_id`), ADD KEY `degree_level_index` (`degree_level_id`);

--
-- Indexes for table `university_course_list`
--
ALTER TABLE `university_course_list`
  ADD PRIMARY KEY (`id`), ADD KEY `university_id_2` (`university_id`), ADD KEY `degree_id_2` (`degree_id`), ADD KEY `major_id_2` (`major_id`), ADD KEY `major_id_3` (`major_id`), ADD KEY `department_id_2` (`department_id`);

--
-- Indexes for table `university_departments`
--
ALTER TABLE `university_departments`
  ADD PRIMARY KEY (`id`), ADD KEY `university_id` (`university_id`), ADD KEY `university_id_2` (`university_id`);

--
-- Indexes for table `university_notifications`
--
ALTER TABLE `university_notifications`
  ADD PRIMARY KEY (`id`), ADD KEY `srm_id` (`university_id`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `email` (`email`), ADD UNIQUE KEY `password_reset_token` (`password_reset_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `consultant`
--
ALTER TABLE `consultant`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `consultant_calendar`
--
ALTER TABLE `consultant_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `consultant_notifications`
--
ALTER TABLE `consultant_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `degree`
--
ALTER TABLE `degree`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `degree_level`
--
ALTER TABLE `degree_level`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `employee_login`
--
ALTER TABLE `employee_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `partner`
--
ALTER TABLE `partner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `partner_login`
--
ALTER TABLE `partner_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `srm`
--
ALTER TABLE `srm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `srm_calendar`
--
ALTER TABLE `srm_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `srm_notifications`
--
ALTER TABLE `srm_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `student_calendar`
--
ALTER TABLE `student_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `student_college_detail`
--
ALTER TABLE `student_college_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `student_english_language_proficiencey_details`
--
ALTER TABLE `student_english_language_proficiencey_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `student_notifications`
--
ALTER TABLE `student_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `student_school_detail`
--
ALTER TABLE `student_school_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `student_srm_relation`
--
ALTER TABLE `student_srm_relation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `student_standard_test_detail`
--
ALTER TABLE `student_standard_test_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `student_subject_detail`
--
ALTER TABLE `student_subject_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `student_univeristy_application`
--
ALTER TABLE `student_univeristy_application`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `university`
--
ALTER TABLE `university`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=44;
--
-- AUTO_INCREMENT for table `university_admission`
--
ALTER TABLE `university_admission`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `university_course_list`
--
ALTER TABLE `university_course_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=185;
--
-- AUTO_INCREMENT for table `university_departments`
--
ALTER TABLE `university_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `university_notifications`
--
ALTER TABLE `university_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `city`
--
ALTER TABLE `city`
ADD CONSTRAINT `add country foreign key` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`),
ADD CONSTRAINT `add state foreign key` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`);

--
-- Constraints for table `consultant_calendar`
--
ALTER TABLE `consultant_calendar`
ADD CONSTRAINT `consultant partner foreign key` FOREIGN KEY (`consultant_id`) REFERENCES `partner_login` (`id`);

--
-- Constraints for table `consultant_notifications`
--
ALTER TABLE `consultant_notifications`
ADD CONSTRAINT `notifications consultant fk` FOREIGN KEY (`consultant_id`) REFERENCES `partner_login` (`id`);

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
ADD CONSTRAINT `country foreign key` FOREIGN KEY (`country`) REFERENCES `country` (`id`),
ADD CONSTRAINT `employee foreign key` FOREIGN KEY (`employee_id`) REFERENCES `employee_login` (`id`),
ADD CONSTRAINT `state foreign key` FOREIGN KEY (`state`) REFERENCES `state` (`id`);

--
-- Constraints for table `partner`
--
ALTER TABLE `partner`
ADD CONSTRAINT `partner fk` FOREIGN KEY (`partner_id`) REFERENCES `partner_login` (`id`);

--
-- Constraints for table `srm_calendar`
--
ALTER TABLE `srm_calendar`
ADD CONSTRAINT `srm employee foreign key` FOREIGN KEY (`srm_id`) REFERENCES `employee_login` (`id`);

--
-- Constraints for table `srm_notifications`
--
ALTER TABLE `srm_notifications`
ADD CONSTRAINT `notifications srm fk` FOREIGN KEY (`srm_id`) REFERENCES `employee_login` (`id`);

--
-- Constraints for table `state`
--
ALTER TABLE `state`
ADD CONSTRAINT `foreign key constraint` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
ADD CONSTRAINT `country` FOREIGN KEY (`country`) REFERENCES `country` (`id`),
ADD CONSTRAINT `state` FOREIGN KEY (`state`) REFERENCES `state` (`id`),
ADD CONSTRAINT `student foreign key` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

--
-- Constraints for table `student_calendar`
--
ALTER TABLE `student_calendar`
ADD CONSTRAINT `student calendar fk` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

--
-- Constraints for table `student_college_detail`
--
ALTER TABLE `student_college_detail`
ADD CONSTRAINT `student college fk` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

--
-- Constraints for table `student_english_language_proficiencey_details`
--
ALTER TABLE `student_english_language_proficiencey_details`
ADD CONSTRAINT `student_foreign_key` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

--
-- Constraints for table `student_notifications`
--
ALTER TABLE `student_notifications`
ADD CONSTRAINT `notifications student fk` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

--
-- Constraints for table `student_school_detail`
--
ALTER TABLE `student_school_detail`
ADD CONSTRAINT `student_foreign_key_1` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

--
-- Constraints for table `student_srm_relation`
--
ALTER TABLE `student_srm_relation`
ADD CONSTRAINT `srm fk` FOREIGN KEY (`srm_id`) REFERENCES `employee_login` (`id`),
ADD CONSTRAINT `student fk` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

--
-- Constraints for table `student_standard_test_detail`
--
ALTER TABLE `student_standard_test_detail`
ADD CONSTRAINT `student_foreign_key_2` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

--
-- Constraints for table `student_subject_detail`
--
ALTER TABLE `student_subject_detail`
ADD CONSTRAINT `student_foreign_key_3` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`);

--
-- Constraints for table `student_univeristy_application`
--
ALTER TABLE `student_univeristy_application`
ADD CONSTRAINT `consultant fk` FOREIGN KEY (`consultant_id`) REFERENCES `partner_login` (`id`),
ADD CONSTRAINT `course fk` FOREIGN KEY (`course_id`) REFERENCES `university_course_list` (`id`),
ADD CONSTRAINT `srm application fk` FOREIGN KEY (`srm_id`) REFERENCES `employee_login` (`id`),
ADD CONSTRAINT `student application fk` FOREIGN KEY (`student_id`) REFERENCES `user_login` (`id`),
ADD CONSTRAINT `university fk` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`);

--
-- Constraints for table `university`
--
ALTER TABLE `university`
ADD CONSTRAINT `city fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
ADD CONSTRAINT `country fk` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`),
ADD CONSTRAINT `state fk` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`);

--
-- Constraints for table `university_admission`
--
ALTER TABLE `university_admission`
ADD CONSTRAINT `degree` FOREIGN KEY (`degree_level_id`) REFERENCES `degree_level` (`id`),
ADD CONSTRAINT `university` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`);

--
-- Constraints for table `university_course_list`
--
ALTER TABLE `university_course_list`
ADD CONSTRAINT `degree foreign key` FOREIGN KEY (`degree_id`) REFERENCES `degree` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `department_foreign_key` FOREIGN KEY (`department_id`) REFERENCES `university_departments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `major foreign key` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `university foreign key` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `university_departments`
--
ALTER TABLE `university_departments`
ADD CONSTRAINT `university_foreign_key` FOREIGN KEY (`university_id`) REFERENCES `university` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `university_notifications`
--
ALTER TABLE `university_notifications`
ADD CONSTRAINT `notifications university fk` FOREIGN KEY (`university_id`) REFERENCES `partner_login` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
