-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 22, 2024 at 12:26 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projects`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

DROP TABLE IF EXISTS `chat`;
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pro_id` int DEFAULT NULL,
  `send` int DEFAULT NULL,
  `recv` int DEFAULT NULL,
  `message` varchar(256) NOT NULL,
  `send_time` timestamp NULL DEFAULT (now()),
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `pro_id`, `send`, `recv`, `message`, `send_time`) VALUES
(10, 5, 4, 2, 'hi', '2024-12-22 06:15:29'),
(9, 5, 2, 3, 'where are you?', '2024-12-22 06:05:48'),
(8, 5, 2, 4, 'hello', '2024-12-22 05:46:12'),
(7, 5, 2, 3, 'hi', '2024-12-22 05:45:52'),
(11, 5, 2, 4, 'what are doing?', '2024-12-22 06:17:52'),
(12, 5, 4, 2, 'nothing', '2024-12-22 06:18:07'),
(13, 5, 5, 2, 'hello', '2024-12-22 07:00:17'),
(14, 5, 5, 2, 'hello', '2024-12-22 07:00:18'),
(15, 5, 5, 2, 'hello', '2024-12-22 07:00:18'),
(16, 5, 5, 2, 'hello', '2024-12-22 07:00:19'),
(17, 5, 5, 2, 'hello', '2024-12-22 07:00:19'),
(18, 5, 2, 5, 'hi', '2024-12-22 07:01:00'),
(19, 5, 4, 3, 'are done?', '2024-12-22 08:13:14'),
(20, 5, 3, 2, 'at home', '2024-12-22 08:19:06'),
(21, 5, 3, 4, 'not yet!', '2024-12-22 08:19:29'),
(22, 5, 5, 3, 'are finished your job?', '2024-12-22 08:20:43'),
(23, 5, 5, 3, 'are finished your job?', '2024-12-22 08:20:44');

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pro_id` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `status` enum('pending','accepted','denied') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending',
  `last_modified` date DEFAULT (now()),
  `updated_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`id`, `pro_id`, `name`, `location`, `status`, `last_modified`, `updated_by`) VALUES
(9, 5, 'PMS SRS Document ', 'Project Management System/doc/Software Requirements Specification.docx', 'accepted', '2024-12-08', 3);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

DROP TABLE IF EXISTS `file`;
CREATE TABLE IF NOT EXISTS `file` (
  `id` int NOT NULL AUTO_INCREMENT,
  `task_id` int DEFAULT NULL,
  `location` varchar(256) NOT NULL,
  `type` enum('file','folder') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`id`, `task_id`, `location`, `type`) VALUES
