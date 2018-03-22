-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 23, 2017 at 09:17 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.5.38

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
-- Table structure for table `university_course_list`
--

CREATE TABLE `university_course_list` (
  `id` int(11) NOT NULL,
  `program_code` varchar(50) NOT NULL,
  `university_id` int(11) NOT NULL,
  `degree_id` int(11) NOT NULL,
  `major_id` int(11) NOT NULL,
  `degree_level_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` mediumtext,
  `intake` int(11) DEFAULT NULL,
  `language` int(50) DEFAULT NULL,
  `fees` int(11) DEFAULT NULL,
  `fees_international_students` int(11) DEFAULT NULL,
  `duration` decimal(2,1) DEFAULT NULL,
  `duration_type` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `standard_test_list` varchar(50) DEFAULT NULL,
  `application_fees` int(11) DEFAULT NULL,
  `application_fees_international` int(11) DEFAULT NULL,
  `careers` text,
  `eligibility_criteria` text,
  `program_website` varchar(255) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_by` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `university_course_list`
--

INSERT INTO `university_course_list` (`id`, `program_code`, `university_id`, `degree_id`, `major_id`, `degree_level_id`, `name`, `description`, `intake`, `language`, `fees`, `fees_international_students`, `duration`, `duration_type`, `type`, `standard_test_list`, `application_fees`, `application_fees_international`, `careers`, `eligibility_criteria`, `program_website`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, '1485202531', 569, 6, 89, 1, 'BSc in Electrical Engineering', 'The undergraduate degree offered by the Department is the Bachelor of Science in Electrical Engineering (BSEE), a four year degree program. The program provides the scope of knowledge and training needed for employment and also forms the basis for further study at the graduate level. Our BSEE program is fully accredited by the Accreditation Board of Engineering and Technology (ABET).The BSEE curriculum includes math, science, and basic engineering courses in the freshman and sophomore Years, required electrical engineering courses in the junior and senior Years, and technical elective courses in the senior year. As there are many similarities during the first year of all engineering disciplines'' curricula, students can transfer among engineering majors fairly easily in the freshman year. Students also have considerable flexibility in the selection of technical elective courses, allowing them to specialize in an electrical engineering sub-discipline. Also available to interested students are several work-experience courses (internships and engineering co-op).', NULL, 1, 3235, 11855, '4.0', 2, 0, '5,6', 50, 50, 'Aerospace engineer,Broadcast engineer,Control and instrumentation engineer,Electrical engineer,Electronics engineer', 'Aerospace engineer,Broadcast engineer,Control and instrumentation engineer,Electrical engineer,Electronics engineer', 'https://engineering.buffalo.edu/electrical/academics/bachelors_ee.html', '1', '2017-01-23 20:15:30', '1', '2017-01-23 20:15:30'),
(2, '1485202532', 569, 6, 89, 1, 'BSc in Electrical Engineering 2', 'The undergraduate degree offered by the Department is the Bachelor of Science in Electrical Engineering (BSEE), a four year degree program. The program provides the scope of knowledge and training needed for employment and also forms the basis for further study at the graduate level. Our BSEE program is fully accredited by the Accreditation Board of Engineering and Technology (ABET).The BSEE curriculum includes math, science, and basic engineering courses in the freshman and sophomore Years, required electrical engineering courses in the junior and senior Years, and technical elective courses in the senior year. As there are many similarities during the first year of all engineering disciplines'' curricula, students can transfer among engineering majors fairly easily in the freshman year. Students also have considerable flexibility in the selection of technical elective courses, allowing them to specialize in an electrical engineering sub-discipline. Also available to interested students are several work-experience courses (internships and engineering co-op).', NULL, 10, 3235, 11855, '4.0', 3, 5, '5,6', 50, 50, 'Aerospace engineer,Broadcast engineer,Control and instrumentation engineer,Electrical engineer,Electronics engineer', 'Aerospace engineer,Broadcast engineer,Control and instrumentation engineer,Electrical engineer,Electronics engineer', 'https://engineering.buffalo.edu/electrical/academics/bachelors_ee.html', '1', '2017-01-23 20:15:30', '1', '2017-01-23 20:15:30'),
(3, '1485202533', 569, 6, 89, 1, 'BSc in Electrical Engineering 3', 'The undergraduate degree offered by the Department is the Bachelor of Science in Electrical Engineering (BSEE), a four year degree program. The program provides the scope of knowledge and training needed for employment and also forms the basis for further study at the graduate level. Our BSEE program is fully accredited by the Accreditation Board of Engineering and Technology (ABET).The BSEE curriculum includes math, science, and basic engineering courses in the freshman and sophomore Years, required electrical engineering courses in the junior and senior Years, and technical elective courses in the senior year. As there are many similarities during the first year of all engineering disciplines'' curricula, students can transfer among engineering majors fairly easily in the freshman year. Students also have considerable flexibility in the selection of technical elective courses, allowing them to specialize in an electrical engineering sub-discipline. Also available to interested students are several work-experience courses (internships and engineering co-op).', NULL, 1, 3235, 11855, '4.0', 2, 0, '5,6', 50, 50, 'Aerospace engineer,Broadcast engineer,Control and instrumentation engineer,Electrical engineer,Electronics engineer', 'Aerospace engineer,Broadcast engineer,Control and instrumentation engineer,Electrical engineer,Electronics engineer', 'https://engineering.buffalo.edu/electrical/academics/bachelors_ee.html', '1', '2017-01-23 20:15:31', '1', '2017-01-23 20:15:31'),
(4, '1485202534', 569, 6, 89, 1, 'BSc in Electrical Engineering 4', 'The undergraduate degree offered by the Department is the Bachelor of Science in Electrical Engineering (BSEE), a four year degree program. The program provides the scope of knowledge and training needed for employment and also forms the basis for further study at the graduate level. Our BSEE program is fully accredited by the Accreditation Board of Engineering and Technology (ABET).The BSEE curriculum includes math, science, and basic engineering courses in the freshman and sophomore Years, required electrical engineering courses in the junior and senior Years, and technical elective courses in the senior year. As there are many similarities during the first year of all engineering disciplines'' curricula, students can transfer among engineering majors fairly easily in the freshman year. Students also have considerable flexibility in the selection of technical elective courses, allowing them to specialize in an electrical engineering sub-discipline. Also available to interested students are several work-experience courses (internships and engineering co-op).', NULL, 1, 3235, 11855, '4.0', 4, 5, '5,6', 50, 50, 'Aerospace engineer,Broadcast engineer,Control and instrumentation engineer,Electrical engineer,Electronics engineer', 'Aerospace engineer,Broadcast engineer,Control and instrumentation engineer,Electrical engineer,Electronics engineer', 'https://engineering.buffalo.edu/electrical/academics/bachelors_ee.html', '1', '2017-01-23 20:15:31', '1', '2017-01-23 20:15:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `university_course_list`
--
ALTER TABLE `university_course_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `program_code` (`program_code`),
  ADD KEY `university_id_2` (`university_id`),
  ADD KEY `degree_id_2` (`degree_id`),
  ADD KEY `major_id_2` (`major_id`),
  ADD KEY `major_id_3` (`major_id`),
  ADD KEY `department_id_2` (`degree_level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `university_course_list`
--
ALTER TABLE `university_course_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
