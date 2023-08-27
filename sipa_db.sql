-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 15, 2023 at 12:35 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_empnum` varchar(11) NOT NULL,
  `admin_fullname` varchar(50) NOT NULL,
  `admin_email` varchar(50) NOT NULL,
  `health_facility` varchar(50) NOT NULL,
  `specialization` varchar(50) NOT NULL,
  `admin_pnum` bigint(10) NOT NULL,
  `admin_address` varchar(50) NOT NULL,
  `admin_password` varchar(65) NOT NULL,
  `terms_conditions` varchar(10) NOT NULL,
  `privacy_policy` varchar(10) NOT NULL,
  `test` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_empnum`, `admin_fullname`, `admin_email`, `health_facility`, `specialization`, `admin_pnum`, `admin_address`, `admin_password`, `terms_conditions`, `privacy_policy`, `test`) VALUES
('BUSTOS00001', 'Laurent Antoine C. Ancheta', 'laurentancheta15@gmail.com', 'Bustos RHU', 'Administrator', 9234726098, 'Baliwag, Bulacan', '$2y$10$uGxlsBVMMBTkOGVjk7aO4udskbed4NsNOGZgk447eligJGenfh4NO', 'I agree', 'I agree', NULL),
('BUSTOS00002', 'Eunice C. Roxas', 'eunice@gmail.com', 'Bustos RHU', 'Obstetrician-Gynecologist (OB-GYN)', 12345, 'DRT Bulacan', '$2y$10$1oLwmht1wMEpPp6ijytaMebAeRgyUPggl9T5q1K3OUmkHJYG/MXSO', 'I agree', 'I agree', NULL),
('BUSTOS00003', 'Mikaella M.', 'mika@gmail.com', 'Bustos RHU', 'Planned Parenthood Clinician', 12345, 'San Roque, Baliwag, Bulacan', '$2y$10$k82o6w2vE.0QbgsqCR012uWlZuHcdjlyI8pzCOqJU5bjCDaYXJmNe', 'I agree', 'I agree', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `app_id` int(11) NOT NULL,
  `app_name` varchar(30) NOT NULL,
  `app_address` varchar(50) NOT NULL,
  `app_email` varchar(50) NOT NULL,
  `city_municipality` varchar(15) NOT NULL,
  `app_pnum` bigint(10) NOT NULL,
  `app_gender` varchar(7) NOT NULL,
  `app_bdate` date NOT NULL,
  `app_date` date NOT NULL,
  `app_timeslot` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`app_id`, `app_name`, `app_address`, `app_email`, `city_municipality`, `app_pnum`, `app_gender`, `app_bdate`, `app_date`, `app_timeslot`) VALUES
(1, 'Laurent Antoine C. Ancheta', 'Baliwag, Bulacan', 'laurentancheta15@gmail.com', 'Bustos', 9234726098, 'Male', '2002-08-17', '2023-07-31', '09:00AM-10:00AM'),
(2, 'Eunice C. Roxas', 'DRT Bulacan', 'eunice@email.com', 'Bustos', 9234726199, 'Female', '2002-06-25', '2023-07-31', '15:00PM-16:00PM'),
(3, 'Mikaella M. Acuna', 'San Roque, Baliwag, Bulacan', 'mika@email.com', 'Bustos', 33333, 'Female', '2002-08-20', '2023-07-31', '12:00PM-13:00PM'),
(4, 'Roly Florentino', 'Baliwag, Bulacan', 'roly@gmail.com', 'Bustos', 1234567890, 'Male', '2023-07-27', '2023-07-31', '13:00PM-14:00PM'),
(5, 'Laurent Antoine C. Ancheta', 'Baliwag, Bulacan', 'laurentancheta15@gmail.com', 'Bustos', 9234726098, 'Male', '2023-07-27', '2023-07-31', '10:00AM-11:00AM'),
(6, 'kwak kwak', 'eweeq', 'laurentancheta15@gmail.com', 'Bustos', 33333, 'Male', '2023-07-27', '2023-07-31', '14:00PM-15:00PM'),
(7, 'Eunice C. Roxas', 'DRT Bulacan', 'eunice@email.com', 'Bustos', 33333, 'Female', '2023-07-27', '2023-07-31', '11:00AM-12:00PM');

