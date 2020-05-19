ALTER TABLE `sales_service_orders` 
    ADD `paid` TEXT NULL DEFAULT NULL AFTER `employee_id`;

ALTER TABLE `reservation` 
    CHANGE `status` `status` INT(4) NULL DEFAULT '0';

ALTER TABLE `room_sales` 
    ADD `status` INT(4) NOT NULL DEFAULT '0' AFTER `total_service_price`;
ALTER TABLE `room_sales` 
    CHANGE `checkin_date` `checkin_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `room_sales` 
    CHANGE `checkout_date` `checkout_date` DATETIME NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `reservation` 
    ADD `coming_from` VARCHAR(255) NULL DEFAULT NULL AFTER `checkout_date`, 
    ADD `destination` VARCHAR(255) NULL DEFAULT NULL AFTER `coming_from`, 
    ADD INDEX `from` (`coming_from`), 
    ADD INDEX `destination` (`destination`);

ALTER TABLE `customer` 
    ADD `customer_nationality` VARCHAR(128) NULL DEFAULT NULL AFTER `customer_country`, 
    ADD `customer_passport_no` VARCHAR(255) NULL DEFAULT NULL AFTER `customer_nationality`,
    ADD `passport` VARCHAR(255) NULL DEFAULT NULL AFTER `customer_email`;

ALTER TABLE `settings` 
    ADD `id` INT(11) NOT NULL AUTO_INCREMENT FIRST, 
    ADD PRIMARY KEY (`id`);

ALTER TABLE `reservation` 
    ADD `adults` INT(11) NOT NULL DEFAULT '0' AFTER `checkout_date`, 
    ADD `children` INT(11) NOT NULL DEFAULT '0' AFTER `adults`;

CREATE TABLE IF NOT EXISTS `notifications` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `notifier_id` int(11) NOT NULL DEFAULT '0',
    `notifier_type` text,
    `recipient_id` int(11) NOT NULL DEFAULT '0',
    `type` varchar(100) NOT NULL DEFAULT '',
    `text` text,
    `url` varchar(3000) NOT NULL DEFAULT '',
    `seen` varchar(50) NOT NULL DEFAULT '0',
    `time` varchar(50) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`),
    KEY `recipient_id` (`recipient_id`),
    KEY `type` (`type`),
    KEY `notifier_id` (`notifier_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

