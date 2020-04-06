-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 06, 2020 at 08:07 PM
-- Server version: 8.0.19-0ubuntu0.19.10.3
-- PHP Version: 7.2.24-0ubuntu0.19.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hmsystem`
--
CREATE DATABASE IF NOT EXISTS `hmsystem` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `hmsystem`;

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE IF NOT EXISTS `content` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `intro` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `banner` varchar(255) DEFAULT NULL,
  `safelink` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `button` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `align` varchar(128) DEFAULT NULL,
  `icon` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `color` varchar(128) DEFAULT NULL,
  `in_header` int DEFAULT '0',
  `in_footer` int NOT NULL DEFAULT '0',
  `priority` int NOT NULL DEFAULT '0',
  `rooms` int NOT NULL DEFAULT '0',
  `booking` int NOT NULL DEFAULT '0',
  `facilities` int NOT NULL DEFAULT '0',
  `contact` int NOT NULL DEFAULT '0',
  `parent` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`,`safelink`) USING BTREE,
  UNIQUE KEY `safelink_1` (`safelink`),
  KEY `safelink` (`safelink`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `intro`, `content`, `banner`, `safelink`, `button`, `align`, `icon`, `color`, `in_header`, `in_footer`, `priority`, `rooms`, `booking`, `facilities`, `contact`, `parent`) VALUES
(1, 'Welcome to Hayatt', 'This is the official toneflix account, follow for good updates!', 'If you use a select menu, this function permits you to display the menu item that was selected.d\r\n\r\nThe first parameter must contain the name of the select menu, the second parameter must contain the value of each item, and the third (optional) parameter lets you set an item as the default (use boolean TRUE/FALSE).', 'uploads/covers/qwqw/1375639490_486482779_1544318135_p.png', 'homepage', '[link=https://yahoo.com] red color[/link]', 'left', 'fa fa-500px', 'text-info', 1, 1, 1, 1, 1, 1, 0, ''),
(8, 'Boostrap classes', 'Official toneflix account, follow for good updates!', 'The first parameter must contain the name of the select menu, the second parameter must contain the value of each item, and the third (optional) parameter lets you set an item as the default (use boolean TRUE/FALSE). [link=https://example.com] Example[/link]', 'uploads/covers/qwqw/1375639490_486482779_1544318135_p.png', 'safelinkercs', '[link=https://example.com] Example[/link]', 'right', 'fa fa-500px', 'danger', 0, 0, 1, 0, 0, 0, 0, 'homepage'),
(11, 'About Us', 'Relax Your Mind', 'If you are looking at blank cassettes on the web, you may be very confused at the\r\ndifference in price. You may see some for as low as $.17 each.', NULL, 'about-us', '[link=about-us] Example[/link]', 'left', 'fa fa-ambulance', 'text-danger', 1, 1, 1, 1, 1, 1, 0, ''),
(12, 'Accomodation', 'About Us Our History Mission & Vision', 'inappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards especially in the workplace. That’s why it’s crucial that, as women, our behavior on the job is beyond reproach. inappropriate behavior is often laughed.', NULL, 'accomodation', '', 'left', 'fa fa-500px', '', 0, 0, 1, 0, 0, 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int NOT NULL AUTO_INCREMENT,
  `customer_username` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer_password` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `customer_firstname` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer_lastname` varchar(50) NOT NULL,
  `customer_TCno` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer_address` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `customer_state` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `customer_city` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `customer_country` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `customer_telephone` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer_email` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_email` (`customer_email`),
  UNIQUE KEY `username` (`customer_username`),
  KEY `customer_email1` (`customer_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_username`, `customer_password`, `customer_firstname`, `customer_lastname`, `customer_TCno`, `customer_address`, `customer_state`, `customer_city`, `customer_country`, `customer_telephone`, `customer_email`) VALUES
(0, 'generic', NULL, 'Generic Customer', '(Unregistered)', '0', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL'),
(5, 'wilson', '28f20a02bf8a021fab4fcec48afb584e', 'Wilson', 'Samuel', '12323', NULL, NULL, 'Port', 'Nigeria', '090233232', 'mygames.ng@gmail.com'),
(6, 'daniel', NULL, 'Daniel', 'James', '123233', '13 one road ', 'Rivers', 'Port', 'Nigeria', '0903333', 'mygadmes.ng@gmail.com'),
(8, 'ogulor', NULL, 'Ogulor', 'Mornd', 'HRSC-AHY851', NULL, NULL, 'Lagos', 'Nigeria', '09033332222', 'seemygadmes@gmail.com'),
(17, 'davidson', '28f20a02bf8a021fab4fcec48afb584e', 'Daniel', 'James', 'HRSC-ZMHNP7347713-PHZ', 'Somewher off town', 'Mugan-Salyan', 'Calilabad', 'Azerbaijan', '09033332434', 'mygadmes.ngo@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(50) NOT NULL,
  `department_budget` float DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_budget`) VALUES