-- --------------------------------------------------------

--
-- Table structure for table `birth_controls`
--

CREATE TABLE `birth_controls` (
  `birth_control_id` int(5) NOT NULL,
  `birth_control_icon` varchar(100) NOT NULL,
  `birth_control_img` varchar(100) NOT NULL,
  `birth_control_name` varchar(50) NOT NULL,
  `birth_control_desc` varchar(200) NOT NULL,
  `birth_control_effectivity_rate` int(1) NOT NULL DEFAULT 0,
  `birth_control_duration` varchar(30) NOT NULL,
  `birth_control_reversibility` varchar(30) NOT NULL,
  `birth_control_advantages` varchar(200) NOT NULL,
  `birth_control_disadvantages` varchar(200) NOT NULL,
  `birth_control_side_effects` varchar(200) NOT NULL,
  `birth_control_preggy` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `birth_controls`
--

INSERT INTO `birth_controls` (`birth_control_id`, `birth_control_icon`, `birth_control_img`, `birth_control_name`, `birth_control_desc`, `birth_control_effectivity_rate`, `birth_control_duration`, `birth_control_reversibility`, `birth_control_advantages`, `birth_control_disadvantages`, `birth_control_side_effects`, `birth_control_preggy`) VALUES
(1, 'iud.png', 'sample.jpg', 'Hormonal IUD', 'low maintenance\r\n', 3, '3-10 years', 'yes', '', '', '', 1),
(2, '', 'sample.jpg', 'Copper IUD', 'low maintenance', 2, '3-10 years', 'yes', '', '', '', 3),
(3, '', 'sample.jpg', 'Implant', 'low maintenance', 1, '5 years', 'yes', '', '', '', 2),
(4, 'injection.png', 'sample.jpg', 'The Shot', 'Used on a schedule\r\n', 0, '3 months', 'no', '', '', '', 2),
(5, '', 'sample.jpg', 'Hormonal Vaginal Ring', 'Change patch once a week.\nPeriods lighter and less painful. \nControl over when periods come.\nHelps to treat acne.\n', 0, '', '', '', '', '', 0),
(6, '', 'sample.jpg', 'Hormonal Patch', 'Change patch once a week.\nPeriods lighter and less painful. \nControl over when periods come.\nHelps to treat acne.\n', 0, '', '', '', '', '', 0),
(7, '', 'sample.jpg', 'Mini Pill', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0),
(8, '', 'sample.jpg', 'Condom', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0),
(9, '', 'sample.jpg', 'Diaphragm', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0),
(10, '', 'sample.jpg', 'Spermicide', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0),
(11, '', 'sample.jpg', 'Withdrawal Method', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0),
(12, '', 'sample.jpg', 'Calendar Method', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0),
(13, '', 'sample.jpg', 'Temperature Method', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0),
(14, '', 'sample.jpg', 'Emergency Contraception', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0),
(15, '', 'sample.jpg', 'Vasectomy', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0),
(16, '', 'sample.jpg', 'Tubal Ligation', 'Change patch once a week.\nPeriods lighter and less painful. \nControl over when periods come.\nHelps to treat acne.\n', 0, '', '', '', '', '', 0),
(17, '', 'sample.jpg', 'Combined Pill', 'Change patch once a week.\r\nPeriods lighter and less painful. \r\nControl over when periods come.\r\nHelps to treat acne.\r\n', 0, '', '', '', '', '', 0);

--
-- Triggers `birth_controls`
--
DELIMITER $$
CREATE TRIGGER `insert_birth_control_charts` AFTER INSERT ON `birth_controls` FOR EACH ROW INSERT INTO birth_controls_chart (birth_control_id, birth_control_icon, birth_control_name) VALUES (NEW.birth_control_id, NEW.birth_control_icon, NEW.birth_control_name)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `birth_controls_chart`
--

CREATE TABLE `birth_controls_chart` (
  `birth_control_chart_id` int(11) NOT NULL,
  `birth_control_id` int(11) NOT NULL,
  `birth_control_name` varchar(30) NOT NULL,
  `birth_control_icon` varchar(100) NOT NULL,
  `effectivity` int(1) NOT NULL DEFAULT 0,
  `STI_prevention` int(1) NOT NULL DEFAULT 0,
  `less_PMS` tinyint(1) NOT NULL DEFAULT 0,
  `easy_to_hide` tinyint(1) NOT NULL DEFAULT 0,
  `easy_to_get` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `birth_controls_chart`
--

INSERT INTO `birth_controls_chart` (`birth_control_chart_id`, `birth_control_id`, `birth_control_name`, `birth_control_icon`, `effectivity`, `STI_prevention`, `less_PMS`, `easy_to_hide`, `easy_to_get`) VALUES
(1, 1, 'Hormonal IUD', 'iud.png', 3, 2, 0, 0, 0),
(2, 2, 'Copper IUD', 'iud.png', 2, 2, 0, 0, 0),
(3, 3, 'Implant', 'implant.png', 3, 1, 0, 0, 0),
(4, 4, 'The Shot', 'injection.png', 3, 0, 1, 2, 0),
(5, 5, 'Hormonal Vaginal Ring', '', 0, 0, 0, 0, 0),
(6, 6, 'Hormonal Patch', '', 0, 0, 0, 0, 0),
(7, 7, 'Mini Pill', '', 0, 0, 0, 0, 0),
(8, 8, 'Condom', '', 0, 0, 0, 0, 0),
(9, 9, 'Diaphragm', '', 0, 0, 0, 0, 0),
(10, 10, 'Spermicide', '', 0, 0, 0, 0, 0),
(11, 11, 'Withdrawal Method', '', 0, 0, 0, 0, 0),
(12, 12, 'Calendar Method', '', 0, 0, 0, 0, 0),
(13, 13, 'Temperature Method', '', 0, 0, 0, 0, 0),
(14, 14, 'Emergency Contraception', '', 0, 0, 0, 0, 0),
(15, 15, 'Vasectomy', '', 0, 0, 0, 0, 0),
(16, 16, 'Tubal Ligation', '', 0, 0, 0, 0, 0),
(17, 17, 'Combined Pill', '', 3, 0, 3, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `birth_controls_sidebyside`
--

CREATE TABLE `birth_controls_sidebyside` (
  `sidebyside_id` int(11) NOT NULL,
  `birth_control_id` int(11) NOT NULL,
  `birth_control_name` varchar(30) NOT NULL,
  `birth_control_icon` varchar(100) NOT NULL,
  `effectiveness` varchar(100) NOT NULL,
  `STI prevention` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `birth_controls_sidebyside`
--

INSERT INTO `birth_controls_sidebyside` (`sidebyside_id`, `birth_control_id`, `birth_control_name`, `birth_control_icon`, `effectiveness`, `STI prevention`) VALUES
(1, 1, 'Hormonal IUD', '', 'It’s one of the most effective methods.', 'The IUD doesn’t protect against STIs.'),
(2, 2, 'Copper IUD', '', 'It’s one of the most effective methods.', 'The IUD doesn’t protect against STIs.'),
(3, 3, 'Implant', '', 'The implant is among the most effective methods.', 'The implant doesn\'t protect against STIs.');

-- --------------------------------------------------------

--
-- Table structure for table `birth_control_brand_price`
--

CREATE TABLE `birth_control_brand_price` (
  `brand_id` int(5) NOT NULL,
  `birth_control_id` int(5) NOT NULL,
  `selected_birth_control` varchar(30) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `brand_price` int(11) NOT NULL,
  `brand_img` varchar(100) NOT NULL,
  `brand_amount_package` int(5) NOT NULL,
  `brand_longevity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `birth_control_brand_price`
--

INSERT INTO `birth_control_brand_price` (`brand_id`, `birth_control_id`, `selected_birth_control`, `brand_name`, `brand_price`, `brand_img`, `brand_amount_package`, `brand_longevity`) VALUES
(1, 8, 'Condom', 'Trust', 119, 'trust.jpg', 3, ''),
(2, 8, 'Condom', 'Durex', 108, 'durex.jpg', 4, ''),
(3, 1, 'Hormonal IUD', 'Mirena', 12000, 'mirena.jpg', 1, '5 years'),
(4, 2, 'Copper IUD', 'ParaGard', 5000, 'paragard.png', 1, '10 years'),
(5, 3, 'Implant', 'Nexplanon', 5000, 'nexplanon.jpg', 1, '3 years'),
(6, 4, 'The Shot', 'Depo-Provera', 500, 'dmpa.png', 1, '3 months'),
(7, 5, 'Hormonal Vaginal Ring', 'NuvaRing', 500, 'nuvaring.jpg', 1, '1 month'),
(8, 6, 'Hormonal Patch', 'Xulane', 500, 'xulane.png', 1, '1 week'),
(9, 7, 'Mini Pill', 'Cerazette', 100, 'cerazette.jpg', 21, '1 month'),
(10, 9, 'Diaphragm', 'Caya', 2000, 'diaphragm.png', 1, '1 day'),
(11, 10, 'Spermicide', 'VCF', 200, 'spermicide.jpg', 1, '1 day'),
(12, 14, 'Emergency Contraception', 'Trust Pill', 100, 'emergency.jpg', 1, '1 day'),
(13, 15, 'Vasectomy', 'Operation', 5000, 'vasectomy.jpg', 0, '0 permanent'),
(14, 16, 'Tubal Ligation', 'Operation', 15000, 'ligation.jpg', 0, '0 permanent'),
(15, 17, 'Combined Pill', 'Althea', 100, 'althea.jpg', 21, '1 month'),
(16, 17, 'Combined Pill', 'Charlize', 150, 'charlize.jpg', 21, '1 month');

-- --------------------------------------------------------

--
-- Table structure for table `email_verification`
--

CREATE TABLE `email_verification` (
  `verification_id` int(11) NOT NULL,
  `gmail` varchar(50) NOT NULL,
  `verification_code` int(10) NOT NULL,
  `verified_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `email_verification`
--

INSERT INTO `email_verification` (`verification_id`, `gmail`, `verification_code`, `verified_at`) VALUES
(1, 'laurentancheta15@gmail.com', 256616, NULL),
(2, 'laurentancheta15@gmail.com', 259377, NULL),
(3, 'laurentancheta15@gmail.com', 418465, NULL),
(4, 'laurentancheta15@gmail.com', 157891, NULL),
(5, 'laurentancheta15@gmail.com', 228373, NULL),
(6, 'laurentancheta15@gmail.com', 206906, NULL),
(7, 'laurentancheta15@gmail.com', 934464, NULL),
(8, 'laurentancheta15@gmail.com', 244822, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `employee_number` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_number`) VALUES
('BUSTOS00001'),
('BUSTOS00002'),
('BUSTOS00003'),
('BUSTOS00004'),
('BUSTOS00005');

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
(167, 3, '', 'G*****l', '2023-07-17 17:27:12', 'pausganay', 'semi finals, nandito pa rin sa bside ingay', 0, 1, 0, 0),
(169, 2, '', '', '2023-07-08 23:02:52', '', 'yow', 124, 0, 0, 0),
(195, 2, '', 'Laurent', '2023-07-19 18:24:31', 'iba ka talaga boss arick', 'boooyy angas', 0, 0, 0, 0),
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
(214, 2, '', 'Laurent', '2023-07-15 13:43:42', 'sigi sumayaw ka pows', 'by gloc 9', 0, 1, 0, 0),
(217, 3, '', 'Gabriel', '2023-07-16 21:00:28', 'sapa', 'isa pa meaning yan eh', 0, 2, 0, 0),
(221, 3, '', '', '2023-07-16 23:42:10', '', 'test', 206, 0, 0, 0),
(222, 2, '', '', '2023-07-16 23:48:18', '', 'oy', 206, 0, 0, 0),
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
(239, 3, 'assets/images/user.jpg?v1', 'G*****l', '2023-07-17 20:10:42', '', 'wassup', 0, 0, 238, 0),
(242, 2, 'assets/images/user.jpg?v1', 'L*****t', '2023-07-19 13:41:47', 'testing ko', 'mawawala na rin yung potenang rotc na yan', 0, 0, 0, 0),
(271, 2, 'uploads/Sample 2x2.png', 'Laurent', '2023-08-14 20:54:33', '001 eme langz', '001121112', 0, 2, 0, 0),
(276, 2, 'assets/images/user.jpg?v1', 'L*****t', '2023-07-19 19:35:17', '006', '006', 0, 0, 0, 0),
(278, 2, 'uploads/Sample 2x2.png', 'Laurent', '2023-07-30 15:05:50', '006 edited', '006', 0, 3, 0, 0),
(279, 2, 'assets/images/user.jpg?v1', 'L*****t', '2023-07-19 20:14:42', '007', '007', 0, 0, 0, 0),
(280, 2, 'uploads/Sample 2x2.png', 'Laurent', '2023-07-19 20:17:26', '', 'wala syang apelyido', 214, 0, 0, 0),
(281, 2, 'uploads/Sample 2x2.png', 'Laurent', '2023-07-19 20:19:48', '', 'inamo rin', 271, 0, 0, 2),
(282, 2, 'assets/images/user.jpg?v1', 'L*****t', '2023-07-29 15:17:59', '', 'hahaha test 3', 0, 0, 281, 0),
(283, 2, 'assets/images/user.jpg?v1', 'L*****t', '2023-07-19 22:04:11', '', 'fliptop', 167, 0, 0, 0),
(284, 3, 'uploads/logical-thinking.png', 'Gabriel', '2023-07-21 16:39:56', '', 'hi', 278, 0, 0, 0),
(285, 3, 'uploads/logical-thinking.png', 'Gabriel', '2023-07-21 16:59:57', '', 'yow', 278, 0, 0, 0),
(286, 2, 'uploads/Sample 2x2.png', 'Laurent', '2023-07-30 15:08:00', '', 'oy musta na', 278, 0, 0, 0),
(287, 2, 'uploads/Sample 2x2.png', 'Laurent', '2023-08-10 18:20:46', 'testing ko', 'henlo', 0, 1, 0, 0),
(288, 2, 'assets/images/user.jpg?v1', 'L*****t', '2023-07-30 15:10:31', '', 'wasssup boss', 287, 0, 0, 1),
(289, 2, 'uploads/Sample 2x2.png', 'Laurent', '2023-07-30 15:10:47', '', 'kausap sarili', 0, 0, 288, 0),
(290, 2, 'assets/images/user.jpg?v1', 'L*****t', '2023-08-02 19:16:41', '', 'lebron ba yan?', 277, 0, 0, 0),
(291, 2, 'assets/images/user.jpg?v1', 'L*****t', '2023-08-14 20:54:43', '', 'psssstt', 271, 0, 0, 0),
(292, 2, 'uploads/Sample 2x2.png', 'Laurent', '2023-08-14 20:54:53', '', 'test 4', 0, 0, 281, 0);

-- --------------------------------------------------------

--
-- Table structure for table `method_fyi`
--

CREATE TABLE `method_fyi` (
  `fyi_id` int(11) NOT NULL,
  `birth_control_id` int(11) NOT NULL,
  `fyi_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `method_fyi`
--

INSERT INTO `method_fyi` (`fyi_id`, `birth_control_id`, `fyi_desc`) VALUES
(1, 6, 'Most people don’t put on weight'),
(6, 2, 'qqqqqqqqqq'),
(8, 2, 'rrrrrrrrrrr cant be moved brooom'),
(9, 6, 'Sometimes the patch makes people feel more hungry. Studies show that most people stay the same weight – 1 in 10 put on weight, and 1 in 10 lose weight while they are on the patch.'),
(10, 6, 'Some users notice bigger breasts.'),
(11, 6, 'The patch doesn’t suit everyone'),
(12, 6, 'The patch suits some people really well, while others might experience moodiness, hunger, nausea, or lower sex drive. Everyone is unique, and it can help to change to a different form of contraception'),
(14, 1, 'testing pows');

-- --------------------------------------------------------

--
-- Table structure for table `method_negative_effects`
--

CREATE TABLE `method_negative_effects` (
  `negative_effect_id` int(11) NOT NULL,
  `birth_control_id` int(11) NOT NULL,
  `negative_effect_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `method_negative_effects`
--

INSERT INTO `method_negative_effects` (`negative_effect_id`, `birth_control_id`, `negative_effect_desc`) VALUES
(1, 6, 'It can be hard to remember when to change'),
(2, 6, 'No protection against STIs'),
(3, 6, 'Only available in a light skin tone'),
(4, 6, 'Spotting (bleeding in between periods)'),
(5, 6, 'Sore breasts'),
(13, 1, 'maulan ba sainyo boss lowdi?'),
(16, 4, 'test109876'),
(18, 7, 'mini mow mow mow');

-- --------------------------------------------------------

--
-- Table structure for table `method_positive_effects`
--

CREATE TABLE `method_positive_effects` (
  `positive_effect_id` int(11) NOT NULL,
  `birth_control_id` int(11) NOT NULL,
  `positive_effect_desc` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `method_positive_effects`
--

INSERT INTO `method_positive_effects` (`positive_effect_id`, `birth_control_id`, `positive_effect_desc`) VALUES
(1, 6, 'Easy to use – changed once a week'),
(2, 6, 'it doesn\'t interrupt sex'),
(3, 6, 'The patch is good at preventing pregnancy'),
(4, 6, 'Periods will usually be lighter'),
(5, 6, 'The patch helps to reduce period pain'),
(7, 1, 'raining in manila'),
(21, 1, 'gayuma by abra'),
(22, 1, 'add2'),
(23, 1, 'add3'),
(25, 3, 'test123'),
(27, 7, 'sana ganon ka nga pa rin'),
(28, 7, 'ennie mini'),
(29, 2, 'woy'),
(30, 10, 'magandang umaga'),
(31, 10, 'ngunit hindi ko maipaliwanag');

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
(2, 214, 'like'),
(2, 221, 'like'),
(2, 226, 'like'),
(2, 242, 'like'),
(2, 271, 'like'),
(2, 277, 'like'),
(2, 278, 'like'),
(2, 281, 'like'),
(2, 282, 'like'),
(3, 1, 'like'),
(3, 195, 'like'),
(3, 202, 'like'),
(3, 204, 'like'),
(3, 205, 'like'),
(3, 206, 'like'),
(3, 209, 'like'),
(3, 213, 'like'),
(3, 217, 'like'),
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
  `user_role` varchar(15) NOT NULL,
  `birth_control_id` int(5) DEFAULT NULL,
  `user_fname` varchar(30) NOT NULL,
  `user_lname` varchar(20) NOT NULL,
  `user_dob` date NOT NULL,
  `user_sex` varchar(11) NOT NULL,
  `user_image` varchar(100) DEFAULT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_pnum` varchar(11) NOT NULL,
  `health_facility_name` varchar(50) DEFAULT NULL,
  `specialization` varchar(30) DEFAULT NULL,
  `city_municipality` varchar(20) DEFAULT NULL,
  `birth_control_name` varchar(30) DEFAULT NULL,
  `birth_control_startdate` date DEFAULT NULL,
  `birth_control_usage` int(11) DEFAULT NULL,
  `terms_conditions` varchar(10) DEFAULT NULL,
  `privacy_policy` varchar(10) DEFAULT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_password` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_role`, `birth_control_id`, `user_fname`, `user_lname`, `user_dob`, `user_sex`, `user_image`, `user_email`, `user_pnum`, `health_facility_name`, `specialization`, `city_municipality`, `birth_control_name`, `birth_control_startdate`, `birth_control_usage`, `terms_conditions`, `privacy_policy`, `user_name`, `user_password`) VALUES
(2, 'user', NULL, 'Laurent', 'Ancheta', '2002-08-17', 'Male', 'uploads/Sample 2x2.png', 'laurentancheta@email.com', '09234726098', NULL, NULL, NULL, 'Implant', '2023-08-17', 5, 'I agree', 'I agree', 'laurentancheta', '$2y$10$FL5XZwRfcuDgTbBZK3S/luOgLLQMrJHQH4GOtk/TFhrXkcpc1enOq'),
(3, 'user', NULL, 'Gabriel', 'Ancheta', '2009-06-18', 'Male', 'uploads/logical-thinking.png', 'gabriel@email.com', '09958203320', NULL, NULL, NULL, NULL, NULL, 0, 'I agree', 'I agree', 'gabrielancheta', 'gabo'),
(5, 'head_admin', NULL, 'Laurent Antoine', 'Ancheta', '0000-00-00', '', NULL, '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', '', 'laurent', '12345'),
(7, 'head_admin', NULL, 'Eunice', 'Roxas', '2002-06-25', 'Female', NULL, 'laurentancheta15@gmail.com', '12345', 'Bustos RHU', 'Obstetrician-Gynecologist (OB-', 'Bustos', NULL, NULL, NULL, NULL, NULL, 'eunice.roxas', '$2y$10$qLLon4hVo7hQwVnbAq6gjORBiWWjUAZZHgu.S0KVor1KfRH40pfUq'),
(8, 'admin', NULL, 'Mikaella', 'Acuna', '2002-10-21', 'Female', NULL, 'laurentantoine.ancheta.c@bulsu', '12345', 'Bustos RHU', 'Family Medicine Physician', 'Bustos', NULL, NULL, NULL, NULL, NULL, 'mikaella.acuna', '$2y$10$xd8Pie2DZzxsbM6.Gx6ryebmwX.4WrPj9XF9Lwb5yLaWQDYGrI5SW'),
(9, 'admin', NULL, 'Roly', 'Florentino', '2001-04-15', 'Male', '../uploads/injection.png', 'roly@email.com', '911111111', 'Bustos RHU', 'Nurse Practitioner', 'Bustos', NULL, NULL, NULL, NULL, NULL, 'roly.florentino', '$2y$10$9nQEVbsTSFebOAcrQJFJi.9BvBr1JbZxSJ8miZYU4BU4/TM7DXfGa');

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
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_empnum`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`app_id`);

--
-- Indexes for table `birth_controls`
--
ALTER TABLE `birth_controls`
  ADD PRIMARY KEY (`birth_control_id`);

--
-- Indexes for table `birth_controls_chart`
--
ALTER TABLE `birth_controls_chart`
  ADD PRIMARY KEY (`birth_control_chart_id`);

--
-- Indexes for table `birth_controls_sidebyside`
--
ALTER TABLE `birth_controls_sidebyside`
  ADD PRIMARY KEY (`sidebyside_id`);

--
-- Indexes for table `birth_control_brand_price`
--
ALTER TABLE `birth_control_brand_price`
  ADD PRIMARY KEY (`brand_id`),
  ADD KEY `birth_control_id` (`birth_control_id`);

--
-- Indexes for table `email_verification`
--
ALTER TABLE `email_verification`
  ADD PRIMARY KEY (`verification_id`);

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
-- Indexes for table `method_fyi`
--
ALTER TABLE `method_fyi`
  ADD PRIMARY KEY (`fyi_id`);

--
-- Indexes for table `method_negative_effects`
--
ALTER TABLE `method_negative_effects`
  ADD PRIMARY KEY (`negative_effect_id`);

--
-- Indexes for table `method_positive_effects`
--
ALTER TABLE `method_positive_effects`
  ADD PRIMARY KEY (`positive_effect_id`);

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
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `app_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `birth_controls`
--
ALTER TABLE `birth_controls`
  MODIFY `birth_control_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `birth_controls_chart`
--
ALTER TABLE `birth_controls_chart`
  MODIFY `birth_control_chart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `birth_controls_sidebyside`
--
ALTER TABLE `birth_controls_sidebyside`
  MODIFY `sidebyside_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `birth_control_brand_price`
--
ALTER TABLE `birth_control_brand_price`
  MODIFY `brand_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `email_verification`
--
ALTER TABLE `email_verification`
  MODIFY `verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `forum`
--
ALTER TABLE `forum`
  MODIFY `forum_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=293;

--
-- AUTO_INCREMENT for table `method_fyi`
--
ALTER TABLE `method_fyi`
  MODIFY `fyi_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `method_negative_effects`
--
ALTER TABLE `method_negative_effects`
  MODIFY `negative_effect_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `method_positive_effects`
--
ALTER TABLE `method_positive_effects`
  MODIFY `positive_effect_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `verification_codes`
--
ALTER TABLE `verification_codes`
  MODIFY `verification_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `birth_control_brand_price`
--
ALTER TABLE `birth_control_brand_price`
  ADD CONSTRAINT `birth_control_brand_price_ibfk_1` FOREIGN KEY (`birth_control_id`) REFERENCES `birth_controls` (`birth_control_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
