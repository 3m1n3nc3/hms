-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 10, 2020 at 09:27 AM
-- Server version: 8.0.19-0ubuntu0.19.10.3
-- PHP Version: 7.2.24-0ubuntu0.19.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `hmsystem`
--
CREATE DATABASE IF NOT EXISTS `hmsystem` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `hmsystem`; 

--
-- Table structure for table `content`
--
-- Creation: Apr 03, 2020 at 01:45 PM
--

DROP TABLE IF EXISTS `content`;
CREATE TABLE IF NOT EXISTS `content` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `intro` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `banner` varchar(255) DEFAULT NULL,
  `safelink` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `button` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `align` varchar(128) DEFAULT NULL,
  `icon` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONS FOR TABLE `content`:
--

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `intro`, `content`, `banner`, `safelink`, `button`, `align`, `icon`, `color`, `in_header`, `in_footer`, `priority`, `rooms`, `booking`, `facilities`, `contact`, `parent`) VALUES
(1, 'Welcome to Hayatt', 'This is the official toneflix account, follow for good updates!', 'If you use a select menu, this function permits you to display the menu item that was selected.d\r\n\r\nThe first parameter must contain the name of the select menu, the second parameter must contain the value of each item, and the third (optional) parameter lets you set an item as the default (use boolean TRUE/FALSE).', 'uploads/covers/page/318207262_857056997_1769914096_p.png', 'homepage', '[link=https://yahoo.com] red color[/link]', 'left', 'fa fa-500px', 'text-info', 1, 1, 2, 1, 1, 1, 0, ''),
(8, 'Boostrap classes', 'Official toneflix account, follow for good updates!', 'The first parameter must contain the name of the select menu, the second parameter must contain the value of each item, and the third (optional) parameter lets you set an item as the default (use boolean TRUE/FALSE). [link=https://example.com] Example[/link]', 'uploads/covers/qwqw/1375639490_486482779_1544318135_p.png', 'safelinkercs', '[link=https://example.com] Example[/link]', 'right', 'fa fa-500px', 'danger', 0, 0, 2, 0, 0, 0, 0, 'homepage'),
(14, 'We put you first', 'Setting preferences in a config file', 'If you prefer not to set preferences using the above method, you can instead put them into a config file. Simply create a new file called the upload.php, add the $config array in that file. Then save the file in: config/upload.php and it will be used automatically.', 'uploads/covers/page/1254578127_838910178_1203441872_p.png', 'we-put-you-first', '', 'left', 'fa fa-users', '', 0, 0, 1, 0, 0, 0, 0, 'homepage');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--
-- Creation: Apr 08, 2020 at 09:22 AM
--

DROP TABLE IF EXISTS `customer`;
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
  `image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`customer_id`),
  UNIQUE KEY `customer_email` (`customer_email`),
  UNIQUE KEY `username` (`customer_username`),
  KEY `customer_email1` (`customer_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `customer`:
