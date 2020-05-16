ALTER TABLE `sales_service_orders` ADD `paid` TEXT NULL DEFAULT NULL AFTER `employee_id`;
ALTER TABLE `reservation` CHANGE `status` `status` INT(4) NULL DEFAULT '0';
ALTER TABLE `room_sales` ADD `status` INT(4) NOT NULL DEFAULT '0' AFTER `total_service_price`;
ALTER TABLE `reservation` ADD INDEX(`status`);
ALTER TABLE `room_sales` ADD INDEX(`status`);
