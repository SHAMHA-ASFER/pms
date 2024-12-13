-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 13, 2024 at 08:57 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

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
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `create_date`, `deadline`, `status`, `created_by`) VALUES
(5, 'Project Management System', 'A Project Management System (PMS) is a digital platform designed to assist teams and organizations in planning, organizing, executing, and monitoring projects efficiently. It provides tools and functionalities to streamline workflows, improve collaboration, and ensure timely delivery of project objectives.', '2024-12-06', '2024-12-13', 'pending', 5),
(8, 'ShareEaze', 'asdfasd asdfa dfasdf adf asdf', '2024-12-11', '2024-10-19', 'completed', 5);

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

--
-- Dumping data for table `project_analyzer`
--

INSERT INTO `project_analyzer` (`pro_id`, `user_id`) VALUES
(5, 3);

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

--
-- Dumping data for table `project_developer`
--

INSERT INTO `project_developer` (`pro_id`, `user_id`) VALUES
(5, 2);

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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `task`
--

INSERT INTO `task` (`id`, `name`, `description`, `deadline`, `status`, `created_by`, `project_id`) VALUES
(5, 'Create database api', 'Develop a RESTful API for CRUD operations on a database, ensuring secure data handling, validation, and error management.', '2025-01-01', 'pending', 5, 5);

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

--
-- Dumping data for table `task_developer`
--

INSERT INTO `task_developer` (`dev_id`, `task_id`) VALUES
(2, 5);

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
(5, 'Mohamed', 'Farvees', 'farvees', '123', 'frvs@gmail.com', '4532907651', '2021-01-02', '0987678543', '34/A, hdjsbf,Ampara.', 'PM', 'profile-4.jpg', '2024-12-02', NULL),
(6, 'Mohamed', 'Rushdhy', 'rush', '123', 'rush@gmail.com', '1234567', '2020-08-10', '12345656767809', '234,msv sbl,kandy.', 'PMO', 'profile-5.jpg', '2024-12-03', 5);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
