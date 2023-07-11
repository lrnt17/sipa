-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 01, 2023 at 03:18 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `birth_controls`
--

CREATE TABLE `birth_controls` (
  `birth_control_id` int(5) NOT NULL,
  `birth_control_img` varchar(100) NOT NULL,
  `birth_control_name` varchar(50) NOT NULL,
  `birth_control_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `birth_controls`
--

INSERT INTO `birth_controls` (`birth_control_id`, `birth_control_img`, `birth_control_name`, `birth_control_desc`) VALUES
(1, 'sample.jpg', 'Patch', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n'),
(2, 'sample.jpg', 'Patch', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.'),
(3, 'sample.jpg', 'Patch', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n'),
(4, 'sample.jpg', 'Patch', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n'),
(5, 'sample.jpg', 'Patch', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `forum`
--

CREATE TABLE `forum` (
  `forum_id` int(5) NOT NULL,
  `user_id` int(5) NOT NULL,
  `forum_timestamp` datetime NOT NULL,
  `forum_title` varchar(200) NOT NULL,
  `forum_desc` varchar(500) NOT NULL,
  `comment_parent_id` int(11) NOT NULL DEFAULT 0,
  `comment_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `user_id`, `forum_timestamp`, `forum_title`, `forum_desc`, `comment_parent_id`, `comment_count`) VALUES
(3, 2, '2023-06-17 07:15:29', 'isa pa', 'post isa', 0, 0),
(5, 3, '2023-06-23 16:30:11', 'sakit sa ulo potaena', 'ihhhhhhhhhhhh\r\nohhhhhhhhh', 0, 6),
(6, 2, '2023-06-17 08:30:04', 'eto na talaga', 'plsss gumana ka na', 0, 0),
(7, 3, '2023-06-23 16:27:17', 'Gabriel forum 911', 'say hi guys', 0, 0),
(8, 2, '2023-06-17 11:11:50', '', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 0, 0),
(9, 3, '2023-06-28 19:33:52', 'meron ng title', 'wassup mga kaibigan!!! hakdog', 0, 1),
(10, 3, '2023-06-17 17:42:16', 'post ulit ni gabo', 'blah', 0, 0),
(11, 2, '2023-06-19 20:14:18', '', 'with eunice mika roly ngayong gabi', 0, 0),
(12, 3, '2023-06-22 16:54:57', 'I get COG in BSU today', 'nakaka pagod jusko grabe ba', 0, 4),
(13, 3, '2023-06-28 19:28:02', '1111 meron ng letters', '2222', 0, 2),
(17, 3, '2023-06-24 16:12:40', '', 'first comment', 13, 0),
(20, 3, '2023-06-24 16:41:59', '', 'sekund kumint', 13, 0),
(23, 3, '2023-06-24 17:03:09', '', 'anyare ba pre?', 12, 0),
(29, 3, '2023-06-24 18:46:00', '', 'pinaikot ikot pa ko langya', 12, 0),
(35, 3, '2023-06-24 19:00:22', '', 'panong pinaikot ikot ka? hilo yarn? HAHAHAHHAHAHAHA', 12, 0),
(38, 3, '2023-06-27 19:59:32', 'tonights meeting', 'waiting....', 0, 0),
(39, 3, '2023-06-28 10:51:59', 'meeting ngayon tapos na kagabi', 'usap usap lang tas thank you', 0, 1),
(40, 3, '2023-06-28 10:52:23', '', 'ganun lang???', 39, 0),
(41, 3, '2023-06-28 20:10:36', '', 'debugging ulit hays', 12, 0),
(43, 3, '2023-06-28 20:40:03', '', 'isipin mo yun tiger', 9, 0),
(45, 3, '2023-06-28 23:43:54', 'DAPAT NASA HULI ITO', 'mali pala post nga pala to so nasa top talaga sya hahaha sowi', 0, 0),
(53, 3, '2023-06-29 12:32:20', 'Yowwwwww', 'musta pare?', 0, 0),
(54, 3, '2023-06-29 12:41:48', '', '1', 5, 0),
(55, 3, '2023-06-29 12:41:53', '', '2', 5, 0),
(56, 3, '2023-06-29 12:42:00', '', '3', 5, 0),
(57, 3, '2023-06-29 12:42:04', '', '4', 5, 0),
(58, 3, '2023-06-29 12:42:06', '', '5', 5, 0),
(59, 3, '2023-06-29 12:45:20', '', '6', 5, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rating_info`
--

CREATE TABLE `rating_info` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `rating_action` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rating_info`
--

INSERT INTO `rating_info` (`user_id`, `post_id`, `rating_action`) VALUES
(2, 8, 'like'),
(3, 38, 'like'),
(3, 53, 'like');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(5) NOT NULL,
  `birth_control_id` int(5) DEFAULT NULL,
  `user_fname` varchar(30) NOT NULL,
  `user_lname` varchar(20) NOT NULL,
  `user_dob` date NOT NULL,
  `user_sex` varchar(11) NOT NULL,
  `user_image` varchar(100) DEFAULT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_pnum` varchar(11) NOT NULL,
  `birth_control_name` varchar(20) DEFAULT NULL,
  `terms_conditions` varchar(10) NOT NULL,
  `privacy_policy` varchar(10) NOT NULL,
  `access_code` varchar(10) NOT NULL,
  `user_password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `birth_control_id`, `user_fname`, `user_lname`, `user_dob`, `user_sex`, `user_image`, `user_email`, `user_pnum`, `birth_control_name`, `terms_conditions`, `privacy_policy`, `access_code`, `user_password`) VALUES
