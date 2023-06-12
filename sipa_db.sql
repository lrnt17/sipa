-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jun 10, 2023 at 05:38 PM
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
  `forum_desc` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(5) NOT NULL,
  `birth_control_id` int(5) DEFAULT NULL,
  `user_fname` varchar(30) NOT NULL,
  `user_lname` varchar(20) NOT NULL,
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

INSERT INTO `users` (`user_id`, `birth_control_id`, `user_fname`, `user_lname`, `user_email`, `user_pnum`, `birth_control_name`, `terms_conditions`, `privacy_policy`, `access_code`, `user_password`) VALUES
(1, 0, 'Laurent', 'Ancheta', 'laurent@email.com', '0923', '', '', '', 'PR06', '123'),
(2, NULL, 'Laurent', 'Ancheta', 'laurent@email.com', '09234726098', NULL, 'I agree', 'I agree', 'A5F4O5', '123');

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
(19, '09234726098', 278087, '2023-06-10 18:21:33.000000');

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
  ADD PRIMARY KEY (`forum_id`);

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
  MODIFY `forum_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `verification_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
