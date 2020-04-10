 
DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `get_available_rooms`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_available_rooms` (IN `o_room_type` VARCHAR(50), IN `o_checkin_date` VARCHAR(50), IN `o_checkout_date` VARCHAR(50), IN `o_adults` INT(11) ZEROFILL, IN `o_children` INT(11) ZEROFILL)  BEGIN
    SELECT * FROM `room` LEFT JOIN `room_type` ON `room`.`room_type` = `room_type`.`room_type` 
    WHERE room.room_type=o_room_type AND room_type.max_adults>=o_adults AND room_type.max_kids>=o_children AND NOT EXISTS (
        SELECT room_id FROM reservation WHERE reservation.room_id=room.room_id AND checkout_date >= o_checkin_date AND checkin_date <= o_checkout_date
        UNION ALL
        SELECT room_id FROM room_sales WHERE room_sales.room_id=room.room_id AND checkout_date >= o_checkin_date AND checkin_date <= o_checkout_date
    );
END$$

DROP PROCEDURE IF EXISTS `get_customers`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `get_customers` (IN `today_date` VARCHAR(50))  BEGIN
SELECT * FROM `room_sales` NATURAL JOIN `customer` WHERE checkout_date >= today_date AND checkin_date <= today_date;
END$$

DROP PROCEDURE IF EXISTS `todays_service_count`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `todays_service_count` (IN `today_date` VARCHAR(50))  BEGIN
SELECT count(*) as amount, "laundry" as type FROM laundry_service WHERE laundry_date=today_date UNION ALL SELECT count(*) as amount, "massage" as type FROM massage_service WHERE massage_date=today_date UNION ALL SELECT count(*) as amount, "roomservice" as type FROM get_roomservice WHERE roomservice_date=today_date UNION ALL SELECT count(*) as amount, "medicalservice" as type FROM get_medicalservice WHERE medicalservice_date=today_date UNION ALL SELECT count(*) as amount, "sport" as type FROM do_sport WHERE dosport_date=today_date
UNION ALL SELECT count(*) as amount, "restaurant" as type FROM sales_service_orders WHERE order_date=today_date;
END$$

DELIMITER ;

-- --------------------------------------------------------
 