(2, NULL, 'Laurent', 'Ancheta', '0000-00-00', '', NULL, 'laurent@email.com', '09234726098', NULL, 'I agree', 'I agree', 'A5F4O5', 'merlion'),
(3, NULL, 'Gabriel', 'Ancheta', '2009-06-18', 'Male', 'uploads/logical-thinking.png', 'gabriel@email.com', '09958203320', NULL, 'I agree', 'I agree', 'CQUK86', 'gabo');

-- --------------------------------------------------------

--
-- Table structure for table `verification_codes`
--

CREATE TABLE `verification_codes` (
  `verification_id` int(5) NOT NULL,
  `user_pnum` varchar(11) NOT NULL,
  `verification_code` int(10) NOT NULL,
  `pnum_verified_at` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `verification_codes`
--

INSERT INTO `verification_codes` (`verification_id`, `user_pnum`, `verification_code`, `pnum_verified_at`) VALUES
(7, '09234726098', 361133, NULL),
(8, '09234726098', 134284, NULL),
(9, '09234726098', 108188, NULL),
(10, '09234726098', 252097, NULL),
(11, '09958203320', 286482, NULL),
(12, '09234726098', 239202, NULL),
(13, '09234726098', 137662, NULL),
(14, '09958203320', 183457, NULL),
(15, '09234726098', 227335, NULL),
(16, '09234726098', 213874, NULL),
(17, '09234726098', 250127, NULL),
(18, '09958203320', 169633, NULL),
(19, '09234726098', 278087, '2023-06-10 18:21:33.000000'),
(20, '09234726098', 798906, NULL),
(21, '09234726098', 135032, NULL),
(22, '09234726098', 211662, NULL),
(23, '09234726098', 168817, '2023-06-12 14:07:34.000000'),
(24, '09234726098', 141686, '2023-06-12 19:59:01.000000'),
(25, '09958203320', 121165, '2023-06-16 14:48:12.000000'),
(26, '09958203320', 969183, '2023-06-16 14:51:10.000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `birth_controls`
--
ALTER TABLE `birth_controls`
  ADD PRIMARY KEY (`birth_control_id`);

--
-- Indexes for table `forum`
--
ALTER TABLE `forum`
  ADD PRIMARY KEY (`forum_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `comment_parent_id` (`comment_parent_id`),
  ADD KEY `comment_count` (`comment_count`);

--
-- Indexes for table `rating_info`
--
ALTER TABLE `rating_info`
  ADD UNIQUE KEY `UC_rating_info` (`user_id`,`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `verification_codes`
--
ALTER TABLE `verification_codes`
  ADD PRIMARY KEY (`verification_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `birth_controls`
--
ALTER TABLE `birth_controls`
  MODIFY `birth_control_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `verification_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