(9, 'Restuarants', 1000),
(10, 'Bar', 1000);

-- --------------------------------------------------------

--
-- Table structure for table `do_sport`
--

CREATE TABLE IF NOT EXISTS `do_sport` (
  `customer_id` int NOT NULL,
  `sportfacility_id` int NOT NULL,
  `dosport_date` varchar(50) NOT NULL,
  `employee_id` int DEFAULT NULL,
  `dosport_details` text,
  `dosport_price` float DEFAULT NULL,
  PRIMARY KEY (`customer_id`,`sportfacility_id`,`dosport_date`),
  KEY `customer` (`customer_id`),
  KEY `sport_facility` (`sportfacility_id`),
  KEY `employee` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `do_sport`
--
DELIMITER $$
CREATE TRIGGER `after_insert_sport_service` AFTER INSERT ON `do_sport` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price + NEW.dosport_price WHERE room_sales.customer_id = NEW.customer_id AND room_sales.checkin_date <= NEW.dosport_date AND room_sales.checkout_date >= NEW.dosport_date;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_delete_sport_service` BEFORE DELETE ON `do_sport` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price - OLD.dosport_price WHERE room_sales.customer_id = OLD.customer_id AND room_sales.checkin_date <= OLD.dosport_date AND room_sales.checkout_date >= OLD.dosport_date;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

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
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_id`, `employee_username`, `employee_password`, `employee_firstname`, `employee_lastname`, `employee_telephone`, `employee_email`, `employee_address`, `employee_country`, `employee_state`, `employee_city`, `department_id`, `role`, `role_id`, `employee_type`, `employee_salary`, `employee_hiring_date`) VALUES
(0, 'generic', '', 'Generic', 'Implementation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '', NULL, NULL),
(49, 'admin', '28f20a02bf8a021fab4fcec48afb584e', 'Obi', 'John', '09031983482', 'mygames.ng@gmail.com', 'Somewhere', 'Nigeria', 'Rivers', 'Omoku', 10, 1, 5, 'Executive', 1000, '2020-03-31'),
(50, 'davidson', '93349189c5d0219ba8b20ca7cbf068a1', 'Wilsons', 'Singer', '09031983343', 'hooliconschoo@gmail.com', NULL, NULL, NULL, NULL, 9, 1, 2, 'Staff', 1000, '2020-03-30'),
(53, 'root', '28f20a02bf8a021fab4fcec48afb584e', 'Sarahs', 'James', '07031983343', 'mygame@gmail.com', NULL, NULL, NULL, NULL, 9, 1, 0, 'Pageant', 1000, '2012/2/1'),
(67, 'bobby', '28f20a02bf8a021fab4fcec48afb584e', 'Iruruantaziba', 'Obi', '07431983656', 'hooliconschool@gmail.com', 'Home', 'Nigeria', 'Rivers', 'Port Harcourt', 9, 1, 0, 'Standard', 1000, '2020-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE IF NOT EXISTS `expenses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `subject` varchar(128) NOT NULL,
  `amount` int DEFAULT NULL,
  `remark` text NOT NULL,
  `employee_id` int NOT NULL,
  `date` date DEFAULT NULL,
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `subject`, `amount`, `remark`, `employee_id`, `date`) VALUES
(1, 'Welcome Fire', 1000, 'Check if the domain worked yesterdays before it was modified', 49, '2020-03-30'),
(3, 'Food was sold', 500, 'This is one entry', 49, '2020-04-15');

-- --------------------------------------------------------

--
-- Table structure for table `facilities`
--

CREATE TABLE IF NOT EXISTS `facilities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `details` text NOT NULL,
  `icon` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `title`, `details`, `icon`) VALUES
(1, 'Sports CLub', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', NULL),
(2, 'Sports CLub', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', NULL),
(3, 'Sports CLub', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', NULL),
(4, 'Sports CLub', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', NULL),
(5, 'Sports CLub', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', NULL),
(6, 'Sports CLub', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `get_medicalservice`
--

CREATE TABLE IF NOT EXISTS `get_medicalservice` (
  `customer_id` int NOT NULL,
  `medicalservice_id` int NOT NULL,
  `medicalservice_date` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `employee_id` int DEFAULT NULL,
  `getmedicalservice_details` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `medicalservice_price` float DEFAULT NULL,
  PRIMARY KEY (`customer_id`,`medicalservice_id`,`medicalservice_date`),
  KEY `customer` (`customer_id`),
  KEY `medical_service` (`medicalservice_id`),
  KEY `employee` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Triggers `get_medicalservice`
--
DELIMITER $$
CREATE TRIGGER `after_delete_medical_service` BEFORE DELETE ON `get_medicalservice` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price - OLD.medicalservice_price WHERE room_sales.customer_id = OLD.customer_id AND room_sales.checkin_date <= OLD.medicalservice_date AND room_sales.checkout_date >= OLD.medicalservice_date;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_insert_medical_service` AFTER INSERT ON `get_medicalservice` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price + NEW.medicalservice_price WHERE room_sales.customer_id = NEW.customer_id AND room_sales.checkin_date <= NEW.medicalservice_date AND room_sales.checkout_date >= NEW.medicalservice_date;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `get_roomservice`
--

CREATE TABLE IF NOT EXISTS `get_roomservice` (
  `customer_id` int NOT NULL,
  `roomservice_id` int NOT NULL,
  `roomservice_date` varchar(50) NOT NULL,
  `employee_id` int DEFAULT NULL,
  `getroomservice_details` text,
  `roomservice_price` float DEFAULT NULL,
  PRIMARY KEY (`customer_id`,`roomservice_id`,`roomservice_date`),
  KEY `customer` (`customer_id`),
  KEY `room_service` (`roomservice_id`),
  KEY `employee` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `get_roomservice`
--
DELIMITER $$
CREATE TRIGGER `after_insert_room_service` AFTER INSERT ON `get_roomservice` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price + NEW.roomservice_price WHERE room_sales.customer_id = NEW.customer_id AND room_sales.checkin_date <= NEW.roomservice_date AND room_sales.checkout_date >= NEW.roomservice_date;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_delete_room_service` BEFORE DELETE ON `get_roomservice` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price - OLD.roomservice_price WHERE room_sales.customer_id = OLD.customer_id AND room_sales.checkin_date <= OLD.roomservice_date AND room_sales.checkout_date >= OLD.roomservice_date;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `laundry`
--

CREATE TABLE IF NOT EXISTS `laundry` (
  `laundry_id` int NOT NULL AUTO_INCREMENT,
  `laundry_open_time` varchar(50) DEFAULT NULL,
  `laundry_close_time` varchar(50) DEFAULT NULL,
  `laundry_details` text,
  PRIMARY KEY (`laundry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `laundry_service`
--

CREATE TABLE IF NOT EXISTS `laundry_service` (
  `customer_id` int NOT NULL,
  `laundry_id` int NOT NULL,
  `employee_id` int DEFAULT NULL,
  `laundry_date` varchar(50) DEFAULT NULL,
  `laundry_amount` int DEFAULT NULL,
  `laundry_price` float DEFAULT NULL,
  PRIMARY KEY (`customer_id`,`laundry_id`),
  KEY `customer` (`customer_id`),
  KEY `laundry` (`laundry_id`),
  KEY `employee` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `laundry_service`
--
DELIMITER $$
CREATE TRIGGER `after_insert_laundry_service` AFTER INSERT ON `laundry_service` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price + NEW.laundry_price WHERE room_sales.customer_id = NEW.customer_id AND room_sales.checkin_date <= NEW.laundry_date AND room_sales.checkout_date >= NEW.laundry_date;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_delete_laundry_service` BEFORE DELETE ON `laundry_service` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price - OLD.laundry_price WHERE room_sales.customer_id = OLD.customer_id AND room_sales.checkin_date <= OLD.laundry_date AND room_sales.checkout_date >= OLD.laundry_date;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `massage_room`
--

CREATE TABLE IF NOT EXISTS `massage_room` (
  `massageroom_id` int NOT NULL AUTO_INCREMENT,
  `massageroom_open_time` varchar(10) DEFAULT NULL,
  `massageroom_close_time` varchar(10) DEFAULT NULL,
  `massageroom_details` text,
  PRIMARY KEY (`massageroom_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `massage_room`
--

INSERT INTO `massage_room` (`massageroom_id`, `massageroom_open_time`, `massageroom_close_time`, `massageroom_details`) VALUES
(2, '03:22', '14:22', 'Power');

-- --------------------------------------------------------

--
-- Table structure for table `massage_service`
--

CREATE TABLE IF NOT EXISTS `massage_service` (
  `customer_id` int NOT NULL,
  `massageroom_id` int NOT NULL,
  `employee_id` int DEFAULT NULL,
  `massage_date` varchar(50) DEFAULT NULL,
  `massage_details` text,
  `massage_price` float DEFAULT NULL,
  PRIMARY KEY (`customer_id`,`massageroom_id`),
  KEY `customer` (`customer_id`),
  KEY `massage` (`massageroom_id`),
  KEY `employee` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `massage_service`
--
DELIMITER $$
CREATE TRIGGER `after_insert_massage_service` AFTER INSERT ON `massage_service` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price + NEW.massage_price WHERE room_sales.customer_id = NEW.customer_id AND room_sales.checkin_date <= NEW.massage_date AND room_sales.checkout_date >= NEW.massage_date;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_delete_massage_service` BEFORE DELETE ON `massage_service` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price - OLD.massage_price WHERE room_sales.customer_id = OLD.customer_id AND room_sales.checkin_date <= OLD.massage_date AND room_sales.checkout_date >= OLD.massage_date;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `medical_service`
--

CREATE TABLE IF NOT EXISTS `medical_service` (
  `medicalservice_id` int NOT NULL AUTO_INCREMENT,
  `medicalservice_open_time` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `medicalservice_close_time` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `medicalservice_details` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  PRIMARY KEY (`medicalservice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

--
-- Dumping data for table `medical_service`
--

INSERT INTO `medical_service` (`medicalservice_id`, `medicalservice_open_time`, `medicalservice_close_time`, `medicalservice_details`) VALUES
(7, '01:00', '12:12', 'Health care is good');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `payment_type` varchar(128) DEFAULT NULL,
  `reference` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `reference` (`reference`,`customer_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `customer_id`, `payment_type`, `reference`, `amount`, `description`) VALUES
(1, 5, 'reservation', 'HRSPR-JRLEK5858431-RWT', '10000.00', 'Reservation payments for Presidential room 102'),
(2, 5, 'reservation', 'HRSPR-TOMLPJ747027-EGT', '10000.00', 'Reservation payments for Presidential room 101'),
(3, 5, 'reservation', 'HRSPR-5WDZ4C706108-VXE', '10000.00', 'Reservation payments for Presidential room 103');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `permissions` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `title`, `info`, `permissions`) VALUES
(2, 'Admin', 'This privilege grants the user all permissions', 'eyIwIjoiZGVmYXVsdCIsIjEiOiJkYXNoYm9hcmQiLCIyIjoicmVzZXJ2YXRpb24iLCIzIjoicm9vbXMiLCI0Ijoicm9vbS10eXBlcyIsIjUiOiJjdXN0b21lcnMiLCI2Ijoic2FsZXMtc2VydmljZXMiLCI3IjoiaW52ZW50b3J5IiwiOCI6InNhbGVzLXJlY29yZHMiLCI5Ijoic2VydmljZS1wb2ludCIsIjEwIjoiY2FzaGllci1yZXBvcnQiLCIxMSI6ImV4cGVuc2UtcmVnaXN0ZXIiLCIxMiI6InJlc2VydmVkLXJvb21zIiwiMTMiOiJtYW5hZ2UtZW1wbG95ZWUiLCIxNCI6Im1hbmFnZS1jb25maWd1cmF0aW9uIiwiMTUiOiJtYW5hZ2UtcHJpdmlsZWdlIiwiMTYiOiJtYW5hZ2UtcGFnZXMifQ=='),
(5, 'Default', 'The default permission', 'eyIwIjoiZGVmYXVsdCJ9');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE IF NOT EXISTS `reservation` (
  `reservation_id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `room_id` int NOT NULL,
  `checkin_date` datetime NOT NULL,
  `checkout_date` datetime DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `reservation_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `reservation_price` float DEFAULT NULL,
  `reservation_ref` varchar(128) DEFAULT NULL,
  `status` int DEFAULT NULL,
  PRIMARY KEY (`reservation_id`,`customer_id`,`room_id`,`checkin_date`) USING BTREE,
  UNIQUE KEY `reservation_ref` (`reservation_ref`),
  KEY `customer` (`customer_id`),
  KEY `employee` (`employee_id`),
  KEY `room` (`room_id`),
  KEY `availability` (`room_id`,`checkin_date`,`checkout_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `customer_id`, `room_id`, `checkin_date`, `checkout_date`, `employee_id`, `reservation_price`, `reservation_ref`, `status`) VALUES
(10, 8, 102, '2020-04-03 00:00:00', '2020-04-04 00:00:00', 49, 10000, 'HRSPR-JRLEK5858431-RWT', NULL),
(11, 5, 3, '2020-04-01 00:00:00', '2020-04-03 00:00:00', 49, 5000, NULL, NULL),
(12, 6, 3, '2020-04-12 00:00:00', '2020-04-18 00:00:00', 49, 5000, NULL, NULL),
(17, 5, 3, '2020-04-07 09:45:00', '2020-04-10 11:55:00', 0, 5000, NULL, NULL),
(18, 17, 105, '2020-04-15 13:45:00', '2020-04-23 14:50:00', 0, 10000, NULL, NULL),
(20, 5, 2, '2020-04-06 00:00:00', '2020-04-08 00:00:00', 49, 5000, '', NULL),
(21, 5, 101, '2020-04-15 13:45:00', '2020-04-30 18:50:00', 0, 10000, 'HRSPR-TOMLPJ747027-EGT', 1),
(22, 5, 103, '2020-04-15 13:45:00', '2020-04-23 14:50:00', 0, 10000, 'HRSPR-5WDZ4C706108-VXE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `room_id` int NOT NULL AUTO_INCREMENT,
  `room_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`room_id`),
  KEY `room_type` (`room_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_type`) VALUES
(1, 'Delux'),
(2, 'Delux'),
(3, 'Delux'),
(101, 'Presidential'),
(102, 'Presidential'),
(103, 'Presidential'),
(104, 'Presidential'),
(105, 'Presidential');

--
-- Triggers `room`
--
DELIMITER $$
CREATE TRIGGER `after_insert_room` AFTER INSERT ON `room` FOR EACH ROW BEGIN
    UPDATE room_type SET room_type.room_quantity =room_type.room_quantity + 1 WHERE room_type.room_type = NEW.room_type;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_delete_room` BEFORE DELETE ON `room` FOR EACH ROW BEGIN
    UPDATE room_type SET room_type.room_quantity =room_type.room_quantity - 1 WHERE room_type.room_type = OLD.room_type;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `room_sales`
--

CREATE TABLE IF NOT EXISTS `room_sales` (
  `customer_id` int NOT NULL,
  `room_id` int NOT NULL,
  `reservation_id` int DEFAULT NULL,
  `checkin_date` varchar(50) NOT NULL,
  `checkout_date` varchar(50) DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  `room_sales_price` float DEFAULT NULL,
  `total_service_price` float DEFAULT NULL,
  PRIMARY KEY (`customer_id`,`checkin_date`,`room_id`) USING BTREE,
  KEY `employee` (`employee_id`),
  KEY `room` (`room_id`),
  KEY `availability` (`room_id`,`checkin_date`,`checkout_date`),
  KEY `customer` (`customer_id`),
  KEY `reservation_id` (`reservation_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `room_sales`
--

INSERT INTO `room_sales` (`customer_id`, `room_id`, `reservation_id`, `checkin_date`, `checkout_date`, `employee_id`, `room_sales_price`, `total_service_price`) VALUES
(5, 3, 11, '2020-04-01', '2020-04-03', 49, 5000, 3100),
(5, 2, 20, '2020-04-06', '2020-04-08', 49, 5000, 0),
(5, 3, 17, '2020-04-07 09:45', '2020-04-10 11:55', 0, 5000, 0),
(5, 101, 21, '2020-04-15 13:45', '2020-04-30 18:50', 0, 10000, 0),
(5, 103, 22, '2020-04-15 13:45', '2020-04-23 14:50', 0, 10000, 0),
(6, 3, 12, '2020-04-12', '2020-04-18', 49, 5000, 0),
(8, 102, 10, '2020-04-03', '2020-04-04', 49, 10000, 0),
(17, 105, 18, '2020-04-15 13:45', '2020-04-23 14:50', 0, 10000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_service`
--

CREATE TABLE IF NOT EXISTS `room_service` (
  `roomservice_id` int NOT NULL AUTO_INCREMENT,
  `roomservice_open_time` varchar(50) DEFAULT NULL,
  `roomservice_close_time` varchar(50) DEFAULT NULL,
  `roomservice_floor` varchar(50) DEFAULT NULL,
  `roomservice_details` text,
  PRIMARY KEY (`roomservice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--

CREATE TABLE IF NOT EXISTS `room_type` (
  `room_type` varchar(50) NOT NULL,
  `room_price` int DEFAULT NULL,
  `room_details` text,
  `room_quantity` int DEFAULT NULL,
  `wifi` int NOT NULL DEFAULT '0',
  `pool` int NOT NULL DEFAULT '0',
  `room_service` int NOT NULL DEFAULT '0',
  `image` varchar(128) DEFAULT NULL,
  `max_adults` int NOT NULL DEFAULT '1',
  `max_kids` int NOT NULL DEFAULT '1',
  `vat` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`room_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`room_type`, `room_price`, `room_details`, `room_quantity`, `wifi`, `pool`, `room_service`, `image`, `max_adults`, `max_kids`, `vat`) VALUES
('Delux', 5000, 'This is a beautiful room', NULL, 1, 0, 0, NULL, 3, 3, 0),
('Executive', 3000, 'This is the best affordable room in the suite', NULL, 1, 1, 0, NULL, 1, 1, 0),
('Presidential', 10000, 'This rooms are reserved for the president', NULL, 1, 1, 1, NULL, 1, 1, 0),
('Standard', 30003, 'Good rooms are quite expensive', NULL, 1, 0, 1, NULL, 4, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_services`
--

CREATE TABLE IF NOT EXISTS `sales_services` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `service_open_time` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `service_close_time` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `service_details` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `table_count` int NOT NULL DEFAULT '0',
  `icon` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`service_name`,`id`) USING BTREE,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `sales_services`
--

INSERT INTO `sales_services` (`id`, `service_name`, `service_open_time`, `service_close_time`, `service_details`, `table_count`, `icon`) VALUES
(10, 'Gym', '00:32', '15:33', 'Come and try to look good', 3, NULL),
(8, 'Restuarant', '00:21', '12:21', 'Eat good food always', 10, 'utensils'),
(9, 'Wine Bar', '00:11', '12:22', 'Drink to stupor', 1, 'fa-glass');

-- --------------------------------------------------------

--
-- Table structure for table `sales_service_orders`
--

CREATE TABLE IF NOT EXISTS `sales_service_orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `service_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `customer_id` int NOT NULL,
  `order_items` varchar(255) DEFAULT NULL,
  `order_quantity` varchar(128) DEFAULT NULL,
  `order_date` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ordered_datetime` datetime DEFAULT CURRENT_TIMESTAMP,
  `order_price` float DEFAULT NULL,
  `employee_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `restaurant` (`service_name`),
  KEY `customer` (`customer_id`),
  KEY `book_date` (`order_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `sales_service_orders`
--

INSERT INTO `sales_service_orders` (`id`, `service_name`, `customer_id`, `order_items`, `order_quantity`, `order_date`, `order_price`, `employee_id`) VALUES
(60, 'Wine Bar', 5, '6,9', '1,1', '2020-04-01', 1600, 49),
(61, 'Restuarant', 5, '7', '1', '2020-04-02', 1500, 49);

--
-- Triggers `sales_service_orders`
--
DELIMITER $$
CREATE TRIGGER `after_add_sales_services` AFTER INSERT ON `sales_service_orders` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price + NEW.order_price WHERE room_sales.customer_id = NEW.customer_id AND room_sales.checkin_date <= NEW.order_date AND room_sales.checkout_date >= NEW.order_date;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_delete_sales_service` BEFORE DELETE ON `sales_service_orders` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price - OLD.order_price WHERE room_sales.customer_id = OLD.customer_id AND room_sales.checkin_date <= OLD.order_date AND room_sales.checkout_date >= OLD.order_date;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sales_service_stock`
--

CREATE TABLE IF NOT EXISTS `sales_service_stock` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `item_details` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `item_quantity` int NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_service` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `item_add_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `employee_id` int DEFAULT NULL,
  PRIMARY KEY (`item_id`,`item_name`,`item_service`),
  KEY `item_restaurant` (`item_service`),
  KEY `item_name` (`item_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales_service_stock`
--

INSERT INTO `sales_service_stock` (`item_id`, `item_name`, `item_details`, `item_quantity`, `item_price`, `item_service`, `employee_id`) VALUES
(6, 'Corona Extra', 'Get High even faster', 3, '600.00', 'Wine Bar', 49),
(7, 'Pounded Yam', 'Eat heavily pounded food', 4, '1500.00', 'Restuarant', NULL),
(9, 'Origin Bitters', 'Get high enough', 1, '1000.00', 'Wine Bar', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `setting_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('primary_server', 'toneflix.com.ng'),
('server_dir', 'toneflix.com.ng'),
('site_name', 'Passcontest V2'),
('payment_ref_pref', 'HSPR-'),
('cpanel_user', 'collaged'),
('cpanel_pass', 'idontknowmypassword1A@'),
('site_currency', 'NGN'),
('ip_interval', '2'),
('currency_symbol', '₦'),
('site_logo', 'uploads/site/site_logo_514547749.png'),
('contact_email', 'mygames.ng@gmail.com'),
('contact_phone', '09031987876'),
('contact_address', '13 Somewhere in kaduna'),
('contact_facebook', 'https://facebook.com/hoolicon'),
('contact_twitter', ''),
('checkout_info', 'In the above code you’ll notice a pair of variables. In a case like this, the entire chunk of data between these pairs would be repeated multiple times, corresponding to the number of rows in the “blog_entries” element of the parameters array.'),
('paystack_public', 'pk_test_36a1170f08ef500b7c55315ea6792864953b4ca0'),
('paystack_secret', 'sk_test_bbc81f998f1151d1d34f8ff0e4ae4ef1fa3a9784'),
('credit_name', 'Voting Credit'),
('credit_code', 'VC'),
('credit_rate', '5'),
('credit_bonus', '1'),
('credit_units', '1000,500,800,2000,900,350'),
('restrict_creation', '1');

-- --------------------------------------------------------

--
-- Table structure for table `sport_facilities`
--

CREATE TABLE IF NOT EXISTS `sport_facilities` (
  `sportfacility_id` int NOT NULL AUTO_INCREMENT,
  `sportfacility_open_time` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `sportfacility_close_time` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `sportfacility_details` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  PRIMARY KEY (`sportfacility_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sport_facilities`
--

INSERT INTO `sport_facilities` (`sportfacility_id`, `sportfacility_open_time`, `sportfacility_close_time`, `sportfacility_details`) VALUES
(4, '02:32', '00:32', 'Gymn'),
(5, '06:24', '15:24', 'Pool');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `do_sport`
--
ALTER TABLE `do_sport`
  ADD CONSTRAINT `do_sport_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `do_sport_ibfk_2` FOREIGN KEY (`sportfacility_id`) REFERENCES `sport_facilities` (`sportfacility_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `do_sport_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `sales_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `get_medicalservice`
--
ALTER TABLE `get_medicalservice`
  ADD CONSTRAINT `get_medicalservice_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `get_medicalservice_ibfk_2` FOREIGN KEY (`medicalservice_id`) REFERENCES `medical_service` (`medicalservice_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `get_medicalservice_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `get_roomservice`
--
ALTER TABLE `get_roomservice`
  ADD CONSTRAINT `get_roomservice_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `get_roomservice_ibfk_2` FOREIGN KEY (`roomservice_id`) REFERENCES `room_service` (`roomservice_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `get_roomservice_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `laundry_service`
--
ALTER TABLE `laundry_service`
  ADD CONSTRAINT `laundry_service_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laundry_service_ibfk_2` FOREIGN KEY (`laundry_id`) REFERENCES `laundry` (`laundry_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `laundry_service_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `massage_service`
--
ALTER TABLE `massage_service`
  ADD CONSTRAINT `massage_service_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `massage_service_ibfk_2` FOREIGN KEY (`massageroom_id`) REFERENCES `massage_room` (`massageroom_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `massage_service_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`room_type`) REFERENCES `room_type` (`room_type`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room_sales`
--
ALTER TABLE `room_sales`
  ADD CONSTRAINT `room_sales_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_sales_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_sales_ibfk_3` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`employee_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `room_sales_ibfk_4` FOREIGN KEY (`reservation_id`) REFERENCES `reservation` (`reservation_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_service_orders`
--
ALTER TABLE `sales_service_orders`
  ADD CONSTRAINT `sales_service_orders_ibfk_1` FOREIGN KEY (`service_name`) REFERENCES `sales_services` (`service_name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sales_service_orders_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sales_service_stock`
--
ALTER TABLE `sales_service_stock`
  ADD CONSTRAINT `sales_service_rtv` FOREIGN KEY (`item_service`) REFERENCES `sales_services` (`service_name`) ON DELETE CASCADE ON UPDATE CASCADE;