--

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `customer_username`, `customer_password`, `customer_firstname`, `customer_lastname`, `customer_TCno`, `customer_address`, `customer_state`, `customer_city`, `customer_country`, `customer_telephone`, `customer_email`, `image`) VALUES
(0, 'generic', NULL, 'Generic Customer', '(Unregistered)', '0', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', NULL),
(5, 'wilson', '28f20a02bf8a021fab4fcec48afb584e', 'Wilson', 'Samuel', '12323', 'This is my address', 'Vorarlberg', 'Rankweil', 'Afghanistan', '090233232', 'mygames.ng@gmail.com', 'uploads/avatars/wilson/1552177901_1889236005_1834033459_p.png'),
(6, 'daniel', NULL, 'Daniel', 'James', '123233', '13 one road ', 'Rivers', 'Port', 'Nigeria', '0903333', 'mygadmes.ng@gmail.com', NULL),
(8, 'ogulor', NULL, 'Ogulor', 'Mornd', 'HRSC-AHY851', NULL, NULL, 'Lagos', 'Nigeria', '09033332222', 'seemygadmes@gmail.com', NULL),
(17, 'davidson', '28f20a02bf8a021fab4fcec48afb584e', 'Daniel', 'James', 'HRSC-ZMHNP7347713-PHZ', 'Somewher off town', 'Mugan-Salyan', 'Calilabad', 'Azerbaijan', '09033332434', 'mygadmes.ngo@gmail.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `department`
--
-- Creation: Mar 18, 2020 at 02:49 PM
--

DROP TABLE IF EXISTS `department`;
CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int NOT NULL AUTO_INCREMENT,
  `department_name` varchar(50) NOT NULL,
  `department_budget` float DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `department`:
--

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`department_id`, `department_name`, `department_budget`) VALUES
(9, 'Restuarants', 1000),
(10, 'Bar', 1000);
 
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
(0, 'generic', '', 'Generic', 'Employee', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, '', NULL, NULL), 
(1, 'root', '28f20a02bf8a021fab4fcec48afb584e', 'Root', 'Admin', '', 'root@root', NULL, NULL, NULL, NULL, 9, '', 3, 0, 'Root', 1000, '2012/2/1'),
(2, 'admin', '5f4dcc3b5aa765d61d8327deb882cf99', 'Default', 'Admin', '', 'admin@admin', '', '', '', '', 10, '', 2, 5, 'Administrator', 1000, '2020-03-31');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--
-- Creation: Mar 30, 2020 at 05:06 PM
--

DROP TABLE IF EXISTS `expenses`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONS FOR TABLE `expenses`:
--

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
-- Creation: Apr 03, 2020 at 09:22 AM
--

DROP TABLE IF EXISTS `facilities`;
CREATE TABLE IF NOT EXISTS `facilities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `details` text NOT NULL,
  `icon` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONS FOR TABLE `facilities`:
--

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `title`, `details`, `icon`) VALUES
(3, 'Sports CLub', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', 'fa fa-angle-double-right'),
(4, 'Sports CLub', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', NULL),
(8, 'Pickup Services', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', 'fa fa-address-card'),
(9, 'Sports CLub', 'Usage of the Internet is becoming more common due to rapid advancement of technology and power.', 'fa fa-adjust'),
(10, 'This is a working facility', 'This should work very well for now yes', 'fa fa-thumbs-up'),
(12, 'Rockwell Solution', 'You’ll notice we are using a form helper to create the opening form tag. File uploads require a multipart form, so the helper creates the proper syntax for you. You’ll also notice we have an $error variable. This is so we can show error messages in the event the user does something wrong.', 'fa fa-angle-double-right');
 
-- --------------------------------------------------------

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `payment_type` varchar(128) DEFAULT NULL,
  `reference` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `invoice` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `reference` (`reference`,`customer_id`) USING BTREE,
  KEY `invoice` (`invoice`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `payments`:
--

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `customer_id`, `payment_type`, `reference`, `invoice`, `amount`, `description`) VALUES
(4, 5, 'reservation', 'HRSPR-NHBAM1420531-SVT', '1212121212333333', '10000.00', 'Reservation payments for Presidential room 103');

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--
-- Creation: Apr 01, 2020 at 08:48 AM
--

DROP TABLE IF EXISTS `privileges`;
CREATE TABLE IF NOT EXISTS `privileges` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `info` text CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `permissions` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

--
-- RELATIONS FOR TABLE `privileges`:
--

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `title`, `info`, `permissions`) VALUES
(2, 'Admin', 'This privilege grants the user all permissions', 'eyIwIjoibWFuYWdlLXByaXZpbGVnZSIsIjEiOiJyb29tcyIsIjIiOiJyb29tLXNhbGVzIiwiMyI6InJvb20tdHlwZXMiLCI0IjoiY3VzdG9tZXJzIn0='),
(5, 'Default', 'The default permission', 'eyIwIjoiZGVmYXVsdCJ9'),
(6, 'Super User', 'This privilege grants user permission to become awsome', 'eyIwIjoiZGVmYXVsdCIsIjEiOiJkYXNoYm9hcmQifQ==');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--
-- Creation: Apr 05, 2020 at 05:23 PM
--

DROP TABLE IF EXISTS `reservation`;
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
-- RELATIONS FOR TABLE `reservation`:
--   `customer_id`
--       `customer` -> `customer_id`
--   `room_id`
--       `room` -> `room_id`
--   `employee_id`
--       `employee` -> `employee_id`
--

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `customer_id`, `room_id`, `checkin_date`, `checkout_date`, `employee_id`, `reservation_price`, `reservation_ref`, `status`) VALUES
(23, 5, 103, '2020-04-15 13:45:00', '2020-04-30 18:50:00', 0, 10000, 'HRSPR-NHBAM1420531-SVT', 1),
(24, 5, 2, '2020-04-07 00:00:00', '2020-04-09 00:00:00', 49, 5000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--
-- Creation: Mar 18, 2020 at 02:54 PM
--

DROP TABLE IF EXISTS `room`;
CREATE TABLE IF NOT EXISTS `room` (
  `room_id` int NOT NULL AUTO_INCREMENT,
  `room_type` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`room_id`),
  KEY `room_type` (`room_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- RELATIONS FOR TABLE `room`:
--   `room_type`
--       `room_type` -> `room_type`
--

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
DROP TRIGGER IF EXISTS `after_insert_room`;
DELIMITER $$
CREATE TRIGGER `after_insert_room` AFTER INSERT ON `room` FOR EACH ROW BEGIN
    UPDATE room_type SET room_type.room_quantity =room_type.room_quantity + 1 WHERE room_type.room_type = NEW.room_type;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_delete_room`;
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
-- Creation: Apr 05, 2020 at 05:14 PM
--

DROP TABLE IF EXISTS `room_sales`;
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
-- RELATIONS FOR TABLE `room_sales`:
--   `customer_id`
--       `customer` -> `customer_id`
--   `room_id`
--       `room` -> `room_id`
--   `employee_id`
--       `employee` -> `employee_id`
--   `reservation_id`
--       `reservation` -> `reservation_id`
--

--
-- Dumping data for table `room_sales`
--

INSERT INTO `room_sales` (`customer_id`, `room_id`, `reservation_id`, `checkin_date`, `checkout_date`, `employee_id`, `room_sales_price`, `total_service_price`) VALUES
(5, 2, 24, '2020-04-07', '2020-04-09', 49, 5000, 0),
(5, 103, 23, '2020-04-15 13:45', '2020-04-30 18:50', 0, 10000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `room_type`
--
-- Creation: Apr 06, 2020 at 02:54 AM
--

DROP TABLE IF EXISTS `room_type`;
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
-- RELATIONS FOR TABLE `room_type`:
--

--
-- Dumping data for table `room_type`
--

INSERT INTO `room_type` (`room_type`, `room_price`, `room_details`, `room_quantity`, `wifi`, `pool`, `room_service`, `image`, `max_adults`, `max_kids`, `vat`) VALUES
('Delux', 5000, 'This is a beautiful room', NULL, 1, 0, 0, 'uploads/covers/room/2146741816_889742929_1411682333_p.png', 3, 3, 0),
('Executive', 3000, 'This is the best affordable room in the suite', NULL, 1, 1, 0, NULL, 1, 1, 0),
('Presidential', 10000, 'This rooms are reserved for the president', NULL, 1, 1, 1, NULL, 1, 1, 0),
('Standard', 30003, 'Good rooms are quite expensive', NULL, 1, 0, 1, NULL, 4, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales_services`
--
-- Creation: Apr 01, 2020 at 08:12 AM
--

DROP TABLE IF EXISTS `sales_services`;
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
-- RELATIONS FOR TABLE `sales_services`:
--

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
-- Creation: Mar 28, 2020 at 12:24 PM
--

DROP TABLE IF EXISTS `sales_service_orders`;
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
-- RELATIONS FOR TABLE `sales_service_orders`:
--   `service_name`
--       `sales_services` -> `service_name`
--   `customer_id`
--       `customer` -> `customer_id`
--

--
-- Dumping data for table `sales_service_orders`
--

INSERT INTO `sales_service_orders` (`id`, `service_name`, `customer_id`, `order_items`, `order_quantity`, `order_date`, `order_price`, `employee_id`) VALUES
(60, 'Wine Bar', 5, '6,9', '1,1', '2020-04-01', 1600, 49);

--
-- Triggers `sales_service_orders`
--
DROP TRIGGER IF EXISTS `after_add_sales_services`;
DELIMITER $$
CREATE TRIGGER `after_add_sales_services` AFTER INSERT ON `sales_service_orders` FOR EACH ROW BEGIN
    UPDATE room_sales SET room_sales.total_service_price = room_sales.total_service_price + NEW.order_price WHERE room_sales.customer_id = NEW.customer_id AND room_sales.checkin_date <= NEW.order_date AND room_sales.checkout_date >= NEW.order_date;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `before_delete_sales_service`;
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
-- Creation: Mar 28, 2020 at 12:25 PM
--

DROP TABLE IF EXISTS `sales_service_stock`;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- RELATIONS FOR TABLE `sales_service_stock`:
--   `item_service`
--       `sales_services` -> `service_name`
--

--
-- Dumping data for table `sales_service_stock`
--

INSERT INTO `sales_service_stock` (`item_id`, `item_name`, `item_details`, `item_quantity`, `item_price`, `item_service`, `employee_id`) VALUES
(6, 'Corona Extra', 'Get High even faster', 3, '600.00', 'Wine Bar', 49),
(7, 'Pounded Yam', 'Eat heavily pounded food', 4, '1500.00', 'Restuarant', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--
-- Creation: Apr 06, 2020 at 01:23 AM
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `setting_key` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `setting_value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- RELATIONS FOR TABLE `settings`:
--

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES
('site_name', 'Hayatt Regency Suites'),
('payment_ref_pref', 'HSPRS-'),
('site_currency', 'NGN'),
('ip_interval', '2'),
('currency_symbol', '₦'),
('site_logo', 'uploads/sites/site_logo.png'),
('contact_email', 'hayattregencysuites@gmail.com'),
('contact_phone', '09031987876'),
('contact_address', '13 Somewhere in kaduna'),
('contact_facebook', 'https://facebook.com/hayatt'),
('checkout_info', 'In the above code you’ll notice a pair of variables. In a case like this, the entire chunk of data between these pairs would be repeated multiple times, corresponding to the number of rows in the “blog_entries” element of the parameters array.'),
('paystack_public', 'pk_test_36a1170f08ef500b7c55315ea6792864953b4ca0'),
('paystack_secret', 'sk_test_bbc81f998f1151d1d34f8ff0e4ae4ef1fa3a9784'),
('restrict_creation', '1'),
('contact_twitter', 'https://twitter.com/hayattregencysuites'),
('contact_instagram', 'https://instagram.com/hayattregency'),
('contact_days', 'Mon to Fri 9am to 6 pm'),
('site_name_abbr', 'HRSHMS'),
('facilities_banner', 'uploads/sites/features_banner.jpg'),
('features_banner', 'uploads/sites/features_banner.jpg'),
('breadcrumb_banner', 'uploads/sites/breadcrumb_banner.jpeg'),
('favicon', 'uploads/sites/favicon.jpg'),
('facilities_title', 'Hayatt Regency Suites Facilities'),
('facilities_content', 'We have all it takes to give you all you need!');

-- --------------------------------------------------------
 
--
-- Constraints for dumped tables
-- 

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `sales_services` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
  
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
