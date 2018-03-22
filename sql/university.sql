-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 01, 2017 at 10:54 AM
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
-- Table structure for table `university`
--

CREATE TABLE `university` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `is_partner` int(1) NOT NULL DEFAULT '0',
  `establishment_date` int(4) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country_id` int(11) NOT NULL,
  `pincode` varchar(11) NOT NULL,
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
  `currency_id` int(3) NOT NULL,
  `currency_international_id` int(3) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_by` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL,
  `reviewed_by` varchar(100) DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `university`
--
ALTER TABLE `university`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `country_id` (`country_id`),
  ADD KEY `currency` (`currency_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `university`
--
ALTER TABLE `university`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `university`
--
ALTER TABLE `university`
  ADD CONSTRAINT `city fk` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `country fk` FOREIGN KEY (`country_id`) REFERENCES `country` (`id`),
  ADD CONSTRAINT `currency fk` FOREIGN KEY (`currency_id`) REFERENCES `currency` (`id`),
  ADD CONSTRAINT `state fk` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
