-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2023 at 09:37 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

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
  `birth_control_desc` varchar(200) NOT NULL,
  `birth_control_effectivity_rate` varchar(30) NOT NULL,
  `birth_control_duration` varchar(30) NOT NULL,
  `birth_control_reversibility` varchar(30) NOT NULL,
  `birth_control_advantages` varchar(200) NOT NULL,
  `birth_control_disadvantages` varchar(200) NOT NULL,
  `birth_control_side_effects` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `birth_controls`
--

INSERT INTO `birth_controls` (`birth_control_id`, `birth_control_img`, `birth_control_name`, `birth_control_desc`, `birth_control_effectivity_rate`, `birth_control_duration`, `birth_control_reversibility`, `birth_control_advantages`, `birth_control_disadvantages`, `birth_control_side_effects`) VALUES
(1, 'sample.jpg', 'Hormonal IUD', 'low maintenance\r\n', '99%', '3-10 years', 'yes', '', '', ''),
(2, 'sample.jpg', 'Copper IUD', 'low maintenance', '99%', '3-10 years', 'yes', '', '', ''),
(3, 'sample.jpg', 'Implant', 'low maintenance', '99%', '5 years', 'yes', '', '', ''),
(4, 'sample.jpg', 'The Shot', 'Used on a schedule\r\n', '96%', '3 months', 'no', '', '', ''),
(5, 'sample.jpg', 'Hormonal Vaginal Ring', 'Change patch once a week.\nPeriods lighter and less painful. \nControl over when periods come.\nHelps to treat acne.\n', '', '', '', '', '', ''),
(6, 'sample.jpg', 'Hormonal Patch', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(7, 'sample.jpg', 'Mini Pill', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(8, 'sample.jpg', 'Condom', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(9, 'sample.jpg', 'Diaphragm', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(10, 'sample.jpg', 'Spermicide', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(11, 'sample.jpg', 'Withdrawal Method', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(12, 'sample.jpg', 'Calendar Method', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(13, 'sample.jpg', 'Temperature Method', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(14, 'sample.jpg', 'Emergency Contraception', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(15, 'sample.jpg', 'Vasectomy', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', ''),
(16, 'sample.jpg', 'Tubal Ligation', 'Change patch once a week.\nPeriods lighter and less painful. \nControl over when periods come.\nHelps to treat acne.\n', '', '', '', '', '', ''),
(17, 'sample.jpg', 'Combined Pill', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', '', '', '', '', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `birth_controls`
--
ALTER TABLE `birth_controls`
  ADD PRIMARY KEY (`birth_control_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `birth_controls`
--
ALTER TABLE `birth_controls`
  MODIFY `birth_control_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
