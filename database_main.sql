-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2020 at 08:33 AM
-- Server version: 8.0.19-0ubuntu0.19.10.3
-- PHP Version: 7.2.24-0ubuntu0.19.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hmsystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--
-- Creation: Apr 08, 2020 at 09:20 AM
--

DROP TABLE IF EXISTS `employee`;
CREATE TABLE IF NOT EXISTS `employee` (
  `employee_id` int NOT NULL AUTO_INCREMENT,
  `employee_username` varchar(50) NOT NULL,
  `employee_password` varchar(50) CHARACTER SET utf32 COLLATE utf32_general_ci NOT NULL,
  `employee_firstname` varchar(50) NOT NULL,
  `employee_lastname` varchar(50) NOT NULL,
  `employee_telephone` varchar(50) DEFAULT NULL,
  `employee_email` varchar(50) DEFAULT NULL,
  `employee_address` text,
  `employee_country` varchar(128) DEFAULT NULL,
  `employee_state` varchar(128) DEFAULT NULL,
  `employee_city` varchar(128) DEFAULT NULL,
  `department_id` int DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role` int NOT NULL DEFAULT '1',
  `role_id` int NOT NULL DEFAULT '0',
  `employee_type` varchar(50) NOT NULL,
  `employee_salary` float DEFAULT NULL,
  `employee_hiring_date` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `username` (`employee_username`),
  UNIQUE KEY `email` (`employee_email`),
  KEY `department` (`department_id`),
  KEY `login` (`employee_username`,`employee_password`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `employee`:
--   `department_id`
--       `sales_services` -> `id`
--

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employee_username`, `employee_password`, `employee_firstname`, `employee_lastname`, `employee_telephone`, `employee_email`, `employee_address`, `employee_country`, `employee_state`, `employee_city`, `department_id`, `image`, `role`, `role_id`, `employee_type`, `employee_salary`, `employee_hiring_date`) VALUES
(0, 'generic', '', 'Generic', 'Implementation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '', NULL, NULL),
(2, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Default', 'Admin', '', '', '', '', '', '', 10, '', 1, 5, 'Executive', 1000, '2020-03-31'), 
(1, 'root', '28f20a02bf8a021fab4fcec48afb584e', 'Root', 'Admin', '', '', NULL, NULL, NULL, NULL, 9, '', 2, 0, 'Root', 1000, '2012/2/1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `sales_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
