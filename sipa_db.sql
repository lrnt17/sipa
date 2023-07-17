-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 17, 2023 at 03:49 PM
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
  `user_img` varchar(100) NOT NULL,
  `user_fname` varchar(25) NOT NULL,
  `forum_timestamp` datetime NOT NULL,
  `forum_title` varchar(200) NOT NULL,
  `forum_desc` varchar(500) NOT NULL,
  `comment_parent_id` int(11) NOT NULL DEFAULT 0,
  `comment_count` int(11) NOT NULL DEFAULT 0,
  `reply_parent_id` int(11) NOT NULL DEFAULT 0,
  `reply_count` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `forum`
--

INSERT INTO `forum` (`forum_id`, `user_id`, `user_img`, `user_fname`, `forum_timestamp`, `forum_title`, `forum_desc`, `comment_parent_id`, `comment_count`, `reply_parent_id`, `reply_count`) VALUES
(1, 3, '', '', '2023-07-02 19:10:39', 'testing title 1', 'post 1', 0, 4, 0, 0),
(27, 2, '', '', '2023-07-02 20:43:37', '', 'gago ka HAHAHAHAHAHA', 1, 0, 0, 0),
(58, 2, '', '', '2023-07-03 20:41:31', 'forum by laurent 2', 'alaws po', 0, 1, 0, 0),
(61, 2, '', '', '2023-07-03 16:23:37', '', 'pogi ko', 58, 0, 0, 0),
(62, 2, '', '', '2023-07-03 16:25:54', '', '4', 1, 0, 0, 0),
(63, 2, '', '', '2023-07-03 16:26:02', '', '5', 1, 0, 0, 0),
(71, 2, '', '', '2023-07-03 19:11:16', '', '6', 1, 0, 0, 0),
(103, 2, '', 'Laurent', '2023-07-15 22:23:27', 'hello title', 'morning pilepens', 0, 0, 0, 0),
(124, 3, '', 'G*****l', '2023-07-11 15:49:44', 'secret user pows', 'ang tanooooonggg!!!!!!', 0, 4, 0, 0),
(125, 2, '', '', '2023-07-10 17:34:58', '', 'sup bros', 124, 0, 0, 3),
(126, 3, '', '', '2023-07-04 15:34:56', '', 'oks lang par', 124, 0, 0, 5),
(140, 3, '', '', '2023-07-05 14:28:51', '', 'hi pow', 124, 0, 0, 3),
(145, 2, '', 'Laurent', '2023-07-06 16:48:53', '', 'angas boss rorent', 0, 0, 126, 0),
(146, 2, '', '', '2023-07-05 17:42:15', '', 'yuri', 123, 0, 0, 0),
(149, 3, '', 'Gabriel', '2023-07-06 17:07:10', '', 'geh geh haha gumagana na', 0, 0, 126, 0),
(150, 2, '', 'Laurent', '2023-07-06 16:51:29', '', 'henlo', 0, 0, 140, 0),
(151, 2, '', 'Laurent', '2023-07-06 17:54:44', '', 'oo nga eh lupet haha', 0, 0, 126, 0),
(152, 3, '', 'Gabriel', '2023-07-06 19:28:55', '', 'goods bro', 0, 0, 125, 0),
(153, 3, '', 'Gabriel', '2023-07-06 20:10:59', '', 'hi kyah', 0, 0, 140, 0),
(156, 2, '', 'Laurent', '2023-07-06 23:34:41', '', 'gento', 0, 0, 126, 0),
(158, 2, '', 'Laurent', '2023-07-07 00:00:45', '', 'jeje mo naman po', 0, 0, 140, 0),
(161, 3, '', 'Gabriel', '2023-07-07 09:10:50', 'goooood mornig ph', 'musta kayo guys hahaha', 0, 0, 0, 0),
(162, 2, '', 'Laurent', '2023-07-07 15:02:17', '', 'musta ka na', 0, 0, 125, 0),
(163, 2, '', 'Laurent', '2023-07-07 15:51:29', '', 'uy gabo asan ka na', 0, 0, 126, 0),
(164, 3, '', 'G*****l', '2023-07-07 23:52:36', 'view more button', 'gumagana na sya nakakaiyak huhuhu', 0, 0, 0, 0),
(165, 3, '', 'Gabriel', '2023-07-08 18:11:11', '4', '4', 0, 0, 0, 0),
(167, 3, '', 'G*****l', '2023-07-17 17:27:12', 'pausganay', 'semi finals, nandito pa rin sa bside ingay', 0, 0, 0, 0),
(169, 2, '', '', '2023-07-08 23:02:52', '', 'yow', 124, 0, 0, 0),
(195, 2, '', 'Laurent', '2023-07-11 13:21:27', 'iba ka talaga', 'boooyy angas', 0, 0, 0, 0),
(198, 2, '', 'L*****t', '2023-07-14 21:22:55', 'uy pare mare', 'kamusta ka na? Palagi kitang pinapanood nakikita', 0, 6, 0, 0),
(199, 2, '', '', '2023-07-10 11:25:19', '', 'owwsss', 198, 0, 0, 0),
(200, 3, '', 'Gabriel', '2023-07-10 20:26:14', '', 'oks lang', 0, 0, 125, 0),
(201, 3, '', 'G*****l', '2023-07-10 23:59:29', 'testing time', 'pssstt', 0, 1, 0, 0),
(202, 2, '', '', '2023-07-13 12:41:34', '', 'shantidope', 198, 0, 0, 1),
(203, 3, '', '', '2023-07-11 16:20:45', '', 'jopay yarn HAHAHAHAHA gago', 198, 0, 0, 2),
(204, 3, '', 'Gabriel', '2023-07-11 16:21:09', '', 'luh nuyon?', 0, 0, 202, 0),
(205, 3, '', '', '2023-07-11 16:29:12', '', 'comment ulit', 198, 0, 0, 0),
(206, 3, '', 'Gabriel', '2023-07-16 23:32:42', 'uy', 'palagay mo pre? goods?', 0, 3, 0, 0),
(207, 3, '', '', '2023-07-12 21:55:16', '', 'panlima', 198, 0, 0, 0),
(208, 3, '', '', '2023-07-12 21:56:02', '', 'sixth comment', 198, 0, 0, 0),
(209, 3, '', '', '2023-07-12 22:44:32', '', '1st comment', 201, 0, 0, 1),
(210, 3, '', 'Gabriel', '2023-07-12 22:45:50', '', 'reply to my 1st comment', 0, 0, 209, 0),
(212, 2, '', 'Laurent', '2023-07-13 11:56:21', '', 'inamo ka talaga HAHAHAHA', 0, 0, 203, 0),
(213, 2, '', 'Laurent', '2023-07-13 14:55:28', '', 'uuuuyyy', 0, 0, 203, 0),
(214, 2, '', 'Laurent', '2023-07-15 13:43:42', 'sigi sumayaw ka pows', 'by gloc 9', 0, 0, 0, 0),
(217, 3, '', 'Gabriel', '2023-07-16 21:00:28', 'sapa', 'isa pa meaning yan eh', 0, 2, 0, 0),
(221, 3, '', '', '2023-07-16 23:42:10', '', 'test', 206, 0, 0, 0),
(222, 2, '', '', '2023-07-16 23:48:18', '', 'oy', 206, 0, 0, 0),
(223, 3, 'uploads/logical-thinking.png', 'Gabriel', '2023-07-17 17:00:24', 'test1 edit', 'test1', 0, 0, 0, 0),
(224, 3, 'assets/images/user.jpg?v1', 'G*****l', '2023-07-17 13:47:05', 'test2', 'test2 edit', 0, 3, 0, 0),
(225, 3, '', '', '2023-07-17 13:46:50', '', 'test 3 comment', 224, 0, 0, 3),
(226, 3, '', 'Gabriel', '2023-07-17 14:06:46', '', 'test 4 reply', 0, 0, 225, 0),
(227, 3, '', 'Gabriel', '2023-07-17 14:07:46', '', 'test 5 reply', 0, 0, 225, 0),
(228, 3, '', '', '2023-07-17 14:24:18', '', 'eow', 217, 0, 0, 0),
(230, 3, '', '', '2023-07-17 14:37:43', '', 'eow 2', 217, 0, 0, 0),
(232, 3, '', 'Gabriel', '2023-07-17 17:26:27', '', 'w', 0, 0, 231, 0),
(234, 3, 'uploads/logical-thinking.png', 'Gabriel', '2023-07-17 17:54:37', '', 'woy', 224, 0, 0, 0),
(235, 3, 'assets/images/user.jpg?v1', 'G*****l', '2023-07-17 17:56:27', '', 'isapa', 224, 0, 0, 0),
(237, 3, 'assets/images/user.jpg?v1', 'G*****l', '2023-07-17 18:58:13', '', 'test 6 reply', 0, 0, 225, 0),
(238, 3, 'assets/images/user.jpg?v1', 'G*****l', '2023-07-17 20:10:26', '', 'eyy', 206, 0, 0, 1),
(239, 3, 'assets/images/user.jpg?v1', 'G*****l', '2023-07-17 20:10:42', '', 'wassup', 0, 0, 238, 0);

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
(2, 1, 'like'),
(2, 58, 'like'),
(2, 124, 'like'),
(2, 150, 'like'),
(2, 153, 'like'),
(2, 195, 'like'),
(2, 198, 'like'),
(2, 200, 'like'),
(2, 201, 'like'),
(2, 202, 'like'),
(2, 206, 'like'),
(2, 221, 'like'),
(2, 226, 'like'),
(3, 1, 'like'),
(3, 195, 'like'),
(3, 202, 'like'),
(3, 204, 'like'),
(3, 205, 'like'),
(3, 206, 'like'),
(3, 209, 'like'),
(3, 213, 'like'),
(3, 217, 'like'),
(3, 223, 'like'),
(3, 224, 'like'),
(3, 226, 'like'),
(3, 227, 'like'),
(3, 230, 'like'),
(3, 238, 'like'),
(3, 239, 'like');

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
(2, NULL, 'Laurent', 'Ancheta', '2002-08-17', 'Male', 'uploads/Sample 2x2.png', 'laurent@email.com', '09234726098', NULL, 'I agree', 'I agree', 'A5F4O5', 'merlion'),
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
  ADD KEY `comment_count` (`comment_count`),
  ADD KEY `reply_parent_id` (`reply_parent_id`),
  ADD KEY `reply_count` (`reply_count`);

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
  MODIFY `forum_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=240;

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
