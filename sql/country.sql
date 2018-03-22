-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2017 at 04:16 PM
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
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `iso_code` varchar(5) NOT NULL,
  `phone_code` varchar(15) NOT NULL,
  `created_by` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_by` varchar(100) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `name`, `iso_code`, `phone_code`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES
(1, 'United States of America', 'US', '1', NULL, NULL, NULL, NULL),
(2, 'Afghanistan', 'AF', '93', NULL, NULL, NULL, NULL),
(3, 'Albania', 'AL', '355', NULL, NULL, NULL, NULL),
(4, 'Algeria', 'DZ', '213', NULL, NULL, NULL, NULL),
(5, 'Andorra', 'AD', '376', NULL, NULL, NULL, NULL),
(6, 'Angola', 'AO', '244', NULL, NULL, NULL, NULL),
(7, 'Antarctica', 'AQ', '672', NULL, NULL, NULL, NULL),
(8, 'Argentina', 'AR', '54', NULL, NULL, NULL, NULL),
(9, 'Armenia', 'AM', '374', NULL, NULL, NULL, NULL),
(10, 'Aruba', 'AW', '297', NULL, NULL, NULL, NULL),
(11, 'Australia', 'AU', '61', NULL, NULL, NULL, NULL),
(12, 'Austria', 'AT', '43', NULL, NULL, NULL, NULL),
(13, 'Azerbaijan', 'AZ', '994', NULL, NULL, NULL, NULL),
(14, 'Bahrain', 'BH', '973', NULL, NULL, NULL, NULL),
(15, 'Bangladesh', 'BD', '880', NULL, NULL, NULL, NULL),
(16, 'Belarus', 'BY', '375', NULL, NULL, NULL, NULL),
(17, 'Belgium', 'BE', '32', NULL, NULL, NULL, NULL),
(18, 'Belize', 'BZ', '501', NULL, NULL, NULL, NULL),
(19, 'Benin', 'BJ', '229', NULL, NULL, NULL, NULL),
(20, 'Bhutan', 'BT', '975', NULL, NULL, NULL, NULL),
(21, 'Bolivia', 'BO', '591', NULL, NULL, NULL, NULL),
(22, 'Bosnia and Herzegovina', 'BA', '387', NULL, NULL, NULL, NULL),
(23, 'Botswana', 'BW', '267', NULL, NULL, NULL, NULL),
(24, 'Brazil', 'BR', '55', NULL, NULL, NULL, NULL),
(25, 'British Indian Ocean Territory', 'IO', '246', NULL, NULL, NULL, NULL),
(26, 'Brunei', 'BN', '673', NULL, NULL, NULL, NULL),
(27, 'Bulgaria', 'BG', '359', NULL, NULL, NULL, NULL),
(28, 'Burkina Faso', 'BF', '226', NULL, NULL, NULL, NULL),
(29, 'Burundi', 'BI', '257', NULL, NULL, NULL, NULL),
(30, 'Cambodia', 'KH', '855', NULL, NULL, NULL, NULL),
(31, 'Cameroon', 'CM', '237', NULL, NULL, NULL, NULL),
(32, 'Canada', 'CA', '1', NULL, NULL, NULL, NULL),
(33, 'Cape Verde', 'CV', '238', NULL, NULL, NULL, NULL),
(34, 'Central African Republic', 'CF', '236', NULL, NULL, NULL, NULL),
(35, 'Chad', 'TD', '235', NULL, NULL, NULL, NULL),
(36, 'Chile', 'CL', '56', NULL, NULL, NULL, NULL),
(37, 'China', 'CN', '86', NULL, NULL, NULL, NULL),
(38, 'Christmas Island', 'CX', '61', NULL, NULL, NULL, NULL),
(39, 'Cocos Islands', 'CC', '61', NULL, NULL, NULL, NULL),
(40, 'Colombia', 'CO', '57', NULL, NULL, NULL, NULL),
(41, 'Comoros', 'KM', '269', NULL, NULL, NULL, NULL),
(42, 'Cook Islands', 'CK', '682', NULL, NULL, NULL, NULL),
(43, 'Costa Rica', 'CR', '506', NULL, NULL, NULL, NULL),
(44, 'Croatia', 'HR', '385', NULL, NULL, NULL, NULL),
(45, 'Cuba', 'CU', '53', NULL, NULL, NULL, NULL),
(46, 'Curacao', 'CW', '599', NULL, NULL, NULL, NULL),
(47, 'Cyprus', 'CY', '357', NULL, NULL, NULL, NULL),
(48, 'Czech Republic', 'CZ', '420', NULL, NULL, NULL, NULL),
(49, 'Democratic Republic of the Congo', 'CD', '243', NULL, NULL, NULL, NULL),
(50, 'Denmark', 'DK', '45', NULL, NULL, NULL, NULL),
(51, 'Djibouti', 'DJ', '253', NULL, NULL, NULL, NULL),
(52, 'East Timor', 'TL', '670', NULL, NULL, NULL, NULL),
(53, 'Ecuador', 'EC', '593', NULL, NULL, NULL, NULL),
(54, 'Egypt', 'EG', '20', NULL, NULL, NULL, NULL),
(55, 'El Salvador', 'SV', '503', NULL, NULL, NULL, NULL),
(56, 'Equatorial Guinea', 'GQ', '240', NULL, NULL, NULL, NULL),
(57, 'Eritrea', 'ER', '291', NULL, NULL, NULL, NULL),
(58, 'Estonia', 'EE', '372', NULL, NULL, NULL, NULL),
(59, 'Ethiopia', 'ET', '251', NULL, NULL, NULL, NULL),
(60, 'Falkland Islands', 'FK', '500', NULL, NULL, NULL, NULL),
(61, 'Faroe Islands', 'FO', '298', NULL, NULL, NULL, NULL),
(62, 'Fiji', 'FJ', '679', NULL, NULL, NULL, NULL),
(63, 'Finland', 'FI', '358', NULL, NULL, NULL, NULL),
(64, 'France', 'FR', '33', NULL, NULL, NULL, NULL),
(65, 'French Polynesia', 'PF', '689', NULL, NULL, NULL, NULL),
(66, 'Gabon', 'GA', '241', NULL, NULL, NULL, NULL),
(67, 'Gambia', 'GM', '220', NULL, NULL, NULL, NULL),
(68, 'Georgia', 'GE', '995', NULL, NULL, NULL, NULL),
(69, 'Germany', 'DE', '49', NULL, NULL, NULL, NULL),
(70, 'Ghana', 'GH', '233', NULL, NULL, NULL, NULL),
(71, 'Gibraltar', 'GI', '350', NULL, NULL, NULL, NULL),
(72, 'Greece', 'GR', '30', NULL, NULL, NULL, NULL),
(73, 'Greenland', 'GL', '299', NULL, NULL, NULL, NULL),
(74, 'Guatemala', 'GT', '502', NULL, NULL, NULL, NULL),
(75, 'Guinea', 'GN', '224', NULL, NULL, NULL, NULL),
(76, 'Guinea-Bissau', 'GW', '245', NULL, NULL, NULL, NULL),
(77, 'Guyana', 'GY', '592', NULL, NULL, NULL, NULL),
(78, 'Haiti', 'HT', '509', NULL, NULL, NULL, NULL),
(79, 'Honduras', 'HN', '504', NULL, NULL, NULL, NULL),
(80, 'Hong Kong', 'HK', '852', NULL, NULL, NULL, NULL),
(81, 'Hungary', 'HU', '36', NULL, NULL, NULL, NULL),
(82, 'Iceland', 'IS', '354', NULL, NULL, NULL, NULL),
(83, 'India', 'IN', '91', NULL, NULL, NULL, NULL),
(84, 'Indonesia', 'ID', '62', NULL, NULL, NULL, NULL),
(85, 'Iran', 'IR', '98', NULL, NULL, NULL, NULL),
(86, 'Iraq', 'IQ', '964', NULL, NULL, NULL, NULL),
(87, 'Ireland', 'IE', '353', NULL, NULL, NULL, NULL),
(88, 'Israel', 'IL', '972', NULL, NULL, NULL, NULL),
(89, 'Italy', 'IT', '39', NULL, NULL, NULL, NULL),
(90, 'Ivory Coast', 'CI', '225', NULL, NULL, NULL, NULL),
(91, 'Japan', 'JP', '81', NULL, NULL, NULL, NULL),
(92, 'Jordan', 'JO', '962', NULL, NULL, NULL, NULL),
(93, 'Kazakhstan', 'KZ', '7', NULL, NULL, NULL, NULL),
(94, 'Kenya', 'KE', '254', NULL, NULL, NULL, NULL),
(95, 'Kiribati', 'KI', '686', NULL, NULL, NULL, NULL),
(96, 'Kosovo', 'XK', '383', NULL, NULL, NULL, NULL),
(97, 'Kuwait', 'KW', '965', NULL, NULL, NULL, NULL),
(98, 'Kyrgyzstan', 'KG', '996', NULL, NULL, NULL, NULL),
(99, 'Laos', 'LA', '856', NULL, NULL, NULL, NULL),
(100, 'Latvia', 'LV', '371', NULL, NULL, NULL, NULL),
(101, 'Lebanon', 'LB', '961', NULL, NULL, NULL, NULL),
(102, 'Lesotho', 'LS', '266', NULL, NULL, NULL, NULL),
(103, 'Liberia', 'LR', '231', NULL, NULL, NULL, NULL),
(104, 'Libya', 'LY', '218', NULL, NULL, NULL, NULL),
(105, 'Liechtenstein', 'LI', '423', NULL, NULL, NULL, NULL),
(106, 'Lithuania', 'LT', '370', NULL, NULL, NULL, NULL),
(107, 'Luxembourg', 'LU', '352', NULL, NULL, NULL, NULL),
(108, 'Macau', 'MO', '853', NULL, NULL, NULL, NULL),
(109, 'Macedonia', 'MK', '389', NULL, NULL, NULL, NULL),
(110, 'Madagascar', 'MG', '261', NULL, NULL, NULL, NULL),
(111, 'Malawi', 'MW', '265', NULL, NULL, NULL, NULL),
(112, 'Malaysia', 'MY', '60', NULL, NULL, NULL, NULL),
(113, 'Maldives', 'MV', '960', NULL, NULL, NULL, NULL),
(114, 'Mali', 'ML', '223', NULL, NULL, NULL, NULL),
(115, 'Malta', 'MT', '356', NULL, NULL, NULL, NULL),
(116, 'Marshall Islands', 'MH', '692', NULL, NULL, NULL, NULL),
(117, 'Mauritania', 'MR', '222', NULL, NULL, NULL, NULL),
(118, 'Mauritius', 'MU', '230', NULL, NULL, NULL, NULL),
(119, 'Mayotte', 'YT', '262', NULL, NULL, NULL, NULL),
(120, 'Mexico', 'MX', '52', NULL, NULL, NULL, NULL),
(121, 'Micronesia', 'FM', '691', NULL, NULL, NULL, NULL),
(122, 'Moldova', 'MD', '373', NULL, NULL, NULL, NULL),
(123, 'Monaco', 'MC', '377', NULL, NULL, NULL, NULL),
(124, 'Mongolia', 'MN', '976', NULL, NULL, NULL, NULL),
(125, 'Montenegro', 'ME', '382', NULL, NULL, NULL, NULL),
(126, 'Morocco', 'MA', '212', NULL, NULL, NULL, NULL),
(127, 'Mozambique', 'MZ', '258', NULL, NULL, NULL, NULL),
(128, 'Myanmar', 'MM', '95', NULL, NULL, NULL, NULL),
(129, 'Namibia', 'NA', '264', NULL, NULL, NULL, NULL),
(130, 'Nauru', 'NR', '674', NULL, NULL, NULL, NULL),
(131, 'Nepal', 'NP', '977', NULL, NULL, NULL, NULL),
(132, 'Netherlands', 'NL', '31', NULL, NULL, NULL, NULL),
(133, 'Netherlands Antilles', 'AN', '599', NULL, NULL, NULL, NULL),
(134, 'New Caledonia', 'NC', '687', NULL, NULL, NULL, NULL),
(135, 'New Zealand', 'NZ', '64', NULL, NULL, NULL, NULL),
(136, 'Nicaragua', 'NI', '505', NULL, NULL, NULL, NULL),
(137, 'Niger', 'NE', '227', NULL, NULL, NULL, NULL),
(138, 'Nigeria', 'NG', '234', NULL, NULL, NULL, NULL),
(139, 'Niue', 'NU', '683', NULL, NULL, NULL, NULL),
(140, 'North Korea', 'KP', '850', NULL, NULL, NULL, NULL),
(141, 'Norway', 'NO', '47', NULL, NULL, NULL, NULL),
(142, 'Oman', 'OM', '968', NULL, NULL, NULL, NULL),
(143, 'Pakistan', 'PK', '92', NULL, NULL, NULL, NULL),
(144, 'Palau', 'PW', '680', NULL, NULL, NULL, NULL),
(145, 'Palestine', 'PS', '970', NULL, NULL, NULL, NULL),
(146, 'Panama', 'PA', '507', NULL, NULL, NULL, NULL),
(147, 'Papua New Guinea', 'PG', '675', NULL, NULL, NULL, NULL),
(148, 'Paraguay', 'PY', '595', NULL, NULL, NULL, NULL),
(149, 'Peru', 'PE', '51', NULL, NULL, NULL, NULL),
(150, 'Philippines', 'PH', '63', NULL, NULL, NULL, NULL),
(151, 'Pitcairn', 'PN', '64', NULL, NULL, NULL, NULL),
(152, 'Poland', 'PL', '48', NULL, NULL, NULL, NULL),
(153, 'Portugal', 'PT', '351', NULL, NULL, NULL, NULL),
(154, 'Qatar', 'QA', '974', NULL, NULL, NULL, NULL),
(155, 'Republic of the Congo', 'CG', '242', NULL, NULL, NULL, NULL),
(156, 'Reunion', 'RE', '262', NULL, NULL, NULL, NULL),
(157, 'Romania', 'RO', '40', NULL, NULL, NULL, NULL),
(158, 'Russia', 'RU', '7', NULL, NULL, NULL, NULL),
(159, 'Rwanda', 'RW', '250', NULL, NULL, NULL, NULL),
(160, 'Saint Barthelemy', 'BL', '590', NULL, NULL, NULL, NULL),
(161, 'Saint Helena', 'SH', '290', NULL, NULL, NULL, NULL),
(162, 'Saint Martin', 'MF', '590', NULL, NULL, NULL, NULL),
(163, 'Saint Pierre and Miquelon', 'PM', '508', NULL, NULL, NULL, NULL),
(164, 'Samoa', 'WS', '685', NULL, NULL, NULL, NULL),
(165, 'San Marino', 'SM', '378', NULL, NULL, NULL, NULL),
(166, 'Sao Tome and Principe', 'ST', '239', NULL, NULL, NULL, NULL),
(167, 'Saudi Arabia', 'SA', '966', NULL, NULL, NULL, NULL),
(168, 'Senegal', 'SN', '221', NULL, NULL, NULL, NULL),
(169, 'Serbia', 'RS', '381', NULL, NULL, NULL, NULL),
(170, 'Seychelles', 'SC', '248', NULL, NULL, NULL, NULL),
(171, 'Sierra Leone', 'SL', '232', NULL, NULL, NULL, NULL),
(172, 'Singapore', 'SG', '65', NULL, NULL, NULL, NULL),
(173, 'Slovakia', 'SK', '421', NULL, NULL, NULL, NULL),
(174, 'Slovenia', 'SI', '386', NULL, NULL, NULL, NULL),
(175, 'Solomon Islands', 'SB', '677', NULL, NULL, NULL, NULL),
(176, 'Somalia', 'SO', '252', NULL, NULL, NULL, NULL),
(177, 'South Africa', 'ZA', '27', NULL, NULL, NULL, NULL),
(178, 'South Korea', 'KR', '82', NULL, NULL, NULL, NULL),
(179, 'South Sudan', 'SS', '211', NULL, NULL, NULL, NULL),
(180, 'Spain', 'ES', '34', NULL, NULL, NULL, NULL),
(181, 'Sri Lanka', 'LK', '94', NULL, NULL, NULL, NULL),
(182, 'Sudan', 'SD', '249', NULL, NULL, NULL, NULL),
(183, 'Suriname', 'SR', '597', NULL, NULL, NULL, NULL),
(184, 'Svalbard and Jan Mayen', 'SJ', '47', NULL, NULL, NULL, NULL),
(185, 'Swaziland', 'SZ', '268', NULL, NULL, NULL, NULL),
(186, 'Sweden', 'SE', '46', NULL, NULL, NULL, NULL),
(187, 'Switzerland', 'CH', '41', NULL, NULL, NULL, NULL),
(188, 'Syria', 'SY', '963', NULL, NULL, NULL, NULL),
(189, 'Taiwan', 'TW', '886', NULL, NULL, NULL, NULL),
(190, 'Tajikistan', 'TJ', '992', NULL, NULL, NULL, NULL),
(191, 'Tanzania', 'TZ', '255', NULL, NULL, NULL, NULL),
(192, 'Thailand', 'TH', '66', NULL, NULL, NULL, NULL),
(193, 'Togo', 'TG', '228', NULL, NULL, NULL, NULL),
(194, 'Tokelau', 'TK', '690', NULL, NULL, NULL, NULL),
(195, 'Tonga', 'TO', '676', NULL, NULL, NULL, NULL),
(196, 'Tunisia', 'TN', '216', NULL, NULL, NULL, NULL),
(197, 'Turkey', 'TR', '90', NULL, NULL, NULL, NULL),
(198, 'Turkmenistan', 'TM', '993', NULL, NULL, NULL, NULL),
(199, 'Tuvalu', 'TV', '688', NULL, NULL, NULL, NULL),
(200, 'Uganda', 'UG', '256', NULL, NULL, NULL, NULL),
(201, 'Ukraine', 'UA', '380', NULL, NULL, NULL, NULL),
(202, 'United Arab Emirates', 'AE', '971', NULL, NULL, NULL, NULL),
(203, 'Uruguay', 'UY', '598', NULL, NULL, NULL, NULL),
(204, 'Uzbekistan', 'UZ', '998', NULL, NULL, NULL, NULL),
(205, 'Vanuatu', 'VU', '678', NULL, NULL, NULL, NULL),
(206, 'Vatican', 'VA', '379', NULL, NULL, NULL, NULL),
(207, 'Venezuela', 'VE', '58', NULL, NULL, NULL, NULL),
(208, 'Vietnam', 'VN', '84', NULL, NULL, NULL, NULL),
(209, 'Wallis and Futuna', 'WF', '681', NULL, NULL, NULL, NULL),
(210, 'Western Sahara', 'EH', '212', NULL, NULL, NULL, NULL),
(211, 'Yemen', 'YE', '967', NULL, NULL, NULL, NULL),
(212, 'Zambia', 'ZM', '260', NULL, NULL, NULL, NULL),
(213, 'Zimbabwe', 'ZW', '263', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=256;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