(1, 5, '', 'file'),
(2, 5, '', 'file'),
(3, 5, '', 'file'),
(4, 5, '', 'file'),
(5, 5, '', 'file'),
(6, 5, '', 'file'),
(7, 5, '', 'file'),
(8, 5, '', 'file'),
(9, 5, '', 'file'),
(10, 5, '', 'file'),
(11, 5, '', 'file'),
(12, 5, '', 'file'),
(13, 5, '', 'file'),
(14, 5, '', 'file'),
(15, 5, '', 'file'),
(16, 5, '', 'file'),
(17, 5, '', 'file'),
(18, 5, '', 'file'),
(19, 5, '', 'file'),
(20, 5, '', 'file'),
(21, 5, '', 'file'),
(22, 5, '', 'file'),
(23, 5, '', 'file'),
(24, 5, '', 'file'),
(25, 5, '', 'file'),
(26, 5, '', 'file'),
(27, 5, '', 'file'),
(28, 5, '', 'file'),
(29, 5, '', 'file'),
(30, 5, '', 'file'),
(31, 5, '', 'file'),
(32, 5, '', 'file'),
(33, 5, '', 'file'),
(34, 5, '', 'file'),
(35, 5, '', 'file'),
(36, 5, '', 'file'),
(37, 5, '', 'file'),
(38, 5, '', 'file'),
(39, 5, '', 'file'),
(40, 5, '', 'file'),
(41, 5, '', 'file'),
(42, 5, '', 'file'),
(43, 5, '', 'file'),
(44, 5, '', 'file'),
(45, 5, '', 'file'),
(46, 5, '', 'file'),
(47, 5, '', 'file'),
(48, 5, '', 'file'),
(49, 5, '', 'file'),
(50, 5, 'Wave Animation.ffx', 'file'),
(51, 6, '', 'file'),
(52, 6, 'Complete Ecom Using Laravel 11.pdf', 'file');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `create_date` date DEFAULT (now()),
  `deadline` date NOT NULL,
  `status` enum('completed','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending',
  `created_by` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_analyzer`
--

DROP TABLE IF EXISTS `project_analyzer`;
CREATE TABLE IF NOT EXISTS `project_analyzer` (
  `pro_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`pro_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_developer`
--

DROP TABLE IF EXISTS `project_developer`;
CREATE TABLE IF NOT EXISTS `project_developer` (
  `pro_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`pro_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_qa`
--

DROP TABLE IF EXISTS `project_qa`;
CREATE TABLE IF NOT EXISTS `project_qa` (
  `pro_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`pro_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project_qa`
--

INSERT INTO `project_qa` (`pro_id`, `user_id`) VALUES
(12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

DROP TABLE IF EXISTS `task`;
CREATE TABLE IF NOT EXISTS `task` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `deadline` date DEFAULT NULL,
  `status` enum('denied','pending','completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending',
  `created_by` int DEFAULT NULL,
  `project_id` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_developer`
--

DROP TABLE IF EXISTS `task_developer`;
CREATE TABLE IF NOT EXISTS `task_developer` (
  `dev_id` int NOT NULL,
  `task_id` int NOT NULL,
  PRIMARY KEY (`dev_id`,`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `task_qa`
--

DROP TABLE IF EXISTS `task_qa`;
CREATE TABLE IF NOT EXISTS `task_qa` (
  `qa_id` int NOT NULL,
  `task_id` int NOT NULL,
  PRIMARY KEY (`qa_id`,`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `dob` date NOT NULL,
  `nic` varchar(20) DEFAULT NULL,
  `address` varchar(256) DEFAULT NULL,
  `role` enum('PM','PMO','QA','DEV','ANA') DEFAULT NULL,
  `profile` varchar(256) NOT NULL,
  `joined` date DEFAULT (now()),
  `manager` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `contact` (`contact`),
  UNIQUE KEY `nic` (`nic`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fname`, `lname`, `username`, `password`, `email`, `contact`, `dob`, `nic`, `address`, `role`, `profile`, `joined`, `manager`) VALUES
(2, 'Fathima', 'Shamha', 'sham', '123', 'sham@gmail.com', '0768353236', '2024-01-12', '200162203528', '243/3, Rose garden, Delgesthenna,Akurana.', 'DEV', 'profile-1.jpg', '2024-12-02', 5),
(3, 'Fathima', 'Hazeera', 'hazee', '123', 'hazee@gmail.com', '12345678', '2024-12-10', '245671234', '213, Mallawpitiya, Kurunegale.', 'ANA', 'profile-2.jpg', '2024-12-02', 5),
(4, 'Madhusha', 'Joseph', 'madhu', '123', 'madhu@gmail.com', '0987654321', '2020-12-01', '456789045673', '45, Sudukaadu Road, Ratthota.', 'QA', 'profile-3.jpg', '2024-12-02', 5),
(5, 'Shamha', 'Asfer', 'shamha', '123', 'asfer@gmail.com', '4532907651', '2021-01-02', '0987678543', '34/A, hdjsbf,Ampara.', 'PM', 'profile-4.jpg', '2024-12-02', NULL),
(6, 'Mohamed', 'Rushdhy', 'rush', '123', 'rush@gmail.com', '1234567', '2020-08-10', '12345656767809', '234,msv sbl,kandy.', 'PMO', 'profile-5.jpg', '2024-12-03', 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
