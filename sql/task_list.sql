-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2017 at 02:41 PM
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
-- Table structure for table `task_list`
--

CREATE TABLE `task_list` (
  `id` int(11) NOT NULL,
  `task_category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `how_to_complete` text NOT NULL,
  `auto_assign` tinyint(1) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_list`
--

INSERT INTO `task_list` (`id`, `task_category_id`, `name`, `description`, `how_to_complete`, `auto_assign`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 1, 'Basic Information', '<p>a)&nbsp;&nbsp; &nbsp;First name and last/surname/family name as per passport<br />\r\nb)&nbsp;&nbsp; &nbsp;Date of Birth<br />\r\nc)&nbsp;&nbsp; &nbsp;City and country of Birth/ Nationality<br />\r\nd)&nbsp;&nbsp; &nbsp;Country of Residence<br />\r\ne)&nbsp;&nbsp; &nbsp;Home address and Mailing address<br />\r\nf)&nbsp;&nbsp; &nbsp;Student Contact Number: Mobile and Landline<br />\r\ng)&nbsp;&nbsp; &nbsp;Parents Contact Number: Mobile and Email address<br />\r\nh)&nbsp;&nbsp; &nbsp;Language Proficiency (Language: Basic &ndash; Intermediate - Fluent)</p>\r\n', '<p>Go to http://gotouniversity.com/</p>\r\n', 1, 'admin-employee_login', '2017-05-23 12:03:36', 'admin-employee_login', '2017-07-31 12:23:34'),
(2, 1, 'Academic Information', '<p>a)&nbsp;&nbsp; &nbsp;Name of the school:<br />\r\nb)&nbsp;&nbsp; &nbsp;School curriculum: (List curriculums in drop down list and provide option for &lsquo;others&rsquo;)<br />\r\nc)&nbsp;&nbsp; &nbsp;Start Date &ndash; End Date (Provide options to add multiple schools)<br />\r\nd)&nbsp;&nbsp; &nbsp;School address: (Street, City, State, Country, Pin code)<br />\r\ne)&nbsp;&nbsp; &nbsp;Academic subjects in current year: (Provide options to add multiple subjects)<br />\r\nf)&nbsp;&nbsp; &nbsp;School Counselor full name, last name, official email address, and contact number</p>\r\n\r\n<p>&nbsp;</p>\r\n', '<p>Go to http://gotouniversity.com/</p>\r\n', 0, 'admin-employee_login', '2017-05-23 12:05:35', 'admin-employee_login', '2017-07-31 12:11:59'),
(3, 1, 'Extra Curricular Profile', '<p>a)&nbsp;&nbsp; &nbsp;Type of activity (Provide drop down list for: Arts, sports, internship, volunteering/ community service, leadership, others)<br />\r\nb)&nbsp;&nbsp; &nbsp;Position (if applicable) &ndash; Text box<br />\r\nc)&nbsp;&nbsp; &nbsp;Brief description of responsibilities/ achievements (Text box)<br />\r\nd)&nbsp;&nbsp; &nbsp;Years of participation (Start date and end date/ present)</p>\r\n\r\n<p>&nbsp;</p>\r\n', '<p>Go to http://gotouniversity.com/</p>\r\n', 0, 'admin-employee_login', '2017-05-23 12:05:53', 'admin-employee_login', '2017-07-31 12:12:36'),
(4, 1, 'Employment History (if applicable)', '<p>a) Company Name:<br />\r\nb) Designation:<br />\r\nc) Date, From - To</p>\r\n', '', 0, 'admin-employee_login', '2017-05-23 12:06:07', 'admin-employee_login', '2017-07-31 12:18:44'),
(5, 2, 'Upload the documents', '', '', 0, 'admin-employee_login', '2017-07-31 11:16:10', 'admin-employee_login', '2017-07-31 11:16:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `task_list`
--
ALTER TABLE `task_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_category_id` (`task_category_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `task_list`
--
ALTER TABLE `task_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `task_list`
--
ALTER TABLE `task_list`
  ADD CONSTRAINT `task_list_ibfk_1` FOREIGN KEY (`task_category_id`) REFERENCES `task_category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
